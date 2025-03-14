<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $table = 'shipments';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'shipping_provider',
        'shipping_method',
        'shipping_cost',
        'tracking_number',
        'shipment_status',
        'shipped_date',
        'delivered_date',
        'estimated_delivery_date',
    ];

    protected $casts = [
        'shipped_date' => 'datetime',
        'delivered_date' => 'datetime',
        'estimated_delivery_date' => 'datetime',
    ];

    // Quan hệ với bảng Orders
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
