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
        $fullDesc = '
        <h5>Đồng Hồ Đeo Tay Cao Cấp – Tinh Hoa Của Thời Gian</h5>
        
        <p>Đồng hồ không chỉ đơn thuần là công cụ để đo thời gian, mà còn là một phụ kiện thời trang thể hiện phong cách, cá tính và gu thẩm mỹ của người sở hữu. Một chiếc đồng hồ cao cấp là món đồ không thể thiếu trong bộ sưu tập của những người yêu thích sự sang trọng và đẳng cấp. Đồng hồ không chỉ giúp bạn dễ dàng theo dõi thời gian mà còn là điểm nhấn ấn tượng, thu hút ánh nhìn trong mọi hoàn cảnh.</p>
        
        <h5>Chất Liệu Cao Cấp – Độ Bền Vượt Thời Gian</h5>
        <p>Đồng hồ cao cấp thường được chế tác từ những chất liệu cao cấp như <strong>thép không gỉ 316L</strong> cho phần vỏ, mang lại sự bền bỉ và khả năng chống oxy hóa, giúp sản phẩm giữ được vẻ đẹp hoàn hảo theo thời gian. Dây đeo được làm từ <strong>da thật</strong> mềm mại hoặc <strong>cao su siêu bền</strong>, mang lại cảm giác thoải mái khi đeo và dễ dàng điều chỉnh phù hợp với cổ tay của người sử dụng. Mặt kính đồng hồ được làm từ kính <strong>sapphire</strong> cao cấp, chống trầy xước và mang lại độ trong suốt tuyệt vời, giúp bạn dễ dàng xem giờ một cách rõ ràng nhất.</p>
        
        <h5>Thiết Kế Tinh Tế – Phù Hợp Với Mọi Dự Tiệc</h5>
        <p>Với sự kết hợp giữa các chi tiết kim, vạch chỉ giờ và mặt đồng hồ, chiếc đồng hồ cao cấp mang lại sự cân đối và hài hòa, khiến người đeo luôn cảm thấy tự tin và thoải mái. Thiết kế mặt đồng hồ tinh tế với kiểu dáng <strong>tròn</strong> hoặc <strong>vuông</strong> cùng màu sắc trung tính, phù hợp với nhiều phong cách thời trang khác nhau, từ trang phục công sở đến những bộ đồ dạ tiệc sang trọng. Đặc biệt, với khả năng chống nước lên đến <strong>50m</strong>, đồng hồ vẫn có thể hoạt động tốt khi bạn rửa tay hay đi mưa nhẹ mà không lo hỏng hóc.</p>
        
        <h5>Độ Chính Xác Tuyệt Vời – Chỉ Số Đồng Hồ Chính Xác Cao</h5>
        <p>Được trang bị bộ máy <strong>quartz</strong> hoặc <strong>automatic</strong> với độ chính xác cao, chiếc đồng hồ này đảm bảo rằng bạn luôn biết thời gian chính xác nhất mà không phải lo lắng về việc điều chỉnh đồng hồ quá thường xuyên. Đồng hồ có khả năng hoạt động ổn định, thậm chí khi thay đổi múi giờ hay trong môi trường có sự thay đổi về nhiệt độ và độ ẩm.</p>
        
        <h5>Tính Năng Đa Dạng – Phù Hợp Mọi Nhu Cầu</h5>
        <ul>
          <li><strong>Chức năng bấm giờ (Chronograph):</strong> Thích hợp cho những ai yêu thích thể thao, giúp theo dõi thời gian chính xác trong mỗi lần thi đấu.</li>
          <li><strong>Chức năng ngày/giờ:</strong> Giúp bạn dễ dàng xem ngày và giờ mà không cần phải tra cứu lịch trên điện thoại.</li>
          <li><strong>Đèn nền sáng:</strong> Đảm bảo bạn có thể xem giờ ngay cả trong bóng tối, đặc biệt khi di chuyển vào ban đêm.</li>
        </ul>
        
        <h5>Đồng Hồ Cao Cấp – Đầu Tư Xứng Đáng</h5>
        <p>Đồng hồ cao cấp không chỉ là một món đồ trang sức, mà còn là một sự đầu tư lâu dài. Với thiết kế bền vững, chất liệu cao cấp và bộ máy hoạt động ổn định, chiếc đồng hồ này sẽ luôn đồng hành cùng bạn trong suốt những năm tháng tới. Đặc biệt, nếu được bảo quản và bảo dưỡng đúng cách, đồng hồ có thể trở thành món đồ có giá trị gia tăng theo thời gian.</p>
        
        <h5>Bảo Hành Và Dịch Vụ Khách Hàng Tận Tâm</h5>
        <p>Đồng hồ cao cấp đi kèm với chính sách bảo hành lên đến <strong>5 năm</strong> cho bộ máy và <strong>1 năm</strong> cho dây đeo, kính. Ngoài ra, bạn còn nhận được sự hỗ trợ tận tình từ đội ngũ dịch vụ khách hàng của chúng tôi, đảm bảo chiếc đồng hồ luôn hoạt động trong tình trạng tốt nhất. Chúng tôi cũng cung cấp dịch vụ thay dây đồng hồ, sửa chữa và bảo dưỡng sản phẩm ngay tại cửa hàng.</p>
        
        <p>Với những ưu điểm vượt trội về chất lượng, tính năng và thiết kế, chiếc đồng hồ cao cấp là sự lựa chọn hoàn hảo dành cho những ai yêu thích sự tinh tế và đẳng cấp. Đừng để thời gian trôi qua mà không sở hữu một sản phẩm xứng tầm, giúp bạn ghi dấu ấn cá nhân trong mỗi khoảnh khắc.</p>
        ';

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
            ['name' => 'Tissot PRX Powermatic 80', 'avatar' => 'products/product19.jpeg', 'brand' => 'Tissot', 'category' => 'Đồng hồ cơ', 'price' => 16500000],
            ['name' => 'Tissot PRX Quartz', 'avatar' => 'products/product20.jpeg', 'brand' => 'Tissot', 'category' => 'Đồng hồ quartz', 'price' => 9500000],
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
            ['name' => 'Seiko Automatic Vintage 1960',  'avatar' => 'products/product35.jpeg', 'brand' => 'Seiko 5', 'category' => 'Đồng hồ vintage', 'price' => 8800000],
            ['name' => 'Citizen Vintage Japan', 'avatar' => 'products/product36.jpeg', 'brand' => 'Quartz', 'category' => 'Đồng hồ vintage', 'price' => 7900000],
            ['name' => 'Seiko Presage Cocktail Time','stock'=>100, 'avatar' => 'products/product37.jpeg', 'brand' => 'Seiko', 'category' => 'Đồng hồ cơ', 'price' => 13800000],
            ['name' => 'Casio G-Shock GA-2100','stock'=>100, 'avatar' => 'products/product38.jpeg', 'brand' => 'Casio', 'category' => 'Đồng hồ thể thao', 'price' => 3600000],
            ['name' => 'Citizen Eco-Drive Chandler', 'stock'=>100,'avatar' => 'products/product39.jpeg', 'brand' => 'Citizen', 'category' => 'Đồng hồ năng lượng ánh sáng', 'price' => 4900000],
            ['name' => 'Orient Bambino Version IV','stock'=>100, 'avatar' => 'products/product40.jpeg', 'brand' => 'Orient', 'category' => 'Đồng hồ cơ', 'price' => 5300000],

        ];
        foreach ($products as $index => $p) {
            $brandId = Brand::where('name', $p['brand'])->first()?->id;
            $categoryId = Category::where('name', $p['category'])->first()?->id;

            if ($brandId && $categoryId) {
                Product::create([
                    'name' => $p['name'],
                    'avatar' => $p['avatar'],
                    'short_description' => 'Đồng hồ này là minh chứng cho sự giao thoa hoàn hảo giữa kỹ thuật chế tác thủ công tinh xảo và nghệ thuật thiết kế đỉnh cao, thể hiện đẳng cấp vượt thời gian dành cho những ai trân trọng giá trị thật sự của sự hoàn mỹ. Với phần vỏ được làm từ thép không gỉ 316L cao cấp hoặc vàng 18K nguyên khối, kết hợp cùng mặt kính sapphire chống trầy xước tuyệt đối, sản phẩm mang đến sự bền bỉ và vẻ đẹp trường tồn với thời gian. Bộ máy Automatic Thụy Sĩ được tích hợp bên trong hoạt động bền bỉ, có khả năng trữ cót lên tới 40 giờ, đảm bảo độ chính xác cao và chuyển động êm ái theo từng nhịp đập.',
                    'full_description' => $fullDesc,
                    'price_default' => $p['price'],
                    'stock'=>$p['stock'] ?? null,
                    'type' => $index < 36 ? 'variant' : 'simple', // <--- Phân loại ở đây
                    'brand_id' => $brandId,
                    'category_id' => $categoryId,
                    'status' => 'active',
                    'view_count' => rand(100, 1000),
                ]);
            }
        }
    }
}
