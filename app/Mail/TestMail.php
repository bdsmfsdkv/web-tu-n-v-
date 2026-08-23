<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public readonly ?string $logoUrl;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        $this->logoUrl = self::emailLogoUrl(config_get('site_logo'), config('app.url'));
    }

    public static function emailLogoUrl(?string $logo, ?string $appUrl): ?string
    {
        $logo = trim((string) $logo);

        if ($logo === '') {
            return null;
        }

        if (filter_var($logo, FILTER_VALIDATE_URL)) {
            $scheme = strtolower((string) parse_url($logo, PHP_URL_SCHEME));
            $host = strtolower((string) parse_url($logo, PHP_URL_HOST));

            return in_array($scheme, ['http', 'https'], true) && !self::isLocalHost($host) ? $logo : null;
        }

        $appUrl = rtrim(trim((string) $appUrl), '/');
        $host = strtolower((string) parse_url($appUrl, PHP_URL_HOST));

        if (!filter_var($appUrl, FILTER_VALIDATE_URL) || self::isLocalHost($host)) {
            Log::warning('Email logo skipped: APP_URL must be a public absolute URL.', [
                'app_url' => $appUrl,
                'site_logo' => $logo,
            ]);

            return null;
        }

        if (app()->environment('production')) {
            $appUrl = preg_replace('/^http:\/\//i', 'https://', $appUrl);
        }

        return $appUrl . '/' . ltrim($logo, '/');
    }

    private static function isLocalHost(string $host): bool
    {
        if ($host === 'localhost' || $host === '::1' || $host === '127.0.0.1') {
            return true;
        }

        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
        }

        return false;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kiểm tra cấu hình email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.test',
            with: ['logoUrl' => $this->logoUrl],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
