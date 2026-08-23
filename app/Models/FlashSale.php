<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_name',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(FlashSaleItem::class);
    }

    /** Cache trong 1 request: getActivePrice() được gọi nhiều lần trên cùng một trang. */
    private static ?array $activePriceMap = null;

    public static function getActivePrice($type, $categoryId)
    {
        if (self::$activePriceMap === null) {
            $activeCampaign = self::where('status', 1)
                ->where('start_time', '<=', now())
                ->where('end_time', '>', now())
                ->first();

            self::$activePriceMap = $activeCampaign
                ? FlashSaleItem::where('flash_sale_id', $activeCampaign->id)
                    ->get(['item_type', 'item_id', 'new_price'])
                    ->mapWithKeys(fn ($item) => [$item->item_type . ':' . $item->item_id => $item->new_price])
                    ->all()
                : [];
        }

        return self::$activePriceMap[$type . ':' . $categoryId] ?? null;
    }

    /** Dùng khi dữ liệu flash sale thay đổi giữa request (queue, test). */
    public static function flushActivePriceCache(): void
    {
        self::$activePriceMap = null;
    }

    protected static function booted()
    {
        $forgetHomeCache = static function () {
            self::flushActivePriceCache();
            \Illuminate\Support\Facades\Cache::forget('home_flash_sales');
        };

        static::saved($forgetHomeCache);
        static::deleted($forgetHomeCache);
    }
}
