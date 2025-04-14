<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'position' => 'home_start',
                'title' => 'Khám phá Đồng Hồ Cao Cấp',
                'image' => 'banners/home_bg.jpg',
                'link' => '/',
                'description' => 'Mang đến sự đẳng cấp và phong cách thời thượng cho bạn.',
                'is_active' => true,
            ],
            [
                'position' => 'home_new_product',
                'title' => 'Bộ Sưu Tập Mới Nhất',
                'image' => 'banners/new_watches.jpg',
                'link' => '/products/new',
                'description' => 'Những mẫu đồng hồ mới ra mắt, hợp xu hướng 2025.',
                'is_active' => true,
            ],
            [
                'position' => 'login',
                'title' => 'Đăng Nhập Tài Khoản',
                'image' => 'banners/login.jpg',
                'link' => '/login',
                'description' => 'Đăng nhập để quản lý đơn hàng và nhận ưu đãi đặc biệt.',
                'is_active' => true,
            ],
            [
                'position' => 'register',
                'title' => 'Trở Thành Hội Viên',
                'image' => 'banners/register.jpg',
                'link' => '/register',
                'description' => 'Tạo tài khoản để tích điểm và nhận quà tặng hấp dẫn.',
                'is_active' => true,
            ],
            [
                'position' => 'shop',
                'title' => 'Bộ Sưu Tập Đồng Hồ Nam & Nữ',
                'image' => 'banners/shop.jpg',
                'link' => '/shop',
                'description' => 'Đồng hồ chính hãng, bảo hành 5 năm, giao hàng toàn quốc.',
                'is_active' => true,
            ],
            [
                'position' => 'blog',
                'title' => 'Cẩm Nang Chọn Đồng Hồ',
                'image' => 'banners/blog.jpg',
                'link' => '/blog',
                'description' => 'Tư vấn chọn đồng hồ phù hợp với phong cách và nhu cầu.',
                'is_active' => true,
            ],
            [
                'position' => 'forward_password',
                'title' => 'Quên Mật Khẩu?',
                'image' => 'banners/forgot_password.jpg',
                'link' => '/password/forgot',
                'description' => 'Đặt lại mật khẩu một cách nhanh chóng và an toàn.',
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
