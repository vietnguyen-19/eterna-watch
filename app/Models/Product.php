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
        'stock',
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
    public function getSoldQuantityAttribute()
    {
        // Nếu sản phẩm có biến thể
        if ($this->variants()->exists()) {
            return OrderItem::whereIn('variant_id', $this->variants->pluck('id'))
                ->whereHas('order', function ($query) {
                    $query->where('status', 'completed'); // chỉ tính đơn hoàn tất
                })
                ->sum('quantity');
        }

        // Nếu sản phẩm không có biến thể (đơn giản)
        return OrderItem::where('product_id', $this->id)
            ->whereNull('variant_id') // chắc chắn không phải biến thể
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed');
            })
            ->sum('quantity');
    }
    public function getCurrentStockAttribute()
    {
        // Nếu có biến thể
        if ($this->variants()->exists()) {
            return $this->variants->sum('stock');
            // Giả sử mỗi ProductVariant có một cột 'stock' (số lượng tồn)
        }

        // Nếu không có biến thể
        return $this->stock;
        // Giả sử bảng 'products' cũng có cột 'stock'
    }
    // Trong model Product
    public function getFirstVariantId()
    {
        // Kiểm tra nếu sản phẩm có biến thể và trả về id của biến thể đầu tiên
        return $this->variants->first() ? $this->variants->first()->id : null;
    }
}
