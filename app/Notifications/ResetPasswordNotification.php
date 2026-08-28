<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $siteName = config_get('site_name', config('app.name', 'Shop Game'));
        $expireMinutes = (int) config('auth.passwords.users.expire', 60);

        return (new MailMessage)
            ->subject('Đặt lại mật khẩu - ' . $siteName)
            ->view('emails.reset-password', [
                'resetUrl' => $resetUrl,
                'notifiable' => $notifiable,
                'siteName' => $siteName,
                'expireMinutes' => $expireMinutes,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
