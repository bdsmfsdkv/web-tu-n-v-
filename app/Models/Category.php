<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "game_categories";
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
        'flash_sale_end_time'
    ];

    public function gameGroup()
    {
        return $this->belongsTo(GameGroup::class, 'game_group_id');
    }

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_catalog_data');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_catalog_data');
        });
    }
}
