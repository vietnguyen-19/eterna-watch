<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands';

    protected $fillable = ['name', 'parent_id'];

    // Mối quan hệ đệ quy (một thương hiệu có thể có thương hiệu cha)
    public function parent()
    {
        return $this->belongsTo(Brand::class, 'parent_id');
    }

    // Quan hệ với thương hiệu con
    public function children()
    {
        return $this->hasMany(Brand::class, 'parent_id');
    }

    // Lấy tất cả sản phẩm thuộc thương hiệu cha + con
    public function allProducts()
    {
        return Product::whereIn('brand_id', function ($query) {
            $query->select('id')
                ->from('brands')
                ->where('id', $this->id)
                ->orWhere('parent_id', $this->id);
        });
    }
}
