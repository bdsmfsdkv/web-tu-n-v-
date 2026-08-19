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

    public static function getActivePrice($type, $categoryId)
    {
        $activeCampaign = self::where('status', 1)
            ->where('start_time', '<=', now())
            ->where('end_time', '>', now())
            ->first();
            
        if ($activeCampaign) {
            $item = FlashSaleItem::where('flash_sale_id', $activeCampaign->id)
                ->where('item_type', $type)
                ->where('item_id', $categoryId)
                ->first();
            if ($item) {
                return $item->new_price;
            }
        }
        return null;
    }
}
