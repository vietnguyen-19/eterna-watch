<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'variant_id',
        'product_name',
        'image',
        'value_attributes',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id', 'id');
    }
    // OrderItem.php
    public function getValueAttributeObjectsAttribute()
    {
        $ids = is_array($this->value_attributes)
            ? $this->value_attributes
            : json_decode($this->value_attributes ?? '[]');

        return \App\Models\AttributeValue::with('attribute')
            ->whereIn('id', $ids)->get();
    }
}
