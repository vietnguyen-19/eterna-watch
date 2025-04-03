<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            // Thông tin công ty
            ['key' => 'company_name', 'value' => 'EternaWatch', 'type' => 'string'],
            ['key' => 'company_slogan', 'value' => 'Tinh hoa chế tác - Vẻ đẹp vượt thời gian', 'type' => 'string'],
            ['key' => 'company_address', 'value' => 'Số 88, Đại lộ Thời Gian, Quận Trung Tâm, Thành phố Hồ Chí Minh, Việt Nam', 'type' => 'string'],
            ['key' => 'company_email', 'value' => 'lienhe@eternawatch.vn', 'type' => 'string'],
            ['key' => 'company_phone', 'value' => '+84 28 9999 8888', 'type' => 'string'],
            ['key' => 'company_hotline', 'value' => '1800 6868 (Miễn phí cước gọi)', 'type' => 'string'],

            // Mạng xã hội
            ['key' => 'facebook_link', 'value' => 'https://www.facebook.com/eternawatchvn', 'type' => 'string'],
            ['key' => 'twitter_link', 'value' => 'https://twitter.com/eternawatchvn', 'type' => 'string'],
            ['key' => 'instagram_link', 'value' => 'https://www.instagram.com/eternawatchvn', 'type' => 'string'],
            ['key' => 'linkedin_link', 'value' => 'https://www.linkedin.com/company/eternawatchvn', 'type' => 'string'],

            // Logo & Favicon
            ['key' => 'logo_url', 'value' => 'images/logo.png'], 'type' => 'string',
            ['key' => 'bg_auth_url', 'value' => 'settings/bg_auth.jpg', 'type' => 'string'],
            ['key' => 'favicon_url', 'value' => '/storage/images/favicon-eterna.ico', 'type' => 'string'],

            // Chính sách
            ['key' => 'terms_conditions', 'value' => 'Các điều khoản và điều kiện mua hàng tại EternaWatch. Chúng tôi cam kết mang đến sản phẩm chất lượng với chế độ bảo hành tốt nhất.', 'type' => 'string'],
            ['key' => 'privacy_policy', 'value' => 'Chính sách bảo mật của EternaWatch giúp bảo vệ thông tin cá nhân của khách hàng một cách an toàn và tuyệt đối.', 'type' => 'string'],

            // Cấu hình website
            ['key' => 'shipping_fee', 'value' => '50000', 'type' => 'string'],
        ]);

    }
}
