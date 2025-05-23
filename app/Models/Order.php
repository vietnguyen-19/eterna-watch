<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use HasFactory;
    use SoftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'order_code',
        'user_id',
        'address_id',

        'name',
        'order_user_id',
        'full_name',
        'phone_number',
        'email',
        'street_address',
        'ward',
        'district',
        'city',
        'payment_method',
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
    public function refund()
    {
        return $this->hasOne(Refund::class, 'order_id');
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'address_id');
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
        // Kiểm tra nếu không có voucher
        if (!$this->voucher) {
            return 0; // Không có mã voucher, không có chiết khấu
        }

        $orderTotal = $this->orderItems()->sum('total_price');

        // Nếu không có sản phẩm nào trong đơn hàng, không có chiết khấu
        if ($orderTotal <= 0) {
            return 0;
        }

        // Kiểm tra loại chiết khấu của voucher
        if ($this->voucher->discount_type == 'percent') {
            $discount = $orderTotal * ($this->voucher->discount_value / 100);
        } else { // Trường hợp fixed
            $discount = $this->voucher->discount_value;
        }
        return $discount; // Không vượt quá tổng tiền đơn hàng
    }

    public function getShippingFee()
    {
        return $this->shipping_method === 'fixed' ? 100000 : 0;
    }
    public function productVariant()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'product_id');
    }
    public function shippingAddress()
    {
        return $this->hasOne(UserAddress::class, 'user_id', 'user_id')->where('is_default', 1);
    }
    // app/Models/Order.php

    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class, 'entity_id')
            ->where('entity_type', 'order')  // Nếu bạn lưu nhiều loại entity_type, nên filter đúng loại
            ->orderBy('changed_at', 'asc');  // Sắp xếp theo thời gian thay đổi
    }

    public function allowedStatusTransitions()
    {
        return match ($this->status) {
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['processing', 'cancelled'],
            'processing' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => []
        };
    }
}
