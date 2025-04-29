<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::select('id', 'price_default', 'stock', 'type', 'avatar')->get();

        foreach ($products as $product) {
            if ($product->type === 'simple') {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => 'SKU-' . $product->id . '-SIMPLE',
                    'price' => $product->price_default,
                    'stock' => $product->stock ?? 50,
                    'image' => $product->avatar,
                    'status' => 'active',
                ]);
            } else {
                $attributes = DB::table('attributes')->inRandomOrder()->limit(2)->pluck('id')->toArray();

                if (empty($attributes)) {
                    continue;
                }

                foreach ($attributes as $attribute_id) {
                    DB::table('product_has_attributes')->insert([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $attributeValues = [];
                foreach ($attributes as $attribute_id) {
                    $values = DB::table('attribute_values')
                        ->where('attribute_id', $attribute_id)
                        ->pluck('id')
                        ->toArray();
                    if (empty($values)) {
                        continue 2; // Bỏ qua sản phẩm này
                    }
                    $attributeValues[] = $values;
                }

                $variants = [];
                $generatedSKUs = [];
                $maxVariants = min(5, count($attributeValues[0]) * count($attributeValues[1] ?? [1]));

                while (count($variants) < $maxVariants) {
                    $selectedValues = [];
                    foreach ($attributeValues as $values) {
                        $selectedValues[] = $values[array_rand($values)];
                    }

                    sort($selectedValues);
                    $sku = 'SKU-' . $product->id . '-' . implode('-', $selectedValues);

                    if (in_array($sku, $generatedSKUs)) {
                        continue;
                    }

                    $generatedSKUs[] = $sku;

                    $price = $product->price_default + rand(1, 50) * 10000;
                    $stock = rand(5, 20);

                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => $sku,
                        'price' => $price,
                        'stock' => $stock,
                        'image' => null,
                        'status' => 'active',
                    ]);

                    $variants[$variant->id] = $selectedValues;
                }

                foreach ($variants as $variant_id => $selectedValues) {
                    foreach ($selectedValues as $attribute_value_id) {
                        DB::table('variant_attributes')->insert([
                            'variant_id' => $variant_id,
                            'attribute_value_id' => $attribute_value_id,
                        ]);
                    }
                }
            }
        }

        $variants = ProductVariant::whereNull('image')->get();
        foreach ($variants as $index => $variant) {
            $imagePath = 'product_variants/product_variant' . ($index + 1) . '.jpeg';
            $variant->image = $imagePath;
            $variant->save();
        }
    }
}
