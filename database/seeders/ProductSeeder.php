<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Rolex - Submariner
            ['name' => 'Rolex Submariner Black Dial', 'avatar' => 'products/product1.jpeg', 'brand' => 'Submariner', 'category' => 'Đồng hồ lặn', 'price' => 250000000],
            ['name' => 'Rolex Submariner Green Bezel', 'avatar' => 'products/product2.jpeg', 'brand' => 'Submariner', 'category' => 'Đồng hồ cao cấp', 'price' => 265000000],

            // Omega - Speedmaster
            ['name' => 'Omega Speedmaster Moonwatch', 'avatar' => 'products/product3.jpeg', 'brand' => 'Speedmaster', 'category' => 'Đồng hồ thể thao', 'price' => 200000000],
            ['name' => 'Omega Speedmaster Racing', 'avatar' => 'products/product4.jpeg', 'brand' => 'Speedmaster', 'category' => 'Đồng hồ cơ', 'price' => 180000000],

            // TAG Heuer - Monaco
            ['name' => 'TAG Heuer Monaco Calibre 11', 'avatar' => 'products/product5.jpeg', 'brand' => 'Monaco', 'category' => 'Đồng hồ thể thao', 'price' => 120000000],
            ['name' => 'TAG Heuer Monaco Gulf Edition', 'avatar' => 'products/product6.jpeg', 'brand' => 'Monaco', 'category' => 'Đồng hồ cao cấp', 'price' => 125000000],

            // Seiko - Presage
            ['name' => 'Seiko Presage Cocktail Time', 'avatar' => 'products/product7.jpeg', 'brand' => 'Presage', 'category' => 'Đồng hồ cơ', 'price' => 15000000],
            ['name' => 'Seiko Presage Sharp Edged', 'avatar' => 'products/product8.jpeg', 'brand' => 'Presage', 'category' => 'Đồng hồ nam', 'price' => 17500000],

            // Casio - G-Shock
            ['name' => 'Casio G-Shock GA-2100', 'avatar' => 'products/product9.jpeg', 'brand' => 'G-Shock', 'category' => 'Đồng hồ thể thao', 'price' => 3500000],
            ['name' => 'Casio G-Shock Mudmaster', 'avatar' => 'products/product10.jpeg', 'brand' => 'G-Shock', 'category' => 'Đồng hồ nam', 'price' => 9000000],

            // Citizen - Eco-Drive
            ['name' => 'Citizen Eco-Drive BM8475', 'avatar' => 'products/product11.jpeg', 'brand' => 'Eco-Drive', 'category' => 'Đồng hồ quartz', 'price' => 4200000],
            ['name' => 'Citizen Eco-Drive Titanium', 'avatar' => 'products/product12.jpeg', 'brand' => 'Eco-Drive', 'category' => 'Đồng hồ nam', 'price' => 6200000],

            // Fossil - Chronograph
            ['name' => 'Fossil Townsman Chronograph', 'avatar' => 'products/product13.jpeg', 'brand' => 'Chronograph', 'category' => 'Đồng hồ dây da', 'price' => 4200000],
            ['name' => 'Fossil Machine Chronograph', 'avatar' => 'products/product14.jpeg', 'brand' => 'Chronograph', 'category' => 'Đồng hồ dây kim loại', 'price' => 4600000],

            // Garmin - Forerunner
            ['name' => 'Garmin Forerunner 245', 'avatar' => 'products/product15.jpeg', 'brand' => 'Forerunner', 'category' => 'Đồng hồ thông minh', 'price' => 7200000],
            ['name' => 'Garmin Forerunner 965', 'avatar' => 'products/product16.jpeg', 'brand' => 'Forerunner', 'category' => 'Đồng hồ thể thao', 'price' => 12000000],

            // Apple - Series 9
            ['name' => 'Apple Watch Series 9 GPS', 'avatar' => 'products/product17.jpeg', 'brand' => 'Apple Watch Series 9', 'category' => 'Apple Watch', 'price' => 11500000],
            ['name' => 'Apple Watch Series 9 Cellular', 'avatar' => 'products/product18.jpeg', 'brand' => 'Apple Watch Series 9', 'category' => 'Apple Watch', 'price' => 13500000],

            // Tissot - PRX
            ['name' => 'Tissot PRX Powermatic 80', 'avatar' => 'products/product19.jpeg', 'brand' => 'PRX', 'category' => 'Đồng hồ dây kim loại', 'price' => 16500000],
            ['name' => 'Tissot PRX Quartz', 'avatar' => 'products/product20.jpeg', 'brand' => 'PRX', 'category' => 'Đồng hồ quartz', 'price' => 9500000],

            // Đồng hồ nữ - thời trang
            ['name' => 'Michael Kors Runway Rose Gold', 'avatar' => 'products/product21.jpeg', 'brand' => 'Hybrid', 'category' => 'Đồng hồ thời trang', 'price' => 5500000],
            ['name' => 'Fossil Jacqueline Leather', 'avatar' => 'products/product22.jpeg', 'brand' => 'Hybrid', 'category' => 'Đồng hồ dây da', 'price' => 4500000],

            // Đồng hồ đôi
            ['name' => 'Citizen Cặp Tình Nhân', 'avatar' => 'products/product23.jpeg', 'brand' => 'Quartz', 'category' => 'Đồng hồ cặp tình nhân', 'price' => 7200000],
            ['name' => 'Tissot Cặp Đôi Le Locle', 'avatar' => 'products/product24.jpeg', 'brand' => 'Le Locle', 'category' => 'Đồng hồ cưới', 'price' => 22000000],

            // Apple Watch SE
            ['name' => 'Apple Watch SE 2023', 'avatar' => 'products/product25.jpeg', 'brand' => 'Apple Watch SE', 'category' => 'Apple Watch', 'price' => 8500000],
            ['name' => 'Apple Watch SE GPS', 'avatar' => 'products/product26.jpeg', 'brand' => 'Apple Watch SE', 'category' => 'Apple Watch', 'price' => 8900000],

            // Phụ kiện đồng hồ
            ['name' => 'Dây đồng hồ da thật nâu', 'avatar' => 'products/product27.jpeg', 'brand' => 'Sheen', 'category' => 'Dây đồng hồ', 'price' => 550000],
            ['name' => 'Hộp đựng đồng hồ gỗ 6 ngăn', 'avatar' => 'products/product28.jpeg', 'brand' => 'Edifice', 'category' => 'Hộp đựng đồng hồ', 'price' => 750000],

            // Đồng hồ nữ đính đá
            ['name' => 'Seiko nữ đính đá vàng hồng', 'avatar' => 'products/product29.jpeg', 'brand' => 'Seiko 5', 'category' => 'Đồng hồ đính đá', 'price' => 4600000],
            ['name' => 'Citizen nữ đính đá mạ vàng', 'avatar' => 'products/product30.jpeg', 'brand' => 'Quartz', 'category' => 'Đồng hồ đính đá', 'price' => 5200000],

            // Garmin
            ['name' => 'Garmin Venu 2 Plus', 'avatar' => 'products/product31.jpeg', 'brand' => 'Venu', 'category' => 'Garmin', 'price' => 10500000],
            ['name' => 'Garmin Fenix 7', 'avatar' => 'products/product32.jpeg', 'brand' => 'Fenix', 'category' => 'Garmin', 'price' => 17000000],

            // Samsung Watch
            ['name' => 'Samsung Galaxy Watch 5', 'avatar' => 'products/product33.jpeg', 'brand' => 'Smartwatch', 'category' => 'Samsung Galaxy Watch', 'price' => 7500000],
            ['name' => 'Samsung Galaxy Watch 6 Classic', 'avatar' => 'products/product34.jpeg', 'brand' => 'Smartwatch', 'category' => 'Samsung Galaxy Watch', 'price' => 9500000],

            // Đồng hồ vintage
            ['name' => 'Seiko Automatic Vintage 1960', 'avatar' => 'products/product35.jpeg', 'brand' => 'Seiko 5', 'category' => 'Đồng hồ vintage', 'price' => 8800000],
            ['name' => 'Citizen Vintage Japan', 'avatar' => 'products/product36.jpeg', 'brand' => 'Quartz', 'category' => 'Đồng hồ vintage', 'price' => 7900000],
        ];

        foreach ($products as $p) {
            $brandId = Brand::where('name', $p['brand'])->first()?->id;
            $categoryId = Category::where('name', $p['category'])->first()?->id;

            if ($brandId && $categoryId) {
                Product::create([
                    'name' => $p['name'],
                    'avatar' => $p['avatar'],
                    'short_description' => 'Sản phẩm chất lượng cao, chính hãng.',
                    'full_description' => 'Đồng hồ chính hãng, thiết kế sang trọng, bảo hành 2 năm.',
                    'price_default' => $p['price'],
                    'type' => 'variant',
                    'brand_id' => $brandId,
                    'category_id' => $categoryId,
                    'status' => 'active',
                    'view_count' => rand(100, 1000),
                ]);
            }
        }
    }
}
