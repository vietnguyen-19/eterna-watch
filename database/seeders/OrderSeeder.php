<?php

namespace Database\Seeders;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'order_code'=> 'ORD-2023-01-01-0001',
                'user_id' => 1,
                'status' => 'pending',
                'total_amount'=> '1500000',
                'shipping_method'=> 'free',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'order_code'=> 'ORD-2024-02-01-0002',
                'user_id' => 2,
                'status' => 'pending',
                'total_amount'=> '2300000',
                'shipping_method'=> 'free',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'order_code'=> 'ORD-2024-04-02-0001',
                'user_id' => 3,
                'status' => 'pending',
                'total_amount'=> '2200000',
                'shipping_method'=> 'free',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'order_code'=> 'ORD-2024-03-03-0004',
                'user_id' => 3,
                'status' => 'pending',
                'total_amount'=> '1240000',
                'shipping_method'=> 'free',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],

        ]);        
    }
}
