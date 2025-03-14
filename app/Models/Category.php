<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'parent_id', 'status'];

    // Quan hệ cha-con
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_categories');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Quan hệ: Một danh mục có nhiều danh mục con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Lấy tất cả sản phẩm của danh mục cha và danh mục con
    public function allProducts()
    {
        return Product::whereIn('category_id', function ($query) {
            $query->select('id')->from('categories')
                ->where('parent_id', $this->id)
                ->orWhere('id', $this->id);
        })->get(); // Thêm `->get()` để thực thi truy vấn
    }
}
