<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price_default',
        'short_description',
        'full_description',
        'avatar',
        'category_id',
        'brand_id',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
   

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(
            Attribute::class,
            'product_has_attributes',   // Tên bảng trung gian
            'product_id',               // Khóa ngoại trong bảng trung gian tham chiếu Product
            'attribute_id'              // Khóa ngoại trong bảng trung gian tham chiếu Attribute
        );
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }
    
}
