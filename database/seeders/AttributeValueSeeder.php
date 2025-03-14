<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributeValues = [
            // Màu sắc
            ['attribute_id' => 1, 'value_name' => 'Đen', 'note' => '#000000', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_id' => 1, 'value_name' => 'Trắng', 'note' => '#FFFFFF', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_id' => 1, 'value_name' => 'Xanh', 'note' => '#0000FF', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Chống nước
            ['attribute_id' => 2, 'value_name' => '3 ATM', 'note' => 'Chịu nước nhẹ', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_id' => 2, 'value_name' => '5 ATM', 'note' => 'Rửa tay, đi mưa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_id' => 2, 'value_name' => '10 ATM', 'note' => 'Bơi lội', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Chất liệu dây
            ['attribute_id' => 3, 'value_name' => 'Thép không gỉ', 'note' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_id' => 3, 'value_name' => 'Dây da', 'note' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_id' => 3, 'value_name' => 'Dây cao su', 'note' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Chất liệu mặt kính
            ['attribute_id' => 4, 'value_name' => 'Kính Sapphire', 'note' => 'Chống xước tốt', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_id' => 4, 'value_name' => 'Kính khoáng', 'note' => 'Giá rẻ hơn, dễ trầy', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_id' => 4, 'value_name' => 'Plexiglass', 'note' => 'Nhựa tổng hợp', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kiểu máy
            ['attribute_id' => 5, 'value_name' => 'Quartz', 'note' => 'Máy pin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_id' => 5, 'value_name' => 'Automatic', 'note' => 'Máy cơ tự động', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_id' => 5, 'value_name' => 'Hand-Winding', 'note' => 'Máy cơ lên dây cót', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Đường kính mặt
            ['attribute_id' => 6, 'value_name' => '36mm', 'note' => 'Nhỏ gọn', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_id' => 6, 'value_name' => '40mm', 'note' => 'Vừa phải', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_id' => 6, 'value_name' => '44mm', 'note' => 'Lớn', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('attribute_values')->insert($attributeValues);
    }
}
