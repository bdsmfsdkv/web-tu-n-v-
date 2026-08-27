<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class PurchasedAccountHistory extends Model
{
    use HasFactory;

    protected $table = 'purchased_account_histories';

    protected $fillable = [
        'user_id',
        'original_game_account_id',
        'game_category_id',
        'category_name',
        'order_code',
        'account_name',
        'password',
        'price',
        'original_price',
        'discount_amount',
        'details',
        'note',
        'purchased_at',
    ];

    protected $casts = [
        'details' => 'array',
        'purchased_at' => 'datetime',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(GameCategory::class, 'game_category_id');
    }

    public function setPasswordAttribute($value)
    {
        if ($value === null || $value === '') {
            $this->attributes['password'] = '';
            return;
        }

        try {
            $this->attributes['password'] = Crypt::encryptString((string)$value);
        } catch (\Throwable $e) {
            $this->attributes['password'] = (string)$value;
        }
    }

    public function getPasswordAttribute($value)
    {
        if ($value === null || $value === '') {
            return '';
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Throwable $e) {
            return $value;
        }
    }

    protected static function booted()
    {
        $forgetPurchasesCache = function () {
            \Illuminate\Support\Facades\Cache::forget('home_recent_purchases');
        };

        static::saved($forgetPurchasesCache);
        static::deleted($forgetPurchasesCache);
    }
}
