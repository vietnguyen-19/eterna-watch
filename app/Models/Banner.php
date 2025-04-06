<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image_link',
        'redirect_link',
    ];

    protected $attributes = [
        'redirect_link' => '#', // Đặt link mặc định nếu không có
    ];

    // Thêm thuộc tính dates để tự động xử lý trường deleted_at
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function getImageLinkAttribute($value)
    {
        return url($value);
    }

    // Timestamps vẫn giữ nguyên
    public $timestamps = true;
}
