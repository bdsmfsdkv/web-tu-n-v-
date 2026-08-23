<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SepayWebhookLog extends Model
{
    use HasFactory;

    protected $table = 'sepay_webhook_logs';

    protected $fillable = [
        'bank_name',
        'account_number',
        'content',
        'amount',
        'user_id',
        'reference_code',
        'status',
        'message',
        'ip_address',
    ];

    protected $casts = [
        'amount' => 'decimal:0',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
