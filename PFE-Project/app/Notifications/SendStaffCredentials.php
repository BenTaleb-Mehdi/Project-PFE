<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendStaffCredentials extends Notification
{
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
            ->subject('Welcome to Achraf Coach - Your Access')
            ->markdown('emails.staff_credentials', [
                'url'      => url(route('login')),
                'email'    => $notifiable->email,
                'password' => $this->password,
            ]);
    }
}
