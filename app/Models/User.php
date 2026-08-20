<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'email',
        'google_id',
        'facebook_id',
        'role',
        'balance',
        'total_deposited',
        'banned',
        'ip_address',
        'email_verified_at',
        'avatar',
        'referrer_id',
        'total_commission'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Gửi email đặt lại mật khẩu.
     * Nếu SMTP lỗi thì ném lại exception để controller báo đúng cho người dùng,
     * tránh trường hợp giao diện báo "đã gửi" trong khi thư thực tế chưa đi.
     */
    public function sendPasswordResetNotification($token): void
    {
        try {
            $this->notify(new ResetPasswordNotification($token));

            Log::info('Đã gửi email đặt lại mật khẩu thành công', [
                'user_id' => $this->id,
                'email' => $this->email,
            ]);
        } catch (\Throwable $e) {
            Log::error('Lỗi khi gửi email đặt lại mật khẩu', [
                'user_id' => $this->id,
                'email' => $this->email,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
