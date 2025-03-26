<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $voucher = Voucher::inRandomOrder()->first(); // Lấy voucher ngẫu nhiên (có thể null)

        return [
            'order_code' => 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4)),
            'user_id' => $user->id,
            'voucher_id' => $voucher ? $voucher->id : null,
            'total_amount' => 0, // Sẽ tính sau
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'shipping_method' => $this->faker->randomElement(['fixed', 'store', 'free']),
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
