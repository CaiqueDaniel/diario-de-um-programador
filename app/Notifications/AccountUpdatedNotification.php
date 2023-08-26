<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
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
            ->subject("{$appName} - Dados atualizados")
            ->greeting("Olá {$this->user->getName()},")
            ->line('Houve uma alteração recente nos dados da sua conta.')
            ->salutation("Atenciosamente, {$appName}");
    }
}
