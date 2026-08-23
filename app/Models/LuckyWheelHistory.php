<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyWheelHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lucky_wheel_id',
        'reward_item_id',
        'spin_count',
        'total_cost',
        'reward_type',
        'reward_amount',
        'description',
    ];

    protected $casts = [
        'spin_count' => 'integer',
        'total_cost' => 'integer',
        'reward_amount' => 'integer',
    ];

    /**
     * Get the user that owns the history
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the lucky wheel that owns the history
     */
    public function luckyWheel()
    {
        return $this->belongsTo(LuckyWheel::class);
    }

    public function rewardItem()
    {
        return $this->belongsTo(RewardItem::class);
    }
}
