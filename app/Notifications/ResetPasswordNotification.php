<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Token đặt lại mật khẩu.
     */
    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->configureMailSettings();
    }

    /**
     * Ưu tiên cấu hình mail trong hệ thống nếu có, nếu không thì giữ cấu hình .env.
     * Không tự ép sang Gmail vì làm vậy có thể khiến ứng dụng báo gửi thành công
     * trong khi chưa có tài khoản SMTP hợp lệ.
     */
    protected function configureMailSettings(): void
    {
        $mailDriver = config_get('mail_mailer', config('mail.default', 'smtp')) ?: config('mail.default', 'smtp');
        $mailHost = config_get('mail_host', config('mail.mailers.smtp.host')) ?: config('mail.mailers.smtp.host');
        $mailPort = config_get('mail_port', config('mail.mailers.smtp.port')) ?: config('mail.mailers.smtp.port');
        $mailUsername = config_get('mail_username', config('mail.mailers.smtp.username'));
        $mailPassword = config_get('mail_password', config('mail.mailers.smtp.password'));
        $mailEncryption = config_get('mail_encryption', config('mail.mailers.smtp.encryption'));
        $mailFromAddress = config_get('mail_from_address', config('mail.from.address')) ?: config('mail.from.address');
        $mailFromName = config_get('mail_from_name', config('mail.from.name')) ?: config_get('site_name', config('app.name', 'Shop Game'));

        Config::set('mail.default', $mailDriver);
        Config::set('mail.mailers.smtp.host', $mailHost);
        Config::set('mail.mailers.smtp.port', $mailPort);
        Config::set('mail.mailers.smtp.username', $mailUsername);
        Config::set('mail.mailers.smtp.password', $mailPassword);
        Config::set('mail.mailers.smtp.encryption', $mailEncryption);
        Config::set('mail.from.address', $mailFromAddress);
        Config::set('mail.from.name', $mailFromName);

        Log::info('Password reset mail transport prepared', [
            'mailer' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'encryption' => config('mail.mailers.smtp.encryption'),
            'username_configured' => !empty(config('mail.mailers.smtp.username')),
            'from_configured' => !empty(config('mail.from.address')),
        ]);
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

        return (new MailMessage)
            ->subject('Đặt lại mật khẩu - ' . $siteName)
            ->view('emails.reset-password', [
                'resetUrl' => $resetUrl,
                'notifiable' => $notifiable,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
