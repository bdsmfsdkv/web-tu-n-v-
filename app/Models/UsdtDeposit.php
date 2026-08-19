<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsdtDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_code',
        'usdt_amount',
        'exchange_rate',
        'vnd_amount',
        'status',
        'transaction_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
