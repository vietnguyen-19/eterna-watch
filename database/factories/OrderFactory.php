<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $voucher = Voucher::inRandomOrder()->first(); // Lấy voucher ngẫu nhiên (có thể null)
        $start = $user->created_at->timestamp;
        $end = now()->subDays(7)->timestamp; // Giới hạn tối đa là 7 ngày trước hiện tại
        $createdAt = Carbon::createFromTimestamp(rand($start, $end));
        return [
            'order_code' => 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4)),
            'user_id' => $user->id,
            'voucher_id' => $voucher ? $voucher->id : null,
            'total_amount' => 0, // Sẽ tính sau
            'status' => $this->faker->randomElement(
                array_merge(
                    array_fill(0, 80, 'completed'),  // 80% completed
                    array_fill(0, 5, 'cancelled'),   // 5% cancelled
                    array_fill(0, 15, 'pending')     // 15% pending
                )
            ),
            'shipping_method' => $this->faker->randomElement(['fixed', 'store', 'free']),
            'created_at' => $createdAt,
            'updated_at' => $createdAt->copy()->addDays(5),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            // Tạo từ 1 đến 5 OrderItems
            $totalAmount = 0;
            $orderItems = collect();

            for ($i = 0; $i < rand(1, 5); $i++) {
                $productVariant = ProductVariant::inRandomOrder()->first() ?? ProductVariant::factory()->create();
                $quantity = rand(1, 5);
                $unitPrice = $productVariant->price ?? $this->faker->randomFloat(2, 50, 500);
                $totalPrice = $quantity * $unitPrice;

                $orderItems->push(new OrderItem([
                    'order_id' => $order->id,
                    'variant_id' => $productVariant->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                ]));

                $totalAmount += $totalPrice;
            }
            // Nếu có voucher, tính giảm giá
            $voucher = $order->voucher;
            $discountAmount = $voucher ? $voucher->calculateDiscount($totalAmount) : 0;
            $finalTotalAmount = max($totalAmount - $discountAmount, 0);

            // Cập nhật tổng tiền
            $order->update(['total_amount' => $finalTotalAmount]);

            // Lưu các order items vào DB
            $order->orderItems()->saveMany($orderItems);
        });
    }
}
