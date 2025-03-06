<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'avatar' => 'avatar/avatar' . rand(1,15) . '.jpeg',
            'price_default'=> 500000,
            'short_description' => $this->faker->sentence,
            'full_description' => $this->faker->paragraph,
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'brand_id' => Brand::inRandomOrder()->first()->id ?? Brand::factory(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'out_of_stock']),
        ];
    }
}
