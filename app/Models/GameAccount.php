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
}
