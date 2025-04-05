<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;

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
        'expires_at' => 'datetime',
        'start_date' => 'datetime',
        'deleted_at' => 'datetime', // Thêm cast cho deleted_at
    ];

    // Scope cho các trạng thái
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeValid($query)
    {
        return $query->active()
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->where(function($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('max_uses')
                  ->orWhereColumn('used_count', '<', 'max_uses');
            });
    }

    // Kiểm tra voucher còn hợp lệ không
    public function isValid()
    {
        return $this->status === 'active' &&
               ($this->expires_at === null || $this->expires_at->isFuture()) &&
               ($this->start_date === null || $this->start_date->isPast()) &&
               ($this->max_uses === null || $this->used_count < $this->max_uses);
    }

    // Tính toán giảm giá
    public function calculateDiscount($orderTotal)
    {
        if (!$this->isValid()) {
            return 0;
        }

        if ($this->discount_type === 'percent') {
            return min($orderTotal * ($this->discount_value / 100), $orderTotal);
        }

        return min($this->discount_value, $orderTotal);
    }

    // Đánh dấu đã sử dụng
    public function markAsUsed()
    {
        $this->increment('used_count');

        // Nếu đạt max_uses thì đánh dấu hết hạn
        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            $this->update(['status' => 'expired']);
        }

        return $this;
    }

    // Kiểm tra xem voucher có bị xóa mềm không
    public function isTrashed()
    {
        return $this->trashed();
    }

    // Tự động cập nhật status khi save
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($voucher) {
            if ($voucher->expires_at && $voucher->expires_at->isPast()) {
                $voucher->status = 'expired';
            }
        });
    }
}
