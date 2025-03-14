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
        // Lấy danh sách sản phẩm cùng giá mặc định
        $products = DB::table('products')->select('id', 'price_default')->get();

        foreach ($products as $product) {
            // Bước 1: Chọn ngẫu nhiên 2 thuộc tính
            $attributes = DB::table('attributes')->inRandomOrder()->limit(2)->pluck('id');

            // Lưu vào bảng ProductHasAttribute
            foreach ($attributes as $attribute_id) {
                DB::table('product_has_attributes')->insert([
                    'product_id'   => $product->id,
                    'attribute_id' => $attribute_id,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }

            // Bước 2: Lấy danh sách giá trị thuộc tính cho 2 thuộc tính đã chọn
            $attributeValues = [];
            foreach ($attributes as $attribute_id) {
                $values = DB::table('attribute_values')
                    ->where('attribute_id', $attribute_id)
                    ->pluck('id')
                    ->toArray();
                $attributeValues[] = $values;
            }

            // Bước 3: Tạo 5 biến thể sản phẩm (đảm bảo không trùng lặp)
            $variants = [];
            $generatedSKUs = []; // Danh sách SKU đã tạo để kiểm tra trùng

            while (count($variants) < 5) {
                // Chọn giá trị thuộc tính cho biến thể
                $selectedValues = [];
                foreach ($attributeValues as $values) {
                    if (!empty($values)) {
                        $selectedValues[] = $values[array_rand($values)];
                    }
                }

                // Sắp xếp để tránh trùng lặp do thứ tự khác nhau
                sort($selectedValues);
                $sku = 'SKU-' . $product->id . '-' . implode('-', $selectedValues);

                // Kiểm tra xem SKU đã tồn tại chưa
                if (
                    in_array($sku, $generatedSKUs) ||
                    DB::table('product_variants')->where('sku', $sku)->exists()
                ) {
                    continue; // Bỏ qua nếu SKU đã tồn tại
                }

                // Thêm SKU vào danh sách đã tạo
                $generatedSKUs[] = $sku;

                // Tạo biến thể mới
                $price = $product->price_default + rand(1, 50) * 10000;
                $stock = rand(5, 20);
                $image = 'products/product' . rand(1, 36) . '.jpeg';

                $variant_id = DB::table('product_variants')->insertGetId([
                    'product_id' => $product->id,
                    'sku'        => $sku,
                    'price'      => $price,
                    'stock'      => $stock,
                    'image'      => $image,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Lưu variant_id để dùng cho bước tiếp theo
                $variants[$variant_id] = $selectedValues;
            }

            // Bước 4: Gán giá trị thuộc tính cho từng biến thể
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
}
