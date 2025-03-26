<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['id','product_id', 'sku', 'price', 'stock', 'image'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attributeValues()
    {
        return $this->hasMany(VariantAttribute::class, 'variant_id');
    }
}
