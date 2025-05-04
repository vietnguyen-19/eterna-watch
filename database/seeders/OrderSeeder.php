<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $variants = DB::table('product_variants')->select('id', 'price', 'product_id', 'image')->get();

        if ($variants->isEmpty()) {
            throw new \Exception('Không tìm thấy bản ghi trong bảng product_variants.');
        }

        $order_count = [
            6 => 7, 7 => 7, 8 => 7, 9 => 7, 10 => 7,
            11 => 6, 12 => 6, 13 => 6, 14 => 6, 15 => 6,
            16 => 6, 17 => 6, 18 => 6, 19 => 6, 20 => 6,
            21 => 6, 22 => 6, 23 => 6, 24 => 6,
        ];

        $orders = [];
        $order_items = [];
        $payments = [];
        $status_histories = [];

        $order_id = 1;
        $order_index = 1;

        foreach ($order_count as $user_id => $count) {
            $user = User::find($user_id);
            $address = DB::table('user_addresses')->where('user_id', $user_id)->first();

            for ($i = 0; $i < $count; $i++) {
                $start = Carbon::create(2023, 1, 1)->timestamp;
                $end = now()->timestamp;
                $created_date = Carbon::createFromTimestamp(rand($start, $end));
                $order_code = sprintf('ORD-%s-%04d', $created_date->format('Ymd'), $order_index);

                $item_count = rand(1, 3);
                $total_amount = 0;

                for ($j = 0; $j < $item_count; $j++) {
                    $variant = $variants->random();

                    $quantity = rand(1, 4);
                    $unit_price = $variant->price;
                    $total_price = $quantity * $unit_price;

                    $product = DB::table('products')->where('id', $variant->product_id)->first();
                    $attribute_value_ids = DB::table('variant_attributes')
                        ->where('variant_id', $variant->id)
                        ->pluck('attribute_value_id')
                        ->toArray();

                    $order_items[] = [
                        'order_id'        => $order_id,
                        'variant_id'      => $variant->id,
                        'product_name'    => $product->name ?? 'Sản phẩm không tên',
                        'image'           => $variant->image ?? null,
                        'value_attributes'=> json_encode($attribute_value_ids),
                        'quantity'        => $quantity,
                        'unit_price'      => $unit_price,
                        'total_price'     => $total_price,
                        'created_at'      => $created_date,
                        'updated_at'      => $created_date,
                    ];

                    $total_amount += $total_price;
                }

                $status_steps = ['pending', 'confirmed', 'processing', 'completed'];
                $random_state = rand(2, 4);
                $statuses = array_slice($status_steps, 0, $random_state);
                $latest_status = end($statuses);

                $orders[] = [
                    'order_code'       => $order_code,
                    'user_id'          => $user_id,
                    'address_id'       => $address->id ?? null,

                    'name'             => $user->name ?? 'Người dùng không tên',
                    'order_user_id'             => $user->id ?? 'Người dùng',
                    'full_name'        => $address->full_name ?? 'Người nhận không tên',
                    'phone_number'     => $address->phone_number ?? '0000000000',
                    'email'            => $address->email ?? 'example@example.com',
                    'street_address'   => $address->street_address ?? null,
                    'ward'             => $address->ward ?? 'Phường X',
                    'district'         => $address->district ?? 'Quận Y',
                    'city'             => $address->city ?? 'Hà Nội',

                    'payment_method'   => ['cash', 'vnpay'][rand(0, 1)],
                    'status'           => $latest_status,
                    'total_amount'     => $total_amount,
                    'shipping_method'  => ['fixed', 'store'][rand(0, 1)],
                    'created_at'       => $created_date,
                    'updated_at'       => $created_date->copy()->addMinutes($random_state * 30),
                ];

                $status_time = $created_date->copy();
                $previous = null;
                foreach ($statuses as $status) {
                    if ($previous !== null) {
                        $status_histories[] = [
                            'entity_id'    => $order_id,
                            'entity_type'  => 'order',
                            'old_status'   => $previous,
                            'new_status'   => $status,
                            'changed_by'   => User::whereIn('role_id', [1, 2])->inRandomOrder()->value('id') ?? 1,
                            'changed_at'   => $status_time,
                            'created_at'   => $status_time,
                            'updated_at'   => $status_time,
                        ];
                    }
                    $previous = $status;
                    $status_time->addMinutes(30);
                }

                $payment_statuses = ['pending', 'completed', 'failed'];
                $payment_status = $payment_statuses[array_rand($payment_statuses)];
                $payment_time = $created_date->copy()->addMinutes(rand(20, 90));

                $payments[] = [
                    'order_id'       => $order_id,
                    'amount'         => $total_amount,
                    'payment_status' => $payment_status,
                    'transaction_id' => strtoupper(Str::random(10)),
                    'payment_date'   => $payment_time,
                    'created_at'     => $payment_time,
                    'updated_at'     => $payment_time,
                ];

                $status_histories[] = [
                    'entity_id'    => $order_id,
                    'entity_type'  => 'payment',
                    'old_status'   => 'pending',
                    'new_status'   => $payment_status,
                    'changed_by'   => null,
                    'changed_at'   => $payment_time,
                    'created_at'   => $payment_time,
                    'updated_at'   => $payment_time,
                ];

                $order_id++;
                $order_index++;
            }
        }

        DB::table('orders')->insert($orders);
        DB::table('order_items')->insert($order_items);
        DB::table('payments')->insert($payments);
        DB::table('status_history')->insert($status_histories);
    }
}
