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
            ['key_name' => 'company_name', 'value' => 'EternaWatch'],
            ['key_name' => 'company_slogan', 'value' => 'Tinh hoa chế tác - Vẻ đẹp vượt thời gian'],
            ['key_name' => 'company_address', 'value' => 'Số 88, Đại lộ Thời Gian, Quận Trung Tâm, Thành phố Hồ Chí Minh, Việt Nam'],
            ['key_name' => 'company_email', 'value' => 'lienhe@eternawatch.vn'],
            ['key_name' => 'company_phone', 'value' => '+84 28 9999 8888'],
            ['key_name' => 'company_hotline', 'value' => '1800 6868 (Miễn phí cước gọi)'],

            // Mạng xã hội
            ['key_name' => 'facebook_link', 'value' => 'https://www.facebook.com/eternawatchvn'],
            ['key_name' => 'twitter_link', 'value' => 'https://twitter.com/eternawatchvn'],
            ['key_name' => 'instagram_link', 'value' => 'https://www.instagram.com/eternawatchvn'],
            ['key_name' => 'linkedin_link', 'value' => 'https://www.linkedin.com/company/eternawatchvn'],

            // Logo & Favicon
            ['key_name' => 'logo_url', 'value' => 'images/logo.png'],
            ['key_name' => 'favicon_url', 'value' => '/storage/images/favicon-eterna.ico'],

            // Chính sách
            ['key_name' => 'terms_conditions', 'value' => 'Các điều khoản và điều kiện mua hàng tại EternaWatch. Chúng tôi cam kết mang đến sản phẩm chất lượng với chế độ bảo hành tốt nhất.'],
            ['key_name' => 'privacy_policy', 'value' => 'Chính sách bảo mật của EternaWatch giúp bảo vệ thông tin cá nhân của khách hàng một cách an toàn và tuyệt đối.'],

            // Cấu hình website
            ['key_name' => 'currency', 'value' => 'VND'], // Tiền tệ Việt Nam Đồng
            ['key_name' => 'tax_rate', 'value' => '10'], // Thuế VAT tại Việt Nam (10%)
            ['key_name' => 'shipping_fee', 'value' => '50000'], // Phí vận chuyển mặc định (VND)
        ]);
    
    }
}
