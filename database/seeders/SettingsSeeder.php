<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa tất cả dữ liệu cũ trong bảng 'settings'
        DB::table('settings')->truncate();

        $settings = [
            // Thông tin công ty
            ['key' => 'company_name', 'value' => 'EternaWatch', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'company_slogan', 'value' => 'Tinh hoa chế tác - Vẻ đẹp vượt thời gian', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'company_address', 'value' => 'Số 88, Đại lộ Thời Gian, Quận Trung Tâm, Thành phố Hồ Chí Minh, Việt Nam', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'company_email', 'value' => 'lienhe@eternawatch.vn', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'company_phone', 'value' => '+84 28 9999 8888', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'company_hotline', 'value' => '1800 6868 (Miễn phí cước gọi)', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Mạng xã hội
            ['key' => 'facebook_link', 'value' => 'https://www.facebook.com/eternawatchvn', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'twitter_link', 'value' => 'https://twitter.com/eternawatchvn', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'instagram_link', 'value' => 'https://www.instagram.com/eternawatchvn', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'linkedin_link', 'value' => 'https://www.linkedin.com/company/eternawatchvn', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Logo & Favicon
            ['key' => 'logo_url', 'value' => 'images/logo.png', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'bg_auth_url', 'value' => 'settings/bg_auth.jpg', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'favicon_url', 'value' => '/storage/images/favicon-eterna.ico', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Chính sách
            ['key' => 'terms_conditions', 'value' => 'Các điều khoản và điều kiện mua hàng tại EternaWatch. Chúng tôi cam kết mang đến sản phẩm chất lượng với chế độ bảo hành tốt nhất.', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'privacy_policy', 'value' => 'Chính sách bảo mật của EternaWatch giúp bảo vệ thông tin cá nhân của khách hàng một cách an toàn và tuyệt đối.', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Cấu hình website
            ['key' => 'shipping_fee', 'value' => '50000', 'type' => 'string'],
        ];

            ['key' => 'shipping_fee', 'value' => '50000', 'type' => 'string', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
        ];

        DB::table('settings')->insert($settings);
    }
}
