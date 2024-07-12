<x-filament-panels::page.simple>
    @if (filament()->hasLogin())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/register.actions.login.before') }}
            {{ $this->loginAction }}
        </x-slot>
    @endif
    <img src="{{ asset('images/logo-transparent.png') }}" alt="Logo">
    <h4>Customer Portal</h4>
    <h2>Register into your Pwani Oil Products Limited account</h2>

    <h3 id="slogan">Pwani Oil Products Ltd</h3>
    <img id="slo" src="{{ asset('images/logo-transparent.png') }}" alt="Logo">
    <h4 id="slogans">Pwani Oil is a popular brand of cooking oil in Kenya.
        It is known for its high quality and affordability.
        Pwani Oil is made from refined sunflower seeds and is available in different sizes and packaging.
    </h4>

    <style>
        body {
            background: linear-gradient(0deg, rgba(255,250,240,1) 0%, rgba(250,250,250,1) 100%) !important;
        }

        @media screen and (min-width: 1024px) {
            main {
                position: absolute;
                right: 100px;
            }

            main:before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: black;
                border-radius: 12px;
                z-index: -9;
                transform: rotate(7deg);
            }

            .fi-logo {
                position: fixed;
                left: 100px;
                font-size: 3em;
                color: cornsilk;
            }

            #slogan {
                position: fixed;
                left: 100px;
                margin-top: 100px;
                color: black;
                font-family: Roboto;
                font-size: 2em;
                font-weight: bold;
            }

            #slogans {
                position: fixed;
                left: 100px;
                margin-top: 250px;
                margin-right: 50%;
                color: black;
                font-family: Roboto;
                font-size: 2em;
                font-weight: bold;
            }

            #slo {
                position: fixed;
                left: 100px;
                margin-top: 0;
            }
        }

        @media screen and (max-width: 1023px) {
            #slo,
            #slogans {
                display: none;
            }
        }
    </style>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_REGISTER_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

    @switch($this->step)
        @case(1)
            <x-filament-panels::form wire:submit="sendOtp">
                {{ $this->form }}
                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="true"
                />
            </x-filament-panels::form>
            @break

        @default
            <x-filament-panels::form wire:submit="register">
                {{ $this->otpForm }}
                <x-filament-panels::form.actions
                    :actions="$this->getOtpFormActions()"
                    :full-width="true"
                />
                <div wire:ignore x-data="{
                        timeLeft: $wire.countDown,
                        timerRunning: false,
                        resendCode() {
                            this.timeLeft = $wire.countDown;
                            this.$refs.resendLink.classList.add('hidden');
                            this.$refs.timerWrapper.classList.remove('hidden');
                            this.startTimer();
                            this.$dispatch('resendCode');
                        },
                        startTimer() {
                            this.timerRunning = true;
                            const interval = setInterval(() => {
                                if (this.timeLeft <= 0) {
                                    clearInterval(interval);
                                    this.timerRunning = false;
                                    this.$refs.resendLink.classList.remove('hidden');
                                    this.$refs.timerWrapper.classList.add('hidden');
                                }
                                this.timeLeft -= 1;
                                this.$refs.timeLeft.value = this.timeLeft;
                            }, 1000);
                        },
                        init() {
                            this.startTimer();
                            document.addEventListener('countDownStarted', () => {
                                this.startTimer();
                            });
                        }
                    }">
                    <div x-show="timerRunning" class="timer font-semibold resend-link text-end text-primary-600 text-sm" x-ref="timerWrapper">
                        <span x-text="timeLeft"></span> {{ __('filament-otp-login::translations.view.time_left') }}
                    </div>
                    <a x-on:click="resendCode" x-show="!timerRunning" x-ref="resendLink" class="hidden cursor-pointer font-semibold resend-link text-end text-primary-600 text-sm">
                        {{ __('filament-otp-login::translations.view.resend_code') }}
                    </a>
                    <input type="hidden" x-ref="timeLeft" name="timeLeft" />
                </div>
            </x-filament-panels::form>
    @endswitch
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_REGISTER_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
</x-filament-panels::page.simple>
