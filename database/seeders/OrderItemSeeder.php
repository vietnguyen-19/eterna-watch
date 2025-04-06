<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_items')->insert([
            [
                'order_id' => 1,
                'variant_id' => 5,
                'quantity' => 2,
                'unit_price' => 750000,
                'total_price'=> 1750000,

            ],
            [
                'order_id' => 2,
                'variant_id' => 3,
                'quantity' => 1,
                'unit_price' => 2750000,
                'total_price'=> 4750000,

            ],
            [
                'order_id' => 3,
                'variant_id' => 6,
                'quantity' => 3,
                'unit_price' => 3750000,
                'total_price'=> 5750000,

            ],
            [
                'order_id' => 4,
                'variant_id' => 3,
                'quantity' => 2,
                'unit_price' => 1450000,
                'total_price'=> 4750000,

            ],
        ]);
        
    }
}
