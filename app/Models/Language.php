<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'iso_code',
        'flag_path',
        'is_active',
        'is_default',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'order' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        // Đảm bảo chỉ có 1 ngôn ngữ mặc định
        static::saving(function ($language) {
            if ($language->is_default) {
                static::where('id', '!=', $language->id)->update(['is_default' => false]);
            }
        });
    }
}
