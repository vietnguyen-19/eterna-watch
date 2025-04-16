<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $variants = DB::table('product_variants')->select('id', 'price')->get()->toArray();
        if (empty($variants)) {
            throw new \Exception('Không tìm thấy bản ghi trong bảng product_variants.');
        }

        $order_count = [
            6 => 7,
            7 => 7,
            8 => 7,
            9 => 7,
            10 => 7,
            11 => 6,
            12 => 6,
            13 => 6,
            14 => 6,
            15 => 6,
            16 => 6,
            17 => 6,
            18 => 6,
            19 => 6,
            20 => 6,
            21 => 6,
            22 => 6,
            23 => 6,
            24 => 6,
        ];

        $orders = [];
        $order_items = [];
        $payments = [];
        $status_histories = [];

        $order_id = 1;
        $order_index = 1;

        foreach ($order_count as $user_id => $count) {
            for ($i = 0; $i < $count; $i++) {
                $start = Carbon::create(2023, 1, 1)->timestamp;
                $end = now()->timestamp;
                $created_date = Carbon::createFromTimestamp(rand($start, $end));
                $order_code = sprintf('ORD-%s-%04d', $created_date->format('Ymd'), $order_index);

                $item_count = rand(1, 3);
                $total_amount = 0;

                for ($j = 0; $j < $item_count; $j++) {
                    $variant = $variants[array_rand($variants)];
                    $quantity = rand(1, 4);
                    $unit_price = $variant->price;
                    $total_price = $quantity * $unit_price;

                    $order_items[] = [
                        'order_id' => $order_id,
                        'variant_id' => $variant->id,
                        'quantity' => $quantity,
                        'unit_price' => $unit_price,
                        'total_price' => $total_price,
                    ];

                    $total_amount += $total_price;
                }

                // --- Gán status logic cho order ---
                $status_steps = ['pending', 'confirmed', 'processing', 'completed'];
                $random_state = rand(2, 4); // Số bước trạng thái
                $statuses = array_slice($status_steps, 0, $random_state);

                $latest_status = end($statuses);

                // Ghi đơn hàng
                $orders[] = [
                    'order_code' => $order_code,
                    'user_id' => $user_id,
                    'address_id' => $user_id*2-1,
                    'status' => $latest_status,
                    'total_amount' => $total_amount,
                    'shipping_method' => ['fixed', 'store'][rand(0, 1)],
                    'created_at' => $created_date,
                    'updated_at' => $created_date->copy()->addMinutes($random_state * 30),
                ];

                // Tạo status history cho order
                $status_time = $created_date->copy();
                $previous = null;
                foreach ($statuses as $status) {
                    if ($previous !== null) {
                        $status_histories[] = [
                            'entity_id' => $order_id,
                            'entity_type' => 'order',
                            'old_status' => $previous,
                            'new_status' => $status,
                            'changed_by' => User::whereIn('role_id', [1, 2])->inRandomOrder()->value('id') ?? 1,
                            'changed_at' => $status_time,
                            'created_at' => $status_time,
                            'updated_at' => $status_time,
                        ];
                    }
                    $previous = $status;
                    $status_time->addMinutes(30);
                }

                // --- Tạo Payment ---
                $payment_statuses = ['pending', 'completed', 'failed'];
                $payment_status = $payment_statuses[array_rand($payment_statuses)];
                $payment_time = $created_date->copy()->addMinutes(rand(20, 90));

                $payments[] = [
                    'order_id' => $order_id,
                    'payment_method' => ['cod', 'bank_transfer', 'credit_card'][rand(0, 2)],
                    'amount' => $total_amount,
                    'payment_status' => $payment_status,
                    'transaction_id' => strtoupper(Str::random(10)),
                    'payment_date' => $payment_time,
                    'created_at' => $payment_time,
                    'updated_at' => $payment_time,
                ];

                // Tạo status history cho payment
                $status_histories[] = [
                    'entity_id' => $order_id,
                    'entity_type' => 'payment',
                    'old_status' => 'pending',
                    'new_status' => $payment_status,
                    'changed_by' => null,
                    'changed_at' => $payment_time,
                    'created_at' => $payment_time,
                    'updated_at' => $payment_time,
                ];

                $order_id++;
                $order_index++;
            }
        }

        // Chèn vào DB
        DB::table('orders')->insert($orders);
        DB::table('order_items')->insert($order_items);
        DB::table('payments')->insert($payments);
        DB::table('status_history')->insert($status_histories);
    }
}
