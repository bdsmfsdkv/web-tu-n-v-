<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'tag_image',
        'description',
        'active',
        'platform',
        'game_group_id',
        'is_flash_sale',
        'flash_sale_old_price',
        'flash_sale_new_price',
        'flash_sale_end_time',
        'custom_stock_count',
        'custom_sold_count'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function gameGroup()
    {
        return $this->belongsTo(GameGroup::class, 'game_group_id');
    }

    public function accounts()
    {
        return $this->hasMany(GameAccount::class, 'game_category_id');
    }

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_catalog_data');
            \Illuminate\Support\Facades\Cache::forget('header_nav_data_v3');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_catalog_data');
            \Illuminate\Support\Facades\Cache::forget('header_nav_data_v3');
        });
    }
}
