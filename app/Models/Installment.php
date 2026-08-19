<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_account_id',
        'total_price',
        'paid_amount',
        'duration_days',
        'expire_date',
        'status', // active, completed, cancelled, expired
    ];

    protected $casts = [
        'expire_date' => 'datetime',
        'total_price' => 'float',
        'paid_amount' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gameAccount()
    {
        return $this->belongsTo(GameAccount::class);
    }
}
