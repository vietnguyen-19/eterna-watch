<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'discount_type',
        'discount_value',
        'min_order',
        'max_uses',
        'used_count',
        'start_date',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'expires_at' => 'datetime', // Chuyển expires_at thành kiểu datetime (Carbon)
        'start_date' => 'datetime', // Chuyển expires_at thành kiểu datetime (Carbon)
    ];
    // Kiểm tra voucher còn hợp lệ không
    public function isValid() {
        return $this->status === 'active' &&
               ($this->expires_at === null || $this->expires_at->isFuture()) &&
               ($this->start_date === null || $this->start_date->isPast()) &&
               ($this->max_uses === null || $this->used_count < $this->max_uses);
    }
    public function calculateDiscount($orderTotal)
    {
        if ($this->discount_type === 'percent') {
            return min($orderTotal * ($this->discount_value / 100), $orderTotal);
        }
        return min($this->discount_value, $orderTotal);
    }
}
