<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'order',
        'active',
        'link'
    ];

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer'
    ];
}
