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
            'name' => $this->faker->company . ' ' . $this->faker->randomElement(['Classic', 'Sport', 'Luxury', 'Smart', 'Vintage']),
            'avatar' => 'products/product' . rand(1, 36) . '.jpeg',
            'short_description' => $this->faker->sentence,
            'price_default' => rand(5,500) *10000,
            'full_description' => $this->faker->paragraphs(3, true),
            'category_id' => Category::whereNotNull('parent_id')->inRandomOrder()->first()->id ?? Category::factory(),
            'brand_id' => Brand::whereNotNull('parent_id')->inRandomOrder()->first()->id ?? Brand::factory(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'out_of_stock']),
            'view_count' => rand(1,500) *10,
        ];
        
    }
}
