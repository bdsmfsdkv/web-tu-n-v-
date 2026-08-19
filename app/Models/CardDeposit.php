<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'telco',
        'amount',
        'received_amount',
        'serial',
        'pin',
        'request_id',
        'status',
    ];

    /**
     * Get the user that owns the card deposit.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getOrderCodeAttribute()
    {
        $timestampHex = dechex($this->created_at ? $this->created_at->timestamp : time());
        $hashHex = substr(md5('order_' . $this->id), 0, 13 - strlen($timestampHex));
        return $timestampHex . $hashHex;
    }
}
