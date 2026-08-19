<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
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
}
