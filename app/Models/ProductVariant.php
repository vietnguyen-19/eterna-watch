<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id', 'product_id', 'sku', 'price', 'stock', 'image', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attributeValues()
    {
        return $this->hasMany(VariantAttribute::class, 'variant_id');
    }
    public function getSoldQuantityAttribute()
    {
        return OrderItem::where('variant_id', $this->id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed'); // chỉ tính đơn đã hoàn thành
            })
            ->sum('quantity');
    }
}
