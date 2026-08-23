<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_category_id',
        'account_name',
        'password',
        'price',
        'status',
        'note',
        'thumb',
        'images',
        'details'
    ];

    protected $casts = [
        'details' => 'array',
        'images' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(GameCategory::class, 'game_category_id');
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
        // Bộ key thuộc tính động của trang danh mục được cache; xoá khi acc thay đổi
        // để admin thêm/bớt thuộc tính là thấy ngay bộ filter mới.
        $forgetDetailKeys = function (self $account) {
            foreach (array_unique(array_filter([
                $account->game_category_id,
                $account->getOriginal('game_category_id'),
            ])) as $categoryId) {
                \Illuminate\Support\Facades\Cache::forget('category_detail_keys_' . $categoryId);
            }
        };

        static::saved($forgetDetailKeys);
        static::deleted($forgetDetailKeys);
    }
}
