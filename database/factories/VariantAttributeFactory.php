<?php

namespace Database\Factories;

use App\Models\AttributeValue;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VariantAttribute>
 */
class VariantAttributeFactory extends Factory
{
    protected $model = VariantAttribute::class;

    public function definition()
    {
        return [
            'variant_id' => ProductVariant::inRandomOrder()->first()->id ?? ProductVariant::factory(),
            'attribute_value_id' => AttributeValue::inRandomOrder()->first()->id ?? AttributeValue::factory(),
        ];
    }
}
