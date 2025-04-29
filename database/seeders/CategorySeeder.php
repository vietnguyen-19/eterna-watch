<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Danh mục cấp 1 (chính)
        $categories = [
            'Đồng hồ nam',
            'Đồng hồ nữ',
            'Đồng hồ đôi',
            'Đồng hồ thông minh',
            'Phụ kiện đồng hồ'
        ];

        $parentIds = [];

        $index = 1;

        foreach ($categories as $category) {
            $parentIds[$category] = Category::create([
                'name' => $category,
                'image' => 'categories/cate' . $index . '.jpg', // Thêm ảnh cho danh mục gốc
                'parent_id' => null,
                'status' => 1,
            ])->id;
            $index++;
        }

        // Danh mục con
        $subCategories = [
            'Đồng hồ nam' => ['Đồng hồ cơ', 'Đồng hồ quartz', 'Đồng hồ lặn', 'Đồng hồ thể thao', 'Đồng hồ cao cấp'],
            'Đồng hồ nữ' => ['Đồng hồ thời trang', 'Đồng hồ đính đá', 'Đồng hồ dây da', 'Đồng hồ dây kim loại', 'Đồng hồ thông minh'],
            'Đồng hồ đôi' => ['Đồng hồ cặp tình nhân', 'Đồng hồ cưới', 'Đồng hồ anniversary'],
            'Đồng hồ thông minh' => ['Apple Watch', 'Samsung Galaxy Watch', 'Garmin', 'Xiaomi', 'HUAWEI'],
            'Phụ kiện đồng hồ' => ['Dây đồng hồ', 'Hộp đựng đồng hồ', 'Pin đồng hồ', 'Kính đồng hồ', 'Dịch vụ bảo trì']
        ];

        foreach ($subCategories as $parent => $subs) {
            foreach ($subs as $sub) {
                Category::create([
                    'name' => $sub,
                    'parent_id' => $parentIds[$parent],
                    'status' => 1,
                ]);
            }
        }
    }
}
