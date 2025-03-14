<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHasAttribute extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'attribute_id'];

    /**
     * Mối quan hệ: Một ProductOptionValue thuộc về một Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
