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
    public function run()
    {
        // Lấy danh sách sản phẩm
        $products = DB::table('products')->select('id', 'price_default', 'stock', 'type', 'avatar')->get();


        foreach ($products as $product) {
            if ($product->type === 'simple') {
                // Nếu sản phẩm là simple, chỉ tạo 1 biến thể duy nhất
                DB::table('product_variants')->insert([
                    'product_id' => $product->id,
                    'sku'        => 'SKU-' . $product->id,
                    'price'      => $product->price_default,
                    'stock'      => $product->stock ?? 10,
                    'image'      => $product->avatar,
                    'status'     => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                // Nếu sản phẩm là variable, tạo nhiều biến thể như trước
                $attributes = DB::table('attributes')->inRandomOrder()->limit(2)->pluck('id');

                foreach ($attributes as $attribute_id) {
                    DB::table('product_has_attributes')->insert([
                        'product_id'   => $product->id,
                        'attribute_id' => $attribute_id,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);
                }

                $attributeValues = [];
                foreach ($attributes as $attribute_id) {
                    $values = DB::table('attribute_values')
                        ->where('attribute_id', $attribute_id)
                        ->pluck('id')
                        ->toArray();
                    $attributeValues[] = $values;
                }

                $variants = [];
                $generatedSKUs = [];

                while (count($variants) < 5) {
                    $selectedValues = [];
                    foreach ($attributeValues as $values) {
                        if (!empty($values)) {
                            $selectedValues[] = $values[array_rand($values)];
                        }
                    }

                    sort($selectedValues);
                    $sku = 'SKU-' . $product->id . '-' . implode('-', $selectedValues);

                    if (
                        in_array($sku, $generatedSKUs) ||
                        DB::table('product_variants')->where('sku', $sku)->exists()
                    ) {
                        continue;
                    }

                    $generatedSKUs[] = $sku;

                    $price = $product->price_default + rand(1, 50) * 10000;
                    $stock = rand(5, 20);

                    $variant_id = DB::table('product_variants')->insertGetId([
                        'product_id' => $product->id,
                        'sku'        => $sku,
                        'price'      => $price,
                        'stock'      => $stock,
                        'image'      => null,
                        'status'     => 'active',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $variants[$variant_id] = $selectedValues;
                }

                foreach ($variants as $variant_id => $selectedValues) {
                    foreach ($selectedValues as $attribute_value_id) {
                        DB::table('variant_attributes')->insert([
                            'variant_id'         => $variant_id,
                            'attribute_value_id' => $attribute_value_id,
                        ]);
                    }
                }
            }
        }

        // Gán hình ảnh cho tất cả variant
        $variants = ProductVariant::all();
        foreach ($variants as $index => $variant) {
            $variant->image = 'product_variants/product_variant' . ($index + 1) . '.jpeg';
            $variant->save();
        }
    }
}
