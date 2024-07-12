<?php

namespace App\Filament\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationSubmitEmp extends Notification
{
    use Queueable;

    protected $ccEmails;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $ccEmails = [])
    {
        //
        $this->ccEmails = $ccEmails;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
        ->view('Application-Submit')
            ->subject(__('Welcome to the Pwani Portal - Thank You for Submitting the Form!'));
            foreach ($this->ccEmails as $ccEmail) {
                $mailMessage->cc($ccEmail);
            }
            return $mailMessage;
            // ->greeting(__('filament-otp-login::translations.mail.greeting'))
            // ->line(__('filament-otp-login::translations.mail.line1', ['code' => $this->code]))
            // ->line(__('filament-otp-login::translations.mail.line2', ['seconds' => config('filament-otp-login.otp_code.expires')]))
            // ->line(__('filament-otp-login::translations.mail.line3'))
            // ->salutation(__('filament-otp-login::translations.mail.salutation', ['app_name' => config('app.name')]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}