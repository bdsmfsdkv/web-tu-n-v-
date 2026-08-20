<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('mail:test {email}', function (string $email) {
    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->error('Email không hợp lệ: '.$email);
        return 1;
    }

    $this->line('SMTP host: '.(config('mail.mailers.smtp.host') ?: '(trống)'));
    $this->line('SMTP port: '.(config('mail.mailers.smtp.port') ?: '(trống)'));
    $this->line('SMTP scheme: '.(config('mail.mailers.smtp.scheme') ?: '(tự động)'));
    $this->line('From: '.(config('mail.from.address') ?: '(trống)'));

    try {
        Mail::raw('Đây là email test SMTP từ KUNCHEAP.', function ($message) use ($email) {
            $message->to($email)->subject('Test SMTP KUNCHEAP');
        });

        $this->info('GỬI MAIL THÀNH CÔNG. Hãy kiểm tra Inbox và Spam.');
        return 0;
    } catch (\Throwable $e) {
        $this->error('GỬI MAIL THẤT BẠI');
        $this->line(get_class($e));
        $this->line($e->getMessage());
        return 1;
    }
})->purpose('Test cấu hình SMTP bằng một lệnh đơn giản');
