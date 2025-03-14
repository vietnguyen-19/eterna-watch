<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mảng các tag phù hợp với bài viết của website ban sdodongj
        $tags = [
            'Giới thiệu',
            'Tin tức',
            'Khuyến mãi',
            'Sản phẩm mới',
            'Hướng dẫn',
            'Review',
            'Công nghệ',
            'Sự kiện',
            'Phân tích',
            'Bí quyết'
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName
            ]);
        }
    }
}
