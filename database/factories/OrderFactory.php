<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'total_price' => $this->faker->randomFloat(2, 1, 1000), // Giá trị tổng
            'order_status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'completed', 'cancelled']),
        ];
    }
}
