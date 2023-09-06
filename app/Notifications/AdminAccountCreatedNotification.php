<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminAccountCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly User $user, private readonly string $password)
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
            ->subject("{$appName} - Bem Vindo")
            ->greeting("Olá {$this->user->getName()},")
            ->line('Sua conta foi criada com sucesso no nosso painel.')
            ->line('Para acessa-la, basta fazer login com os dados abaixo:')
            ->line("**E-mail:** {$this->user->getEmail()}")
            ->line("**Senha:** {$this->password}")
            ->action('Clique aqui para fazer o login', route('login'))
            ->salutation("Atenciosamente, {$appName}");
    }
}
