<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    
    public function run()
    {
        $vouchers = [
            [
                'name' => 'Giảm 5% Đơn Hàng Trên 2 Triệu',
                'code' => 'SALE5P',
                'discount_type' => 'percent',
                'discount_value' => 5.00,
                'min_order' => 2000000,
                'max_uses' => 100,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(30),
                'status' => 'active',
            ],
            [
                'name' => 'Giảm 5% Đơn Hàng Trên 5 Triệu',
                'code' => 'VIP5P',
                'discount_type' => 'percent',
                'discount_value' => 5.00,
                'min_order' => 5000000,
                'max_uses' => 50,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(60),
                'status' => 'active',
            ],
            [
                'name' => 'Giảm 500K Cho Đơn Hàng Trên 3 Triệu',
                'code' => 'FIXED500K',
                'discount_type' => 'fixed',
                'discount_value' => 500000,
                'min_order' => 3000000,
                'max_uses' => 80,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(45),
                'status' => 'active',
            ],
            [
                'name' => 'Giảm 1 Triệu Đơn Hàng Trên 7 Triệu',
                'code' => 'FIXED1M',
                'discount_type' => 'fixed',
                'discount_value' => 1000000,
                'min_order' => 7000000,
                'max_uses' => 30,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(90),
                'status' => 'active',
            ],
            [
                'name' => 'Voucher Đặc Biệt - Giảm 5% Đơn Hàng 10 Triệu',
                'code' => 'SPECIAL5P',
                'discount_type' => 'percent',
                'discount_value' => 5.00,
                'min_order' => 10000000,
                'max_uses' => 20,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(120),
                'status' => 'active',
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::create($voucher);
        }
    }
}
