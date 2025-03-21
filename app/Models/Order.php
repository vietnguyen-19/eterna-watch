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
    public function getDiscountAmount()
    {
        $orderTotal = $this->orderItems()->sum('total_price');
        
        if ($orderTotal <= 0) {
            return 0; // Nếu không có sản phẩm nào, không có chiết khấu
        }

        if ($this->voucher->discount_type == 'percent') {
            $discount = $orderTotal * ($this->voucher->discount_value / 100);
        } else { // Trường hợp fixed
            $discount = $this->voucher->discount_value;
        }
        return $discount; // Không vượt quá tổng tiền đơn hàng
    }
    public function getShippingFee()
    {
        return $this->shipment->shipping_method === 'fixed' ? 100000 : 0;
    }
}
