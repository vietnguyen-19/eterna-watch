<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'price_default',
        'price_sale',
        'type',
        'short_description',
        'full_description',
        'avatar',
        'category_id',
        'brand_id',
        'status',
    ];
    // Trong model Product



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
    // Trong model Product
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getAvatarAttribute($value)
    {
        return $value ? $value : 'avatars/default.jpeg';
    }
}
