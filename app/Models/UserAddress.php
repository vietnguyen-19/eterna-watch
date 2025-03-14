<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'full_name',
        'phone_number',
        'email',
        'street_address',
        'ward',
        'district',
        'city',
        'country',
        'is_default',
        'note'
    ];

    protected $casts = [
        'is_default' => 'boolean', // Tự động cast thành true/false
    ];

    // 🚀 Quan hệ: Một địa chỉ thuộc về một người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // 🏠 Lấy địa chỉ đầy đủ
    public function getFullAddressAttribute()
    {
        return "{$this->street_address}, {$this->ward}, {$this->district}, {$this->city}, {$this->country}";
    }

    // 🌟 Scope lấy địa chỉ mặc định
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
