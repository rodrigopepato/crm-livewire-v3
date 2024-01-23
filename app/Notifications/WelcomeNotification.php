<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
                    ->line('Bem-vindo ao nosso CRM! Feliz por ver você aqui.')
                    ->line('Obrigado por usar nosso aplicativo!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
