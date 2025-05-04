<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecentOrderSeeder extends Seeder
{
    public function run(): void
    {
        $variants = DB::table('product_variants')->select('id', 'price', 'product_id', 'image')->get();
        $users = User::all();

        if ($variants->isEmpty()) {
            throw new \Exception('Không tìm thấy bản ghi trong bảng product_variants.');
        }

        DB::transaction(function () use ($variants, $users) {
            $orders = [];
            $order_items = [];
            $payments = [];
            $status_histories = [];

            $lastOrderId = DB::table('orders')->max('id') ?? 0;
            $order_id = $lastOrderId + 1;
            $order_index = $order_id;

            $orderCount = 60;
            $startDate = now()->subDays(30);
            $endDate = now();

            for ($i = 0; $i < $orderCount; $i++) {
                $user = $users->random();
                $address = DB::table('user_addresses')->where('user_id', $user->id)->first();

                if (!$address) {
                    // Nếu không có địa chỉ thì bỏ qua
                    continue;
                }

                $created_date = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
                $order_code = sprintf('ORD-%s-%04d', $created_date->format('Ymd'), $order_index);

                $item_count = rand(1, 4);
                $total_amount = 0;

                for ($j = 0; $j < $item_count; $j++) {
                    $variant = $variants->random();
                    $quantity = rand(1, 3);
                    $unit_price = $variant->price;
                    $total_price = $quantity * $unit_price;

                    $product = DB::table('products')->where('id', $variant->product_id)->first();
                    $attribute_value_ids = DB::table('variant_attributes')
                        ->where('variant_id', $variant->id)
                        ->pluck('attribute_value_id')
                        ->toArray();

                    $order_items[] = [
                        'order_id'         => $order_id,
                        'variant_id'       => $variant->id,
                        'product_name'     => $product->name ?? 'Không tên',
                        'image'            => $variant->image ?? null,
                        'value_attributes' => json_encode($attribute_value_ids),
                        'quantity'         => $quantity,
                        'unit_price'       => $unit_price,
                        'total_price'      => $total_price,
                        'created_at'       => $created_date,
                        'updated_at'       => $created_date,
                    ];

                    $total_amount += $total_price;
                }

                // Trạng thái đơn hàng
                $statuses = ['pending', 'confirmed', 'processing', 'shipping', 'completed'];
                $latest_status = end($statuses);

                $orders[] = [
                    'order_code'      => $order_code,
                    'user_id'         => $user->id,
                    'address_id'      => $address->id,

                    'name'            => $user->name,
                    'order_user_id'             => $user->id,
                    'full_name'       => $address->full_name,
                    'phone_number'    => $address->phone_number,
                    'email'           => $address->email,
                    'street_address'  => $address->street_address,
                    'ward'            => $address->ward,
                    'district'        => $address->district,
                    'city'            => $address->city,

                    'payment_method'  => ['cash', 'vnpay'][rand(0, 1)],
                    'status'          => $latest_status,
                    'total_amount'    => $total_amount,
                    'shipping_method' => ['fixed', 'store'][rand(0, 1)],
                    'created_at'      => $created_date,
                    'updated_at'      => $created_date->copy()->addMinutes(count($statuses) * 30),
                ];

                // Status history cho order
                $time = $created_date->copy();
                $prev = null;
                foreach ($statuses as $status) {
                    $status_histories[] = [
                        'entity_id'    => $order_id,
                        'entity_type'  => 'order',
                        'old_status'   => $prev,
                        'new_status'   => $status,
                        'changed_by'   => $users->random()->id,
                        'changed_at'   => $time,
                        'created_at'   => $time,
                        'updated_at'   => $time,
                    ];
                    $prev = $status;
                    $time->addMinutes(30);
                }

                // Payment
                $payment_status = 'completed';
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

            // ✅ Chia batch insert để tránh lỗi too many bindings (nếu cần)
            collect($orders)->chunk(500)->each(fn($chunk) => DB::table('orders')->insert($chunk->toArray()));
            collect($order_items)->chunk(500)->each(fn($chunk) => DB::table('order_items')->insert($chunk->toArray()));
            collect($payments)->chunk(500)->each(fn($chunk) => DB::table('payments')->insert($chunk->toArray()));
            collect($status_histories)->chunk(500)->each(fn($chunk) => DB::table('status_history')->insert($chunk->toArray()));
        });
    }
}
