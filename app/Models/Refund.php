<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'total_refund_amount',
        'refund_reason',
        'rejected_reason',
        'status',
        'vnp_transaction_no',
        'vnp_response_code',
        'refunded_at',
    ];
    protected $casts = [
        'refunded_at' => 'datetime', // Cast refunded_at thành Carbon
        'total_refund_amount' => 'decimal:2',
        'vnp_amount' => 'decimal:2',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function refundItems()
    {
        return $this->hasMany(RefundItem::class);
    }
    public function imageRefunds()
    {
        return $this->hasMany(ImageRefund::class);
    }
    public function entity()
    {
        return $this->morphTo();
    }
}
