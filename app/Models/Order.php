<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'order_code',
        'user_id',
        'voucher_id',
        'total_amount',
        'status',
        'shipping_method'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
    public function entity()
    {
        return $this->morphTo();
    }
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
    public function shipment()
    {
        return $this->hasOne(Shipment::class, 'order_id');
    }
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
    public function countOrderItems()
    {
        return $this->orderItems()->count();
    }
}
