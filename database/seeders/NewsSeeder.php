<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder {
    public function run() {
        News::create([
            'title' => 'Đồng hồ Rolex mới ra mắt',
            'slug' => Str::slug('Đồng hồ Rolex mới ra mắt'),
            'content' => 'Rolex vừa ra mắt dòng sản phẩm mới với thiết kế tinh tế.',
            'image' => 'images/rolex.jpg'
        ]);

        News::create([
            'title' => 'Xu hướng đồng hồ 2025',
            'slug' => Str::slug('Xu hướng đồng hồ 2025'),
            'content' => 'Các chuyên gia dự đoán xu hướng đồng hồ năm 2025 sẽ là...',
            'image' => 'images/trends-2025.jpg'
        ]);
    }
}
