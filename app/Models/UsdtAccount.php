<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsdtAccount extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'type',
        'name',
        'wallet_address',
        'qr_image',
        'api_token',
        'is_active',
    ];
}
