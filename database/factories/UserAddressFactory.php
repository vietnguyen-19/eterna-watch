<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAddress>
 */
class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'          => User::inRandomOrder()->first()->id ?? User::factory(),
            'country'          => 'Vietnam',
            'city'             => $this->faker->city,
            'district'         => $this->faker->streetName,
            'ward'             => 'Phường ' . $this->faker->numberBetween(1, 20),
            'specific_address' => $this->faker->address,
            'is_default'       => $this->faker->boolean(30), // 30% có địa chỉ mặc định
        ];
    }
}
