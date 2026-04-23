<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendClientCredentials extends Notification
{
    // NOTE: NOT implementing ShouldQueue for now to ensure emails send synchronously on local
    private string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your IronCoach Account Credentials')
            ->markdown('emails.client_credentials', [
                'url'      => url(route('login')),
                'email'    => $notifiable->email,
                'password' => $this->password,
            ]);
    }
}
