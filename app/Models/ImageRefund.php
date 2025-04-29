<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageRefund extends Model
{
    use HasFactory;

    // Khai báo bảng (nếu không sử dụng tên mặc định)
    protected $table = 'image_refunds';

    // Các trường có thể điền giá trị (fillable)
    protected $fillable = [
        'refund_id',
        'image',
    ];

    // Quan hệ với Refund
    public function refund()
    {
        return $this->belongsTo(Refund::class);
    }
}
