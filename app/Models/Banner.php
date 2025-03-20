<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_link',
        'redirect_link',
    ];

    protected $attributes = [
        'redirect_link' => '#', // Đặt link mặc định nếu không có
    ];

    public function getImageLinkAttribute($value)
    {
        return url($value);
    }


    public $timestamps = true;
}
