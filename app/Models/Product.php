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
        'view_count'
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
    public function comments()
    {
        return $this->morphMany(Comment::class, 'entity');
    }
    public function getMinPriceAttribute()
    {
        return $this->variants()
            ->min('price') ?? $this->price;
    }

    /**
     * Lấy giá cao nhất của từng sản phẩm
     */
    public function getMaxPriceAttribute()
    {
        return $this->variants()
            ->max('price') ?? $this->price;
    }
}
