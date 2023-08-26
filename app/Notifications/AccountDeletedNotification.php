<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountDeletedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly User $user)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $appName = env('APP_NAME');

        return (new MailMessage)
            ->subject("{$appName} - Conta removida")
            ->greeting("Olá {$this->user->getName()},")
            ->line('Sua conta foi excluída.')
            ->salutation("Atenciosamente, {$appName}");
    }
}
