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

    // Định nghĩa kiểu dữ liệu cho các trường
    protected $casts = [
        'expires_at' => 'datetime',
        'start_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Các hằng số trạng thái
    const STATUS_ACTIVE = 'active';
    const STATUS_EXPIRED = 'expired';

    /**
     * Scope để lấy các voucher đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope để lấy các voucher đã hết hạn
     */
    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_EXPIRED);
    }

    /**
     * Scope để lấy các voucher hợp lệ
     */
    public function scopeValid($query)
    {
        return $query->active()
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('max_uses')
                    ->orWhereColumn('used_count', '<', 'max_uses');
            });
    }

    /**
     * Kiểm tra voucher đã hết hạn chưa
     */
    public function isExpired()
    {
        if ($this->status === self::STATUS_EXPIRED) {
            return true;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            $this->update(['status' => self::STATUS_EXPIRED]);
            return true;
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            $this->update(['status' => self::STATUS_EXPIRED]);
            return true;
        }

        return false;
    }

    /**
     * Kiểm tra voucher có hợp lệ không
     * - Chưa hết hạn
     * - Đã đến ngày bắt đầu
     */
    public function isValid()
    {
        return !$this->isExpired() &&
            ($this->start_date === null || $this->start_date->isPast());
    }

    /**
     * Tính toán giá trị giảm giá
     * - Kiểm tra đơn hàng đạt giá trị tối thiểu
     * - Tính toán theo loại giảm giá
     */
    public function calculateDiscount($orderTotal)
    {
        if (!$this->isValid() || $orderTotal < $this->min_order) {
            return 0;
        }

        if ($this->discount_type === 'percent') {
            $discount = $orderTotal * ($this->discount_value / 100);
            return min($discount, $orderTotal);
        }

        return min($this->discount_value, $orderTotal);
    }

    /**
     * Đánh dấu voucher đã được sử dụng
     *  Tăng số lần đã sử dụng
     *  Nếu đạt max_uses cập nhật thành expired
     */
    public function markAsUsed()
    {
        $this->increment('used_count');

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            $this->update(['status' => self::STATUS_EXPIRED]);
        }

        return $this;
    }
    /**
     * Kiểm tra voucher có bị xóa mềm không
     */
    public function isTrashed()
    {
        return $this->trashed();
    }

    protected static function boot()
    {
        parent::boot();
        static::retrieved(function ($voucher) {
            $voucher->checkStatus();
        });
        static::saving(function ($voucher) {
            $voucher->checkStatus();
        });
    }

    /**
     * Kiểm tra và cập nhật trạng thái 2 chiều
     */
    public function checkStatus()
    {
        // Nếu đang hết hạn nhưng đủ điều kiện hoạt động lại
        if (
            $this->status === self::STATUS_EXPIRED &&
            $this->shouldReactivate()
        ) {
            $this->status = self::STATUS_ACTIVE;
        }
        // Nếu voucher đã hết hạn
        elseif (
            $this->status === self::STATUS_ACTIVE &&
            $this->shouldMarkAsExpired()
        ) {
            $this->status = self::STATUS_EXPIRED;
        }
    }

    /**
     * Kiểm tra điều kiện hết hạn
     */
    protected function shouldMarkAsExpired()
    {
        return ($this->expires_at && $this->expires_at->isPast()) ||
            ($this->max_uses && $this->used_count >= $this->max_uses);
    }

    /**
     * Kiểm tra điều kiện để kích hoạt lại
     */
    protected function shouldReactivate()
    {
        return (!$this->expires_at || $this->expires_at->isFuture()) &&
            (!$this->max_uses || $this->used_count < $this->max_uses);
    }
    public function getStatusTextAttribute()
    {
        return [
            self::STATUS_ACTIVE => 'Hoạt động',
            self::STATUS_EXPIRED => 'Hết hạn'
        ][$this->status] ?? $this->status;
    }

    public function getStatusClassAttribute()
    {
        return [
            self::STATUS_ACTIVE => 'bg-success',
            self::STATUS_EXPIRED => 'bg-danger'
        ][$this->status] ?? 'bg-secondary';
    }

    public function getExpiryReasonAttribute()
    {
        if ($this->status === self::STATUS_ACTIVE) return null;

        if ($this->expires_at && $this->expires_at->isPast()) {
            return 'Hết hạn ngày ' . $this->expires_at->format('d/m/Y');
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return 'Đã dùng hết số lần';
        }

        return 'Đã bị hủy';
    }
}
