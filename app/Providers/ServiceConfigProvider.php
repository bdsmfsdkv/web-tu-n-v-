<?php
namespace App\Providers;

use App\Models\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ServiceConfigProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadServiceSettings();
    }

    protected function loadServiceSettings()
    {
        if (!Schema::hasTable('configs')) {
            return;
        }

        $settings = \App\Helpers\ConfigHelper::allMap();
        $mailEncryption = $settings['mail_encryption'] ?? null;
        $mailPort = $settings['mail_port'] ?? config('mail.mailers.smtp.port');

        config([
            'services.google.client_id' => $settings['login_social.google.client_id'] ?? config('services.google.client_id'),
            'services.google.client_secret' => $settings['login_social.google.client_secret'] ?? config('services.google.client_secret'),
            'services.google.redirect' => $settings['login_social.google.redirect'] ?? config('services.google.redirect'),
            'services.facebook.client_id' => $settings['login_social.facebook.client_id'] ?? config('services.facebook.client_id'),
            'services.facebook.client_secret' => $settings['login_social.facebook.client_secret'] ?? config('services.facebook.client_secret'),
            'services.facebook.redirect' => $settings['login_social.facebook.redirect'] ?? config('services.facebook.redirect'),
            'mail.default' => $settings['mail_mailer'] ?? config('mail.default'),
            'mail.mailers.smtp.host' => $settings['mail_host'] ?? config('mail.mailers.smtp.host'),
            'mail.mailers.smtp.port' => $mailPort,
            'mail.mailers.smtp.username' => $settings['mail_username'] ?? config('mail.mailers.smtp.username'),
            'mail.mailers.smtp.password' => $settings['mail_password'] ?? config('mail.mailers.smtp.password'),
            'mail.mailers.smtp.scheme' => $mailEncryption === 'ssl' || (string) $mailPort === '465' ? 'smtps' : 'smtp',
            'mail.mailers.smtp.encryption' => $mailEncryption === 'null'
                ? null
                : ($mailEncryption ?? config('mail.mailers.smtp.encryption')),
            'mail.from.address' => $settings['mail_from_address'] ?? config('mail.from.address'),
            'mail.from.name' => $settings['mail_from_name'] ?? config('mail.from.name'),
        ]);
    }
}
