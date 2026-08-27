<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RandomCategoryAccount extends Model
{
    protected $table = 'random_category_accounts';

    protected $fillable = [
        'random_category_id',
        'account_name',
        'password',
        'price',
        'min_spent',
        'status',
        'server',
        'buyer_id',
        'batch_id',
        'note',
        'note_buyer',
        'thumbnail',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function category()
    {
        return $this->belongsTo(RandomCategory::class, 'random_category_id');
    }

    public function randomCategory()
    {
        return $this->belongsTo(RandomCategory::class, 'random_category_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function getOrderCodeAttribute()
    {
        $timestampHex = dechex($this->created_at ? $this->created_at->timestamp : time());
        $hashHex = substr(md5('order_' . $this->id), 0, 13 - strlen($timestampHex));
        return $timestampHex . $hashHex;
    }

    protected static function booted()
    {
        $forgetCatalogCache = function () {
            \Illuminate\Support\Facades\Cache::forget('home_catalog_data');
        };

        static::saved($forgetCatalogCache);
        static::deleted($forgetCatalogCache);
    }
}
