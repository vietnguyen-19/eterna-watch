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
        'reason',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function refundItems()
    {
        return $this->hasMany(RefundItem::class);
    }
    public function entity()
    {
        return $this->morphTo();
    }
}
