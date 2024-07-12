<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Notifications\NewEmployee;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\QueryException;
use Illuminate\Notifications\Notifiable;

class CreateUser extends CreateRecord
{
    use Notifiable;
    protected static string $resource = UserResource::class;
    protected static bool $canCreateAnother = false;
    public string $email = '';
    public string $name = '';
    public string $password = '';
    // protected static bool $canCreateAnother = false;

    public function getRedirectUrl(): string
    {
        $this->email = $this->data['email'];
        $this->name=User::query()->where('email',$this->email)->value('name');
        $this->password=User::query()->where('email',$this->email)->value('visible_password');
        $this->notify(new NewEmployee($this->name , $this->email , $this->password));
        // Notification::make()
        // ->title('New Employee created')
        // ->body('Empoyee created successfully')
        // ->success()
        // ->send();
        return $this->getResource()::getUrl('index');
    }
    public function create(bool $another = false): void
    {
        try {
            parent::create($another);
        } catch (QueryException $exception) {
            // Check if the exception is a unique constraint violation
            if ($exception->errorInfo[1] == 1062) {
                Notification::make()
                    ->title('Error')
                    ->body('The email address has already been taken.')
                    ->danger()
                    ->send();
            } else {
                // Re-throw the exception if it's not the unique constraint violation
                throw $exception;
            }
        }
    }
}
