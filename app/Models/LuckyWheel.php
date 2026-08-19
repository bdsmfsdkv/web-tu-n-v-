<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyWheel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'wheel_image',
        'description',
        'rules',
        'active',
        'price_per_spin',
        'config',
    ];

    protected $casts = [
        'active' => 'boolean',
        'config' => 'array',
    ];

    /**
     * Get the histories for the lucky wheel
     */
    public function histories()
    {
        return $this->hasMany(LuckyWheelHistory::class);
    }
}
