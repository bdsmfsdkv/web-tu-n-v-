<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'flash_sale_id',
        'item_type',
        'item_id',
        'old_price',
        'new_price',
    ];

    public function flashSale()
    {
        return $this->belongsTo(FlashSale::class);
    }

    public function category()
    {
        if ($this->item_type == 'game') {
            return $this->belongsTo(Category::class, 'item_id');
        } else {
            return $this->belongsTo(RandomCategory::class, 'item_id');
        }
    }

    protected static function booted()
    {
        // Item thay đổi cũng phải xoá cache flash sale của trang chủ và map giá trong request.
        $forgetHomeCache = static function () {
            FlashSale::flushActivePriceCache();
            \Illuminate\Support\Facades\Cache::forget('home_flash_sales');
        };

        static::saved($forgetHomeCache);
        static::deleted($forgetHomeCache);
    }
}
