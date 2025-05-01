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
                'name' => 'Giảm 10% cho mọi đơn hàng',
                'code' => 'DISCOUNT10PERCENT',
                'discount_type' => 'percent',
                'discount_value' => 10.00,
                'min_order' => 0,
                'max_uses' => 100,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(30),
                'status' => 'active',
            ],
            [
                'name' => 'Giảm 5% Đơn Hàng Trên 2 Triệu',
                'code' => 'DISCOUNT5PERCENT_2M',
                'discount_type' => 'percent',
                'discount_value' => 5.00,
                'min_order' => 2000000,
                'max_uses' => 100,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(60),
                'status' => 'active',
            ],
            [
                'name' => 'Giảm 500K Đơn Hàng Trên 3 Triệu',
                'code' => 'DISCOUNT500K_3M',
                'discount_type' => 'fixed',
                'discount_value' => 500000,
                'min_order' => 3000000,
                'max_uses' => 50,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(45),
                'status' => 'active',
            ],
            [
                'name' => 'Voucher Hết Hạn',
                'code' => 'EXPIREDVOUCHER',
                'discount_type' => 'percent',
                'discount_value' => 15.00,
                'min_order' => 0,
                'max_uses' => 20,
                'used_count' => 0,
                'start_date' => Carbon::now()->subDays(60),
                'expires_at' => Carbon::now()->subDays(30),
                'status' => 'active',
            ],
            [
                'name' => 'Voucher Hết Lượt',
                'code' => 'FULLUSED',
                'discount_type' => 'fixed',
                'discount_value' => 100000,
                'min_order' => 0,
                'max_uses' => 10,
                'used_count' => 10,
                'start_date' => Carbon::now()->subDays(10),
                'expires_at' => Carbon::now()->addDays(10),
                'status' => 'active',
            ],
            [
                'name' => 'Voucher Tạm Ngưng',
                'code' => 'INACTIVEVOUCHER',
                'discount_type' => 'percent',
                'discount_value' => 20.00,
                'min_order' => 0,
                'max_uses' => 100,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(90),
                'status' => 'expired',
            ],
            [
                'name' => 'Giảm 2 Triệu Cho Đơn Trên 15 Triệu',
                'code' => 'DISCOUNT2M_15M',
                'discount_type' => 'fixed',
                'discount_value' => 2000000,
                'min_order' => 15000000,
                'max_uses' => 30,
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
