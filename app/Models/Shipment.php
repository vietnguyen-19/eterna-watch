<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'shipping_method',
        'shipping_cost',
        'shipped_date',
        'delivered_date'
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
