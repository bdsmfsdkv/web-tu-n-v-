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
        'thumbnail',
        'description',
        'active',
        'platform',
        'game_group_id'
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
