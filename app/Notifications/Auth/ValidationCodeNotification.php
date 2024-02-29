<?php

namespace App\Notifications\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ValidationCodeNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage())
            ->line('Your verification code is: ')
            ->line($notifiable->validation_code);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
