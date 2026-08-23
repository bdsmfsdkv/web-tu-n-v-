<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'lucky_wheel_id',
        'icon',
        'game_name',
        'name',
        'unit',
        'code',
        'min_withdraw',
        'max_withdraw',
        'priority',
        'active',
    ];

    public function luckyWheel()
    {
        return $this->belongsTo(LuckyWheel::class);
    }

    public function wheelHistories()
    {
        return $this->hasMany(LuckyWheelHistory::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(WithdrawalHistory::class);
    }
}
