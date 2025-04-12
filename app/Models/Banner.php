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
        'is_active',
    ];

    protected $attributes = [
        'redirect_link' => '#', // Đặt link mặc định nếu không có
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function getImageLinkAttribute($value)
    {
        return url($value);
    }

    public $timestamps = true;
}
