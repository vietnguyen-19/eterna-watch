<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $productVariant = ProductVariant::inRandomOrder()->first() ?? ProductVariant::factory()->create();
        $order = Order::inRandomOrder()->first() ?? Order::factory()->create();
        $quantity = $this->faker->numberBetween(1, 5);
        $unit_price = $productVariant->price ?? $this->faker->randomFloat(2, 50, 500);
        $total_price = $quantity * $unit_price;

        return [
            'order_id' => $order->id,
            'variant_id' => $productVariant->id,
            'quantity' => $quantity,
            'unit_price' => $unit_price,
            'total_price' => $total_price,
        ];
    }
    
}
