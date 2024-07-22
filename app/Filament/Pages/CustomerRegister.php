<?php

namespace App\Filament\Pages;

use Afsakar\FilamentOtpLogin\Filament\Forms\OtpInput;
use Afsakar\FilamentOtpLogin\Models\OtpCode;
use Afsakar\FilamentOtpLogin\Notifications\SendOtpCode;
use App\Filament\Notifications\RegisterSubmit;
use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;
use App\Models\Country;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\Concerns\CanUseDatabaseTransactions as ConcernsCanUseDatabaseTransactions;
use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions\Action as ActionComponent;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Auth\VerifyEmail;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Filament\Pages\Concerns\CanUseDatabaseTransactions;

use function Laravel\Prompts\select;

/**
 * @property Form $form
 */
class CustomerRegister extends Register
{
    use CanUseDatabaseTransactions;
    use InteractsWithFormActions;
    use WithRateLimiting;
    use Notifiable;

    protected static string $view = 'filament-otp-login::pages.register';
    protected string $userModel;
    public ?array $data = [];

    public int $step = 1;

    public int | string $otpCode = '';

    public string $email = '';

    public string $name = '';

    public int $countDown = 120;

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->callHook('beforeFill');

        $this->form->fill();

        $this->callHook('afterFill');
    }

    protected function rateLimiter()
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }
    }

    public function register(): ?RegistrationResponse
    {
        $this->rateLimiter();

        $this->verifyCode();

        $this->doRegister();

        

        return app(RegistrationResponse::class);
    }

    protected function doRegister(): void
    {
        $user = $this->wrapInDatabaseTransaction(function () {

            $this->notify(new RegisterSubmit());

            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeRegister($data);

            $this->callHook('beforeRegister');

            $user = $this->handleRegistration($data);

            $this->form->model($user)->saveRelationships();

            $this->callHook('afterRegister');

            return $user;
        });

        event(new Registered($user));

        $this->sendEmailVerificationNotification($user);

        Filament::auth()->login($user);

        session()->regenerate();

        // return app(RegistrationResponse::class);
    }

    public function verifyCode(): void
    {
        $code = OtpCode::whereCode($this->data['otp'])->first();

        if (! $code) {
            throw ValidationException::withMessages([
                'data.otp' => __('filament-otp-login::translations.validation.invalid_code'),
            ]);
        } elseif (! $code->isValid()) {
            throw ValidationException::withMessages([
                'data.otp' => __('filament-otp-login::translations.validation.expired_code'),
            ]);
        } else {
            $this->dispatch('codeVerified');

            $code->delete();
        }
    }

    public function generateCode(): void
    {
        do {
            $length = config('filament-otp-login.otp_code.length');

            $code = str_pad(rand(0, 10 ** $length - 1), $length, '0', STR_PAD_LEFT);
        } while (OtpCode::whereCode($code)->exists());

        $this->otpCode = $code;

        $data = $this->form->getState();

        OtpCode::updateOrCreate([
            'email' => $data['email'],
            
        ], [
            'code' => $this->otpCode,
            'expires_at' => now()->addSeconds(config('filament-otp-login.otp_code.expires')),
        ]);

        $this->dispatch('countDownStarted');
    }

    public function sendOtp(): void
    {
        $this->rateLimiter();

        $data = $this->form->getState();

        // $this->checkCredentials($data);

        $this->generateCode();

        $this->sendOtpToUser($this->otpCode);

        $this->step = 2;
    }

    #[On('resendCode')]
    public function resendCode(): void
    {
        $this->rateLimiter();

        $this->generateCode();

        $this->sendOtpToUser($this->otpCode);
    }

    protected function sendOtpToUser(string $otpCode): void
    {
        $this->email = $this->data['email'];
        // $names = $this->data['name'];

        // $this->name=Customer::query()->where('email',$this->email)->value('name');
        
        $this->notify(new SendOtpCode($otpCode));

        Notification::make()
            ->title(__('filament-otp-login::translations.notifications.title'))
            ->body(__('filament-otp-login::translations.notifications.body', ['seconds' => config('filament-otp-login.otp_code.expires')]))
            ->success()
            ->send();
    }



    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                ->schema([
                    Wizard::make([
                        Wizard\Step::make('Page 1')
                        ->schema([
                    $this->getRadioformComponent(),
                    $this->getNameFormComponent(),
                    $this->getEmailFormComponent(),
                    $this->getPhoneCodeFormComponent(),                   
                    $this->getMobileFormComponent(),
                    ]),
                        Wizard\Step::make('Page 2')
                        ->schema([                                
                    $this->getPasswordFormComponent(),
                    $this->getPasswordConfirmationFormComponent(),                       
                    $this->getCheckboxFormComponent(),
                    ])
                    ])
                ])
                    ->statePath('data'),
            ),
            'otpForm' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getOtpCodeFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getOtpCodeFormComponent(): Component
    {
        return OtpInput::make('otp')
            ->label(__('filament-otp-login::translations.otp_code'))
            ->hint(new HtmlString('<button type="button" wire:click="goBack()" class="focus:outline-none font-bold focus:underline hover:text-primary-400 text-primary-600 text-sm">' . __('filament-otp-login::translations.view.go_back') . '</button>'))
            ->required();
    }

    public function goBack(): void
    {
        $this->step = 1;
    }

    /**
     * @return array<Action | ActionGroup>
     */


    /**
     * @return array<Action | ActionGroup>
     */
    public function getOtpFormActions(): array
    {
        return [
            $this->getSendOtpAction(),
        ];
    }

    protected function getSendOtpAction(): Action
    {
        return Action::make('send-otp')
            ->label(__('filament-otp-login::translations.view.verify'))
            ->submit('sendOtp');
    }

    protected function goBackAction(): ActionComponent
    {
        return ActionComponent::make('go-back')
            ->label(__('filament-otp-login::translations.view.go_back'))
            ->action(fn () => $this->goBack());
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label(__('filament-panels::pages/auth/login.form.actions.authenticate.label'))
            ->submit('authenticate');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRegistration(array $data): Model
    {
        return $this->getUserModel()::create($data);
    }

    protected function sendEmailVerificationNotification(Model $user): void
    {
        if (! $user instanceof MustVerifyEmail) {
            return;
        }

        if ($user->hasVerifiedEmail()) {
            return;
        }

        if (! method_exists($user, 'notify')) {
            $userClass = $user::class;

            throw new Exception("Model [{$userClass}] does not have a [notify()] method.");
        }

        $notification = app(VerifyEmail::class);
        $notification->url = Filament::getVerifyEmailUrl($user);

        $user->notify($notification);
    }

    public function form(Form $form): Form
    {
        return $form;
    }

    /**
     * @return array<int | string, string | Form>
     */


    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label(__('filament-panels::pages/auth/register.form.name.label'))
            ->required()
            ->regex('/^[a-zA-Z\s]+$/')
            ->maxLength(255)
            ->autofocus()
            ->columnSpan(2);
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/register.form.email.label'))
            ->email()
            ->required()
            ->maxLength(255)
            ->unique($this->getUserModel())
            ->columnSpan(2);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/register.form.password.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->tooltip('Password must contain 8 letters,one uppercase,one numeric,one special characters(Eg: Welcome@1)')
            // ->regex('^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$')
            ->rule(Password::default()->min('8')->symbols()->numbers()->mixedCase())
            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
            ->same('passwordConfirmation')
            ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'))
            ->columnSpan(2);
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label(__('filament-panels::pages/auth/register.form.password_confirmation.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->dehydrated(false)
            ->columnSpan(2);;
    }
    protected function getRadioFormComponent(): Component
    {
        return Radio::make('location')
            ->options([
                'Kenya' => 'KENYA',
                'Outside Kenya' => 'OUTSIDE KENYA',
            ])
            ->label('')
            ->default('Kenya')
            ->required()
            ->inline()
            ->columnSpan(2)
            ->reactive();
     }        
        protected function getPhoneCodeFormComponent(): Component
         {
            return select::make('country_id')
            ->label("Code")

            ->required()
        ->options(function (Get $get): Collection {
            $location = $get('location');
            $defaultCountryCode = '+254';
            if ($location === 'Kenya') {
                return Country::where('country_name', 'Kenya')
                ->pluck('country_phone_code', 'id');
            } 
           else {
                return Country::query()
                    ->pluck('country_phone_code', 'id');
            }
        })
        ->default(function (Get $get) {
            $location = $get('location');
            if ($location === 'Kenya') {
                return Country::where('country_name', 'Kenya')->value('id'); 
            }
            return null;
        })
        ->visible(fn(Get $get) => $get('location') !== null);
       
        
        }
        protected function getMobileFormComponent(): Component
        {
           return TextInput::make('mobile')
           ->label("Mobile Number")
           ->regex('/^[0-9\s]+$/')
           ->required();
           
         }
         protected function getCheckboxFormComponent(): Component
         {
            return Checkbox::make('check')
            ->accepted()
             ->validationMessages([
        'accepted' => 'Please Acknowledge the Terms and Conditions.',
    ])
            // ->label("I agree for the Pwani Oil Products Limited credit terms and policy.")
            ->label(fn () => new HtmlString ('I agree for the Pwani Oil Products Limited <a href="assets\terms_and_conditions.pdf" target="_blank" style="color:red;">Credit terms and policy.</a>'))
            ->required()
            ->columnSpan(2);
            
          }

    public function loginAction(): Action
    {
        return Action::make('login')
            ->link()
            ->label(__('filament-panels::pages/auth/register.actions.login.label'))
            ->url(filament()->getLoginUrl());
    }

    protected function getUserModel(): string
    {
        if (isset($this->userModel)) {
            return $this->userModel;
        }

        /** @var SessionGuard $authGuard */
        $authGuard = Filament::auth();

        /** @var EloquentUserProvider $provider */
        $provider = $authGuard->getProvider();

        return $this->userModel = $provider->getModel();
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament-panels::pages/auth/register.title');
    }

    public function getHeading(): string | Htmlable
    {
        return __('filament-panels::pages/auth/register.heading');
    }

    /**
     * @return array<Action | ActionGroup>
     */
    public function getFormActions(): array
    {
        return [
            $this->getRegisterFormAction(),
        ];
    }

    public function getRegisterFormAction(): Action
    {
        return Action::make('register')
            ->label(__('filament-panels::pages/auth/register.form.actions.register.label'))
            ->submit('register');
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        return $data;
    }
    // protected function checkCredentials($data): void
    // {
    //     $user = config('filament-otp-login.user_model')::where('email', $data['email'])->first();

    //     if (! $user || ! password_verify($data['password'], $user->password)) {
    //         $this->throwFailureValidationException();
    //     }
    // }
}






   

