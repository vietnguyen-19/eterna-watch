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
    <div style="font-family: Arial, sans-serif; font-size: 15px; line-height: 1.6; color: #333;">
        <h5 style="font-size: 18px; color: #b42020;">Đồng hồ đeo tay cao cấp – Tinh hoa của thời gian</h5>
        <p>Đồng hồ không chỉ đơn thuần là công cụ để đo thời gian, mà còn là một phụ kiện thời trang thể hiện phong cách, cá tính và gu thẩm mỹ của người sở hữu. Một chiếc đồng hồ cao cấp là món đồ không thể thiếu trong bộ sưu tập của những người yêu thích sự sang trọng và đẳng cấp. Đồng hồ không chỉ giúp bạn dễ dàng theo dõi thời gian mà còn là điểm nhấn ấn tượng, thu hút ánh nhìn trong mọi hoàn cảnh.</p>

        <h5 style="font-size: 18px; color: #b42020;">Chất liệu cao cấp – Độ bền vượt thời gian</h5>
        <p>Đồng hồ cao cấp thường được chế tác từ những chất liệu cao cấp như <strong>thép không gỉ 316L</strong> cho phần vỏ, mang lại sự bền bỉ và khả năng chống oxy hóa, giúp sản phẩm giữ được vẻ đẹp hoàn hảo theo thời gian. Dây đeo được làm từ <strong>da thật</strong> mềm mại hoặc <strong>cao su siêu bền</strong>, mang lại cảm giác thoải mái khi đeo và dễ dàng điều chỉnh phù hợp với cổ tay của người sử dụng. Mặt kính đồng hồ được làm từ kính <strong>sapphire</strong> cao cấp, chống trầy xước và mang lại độ trong suốt tuyệt vời, giúp bạn dễ dàng xem giờ một cách rõ ràng nhất.</p>

        <h5 style="font-size: 18px; color: #b42020;">Thiết kế tinh tế – Phù hợp với mọi dự tiệc</h5>
        <p>Với sự kết hợp giữa các chi tiết kim, vạch chỉ giờ và mặt đồng hồ, chiếc đồng hồ cao cấp mang lại sự cân đối và hài hòa, khiến người đeo luôn cảm thấy tự tin và thoải mái. Thiết kế mặt đồng hồ tinh tế với kiểu dáng <strong>tròn</strong> hoặc <strong>vuông</strong> cùng màu sắc trung tính, phù hợp với nhiều phong cách thời trang khác nhau, từ trang phục công sở đến những bộ đồ dạ tiệc sang trọng. Đặc biệt, với khả năng chống nước lên đến <strong>50m</strong>, đồng hồ vẫn có thể hoạt động tốt khi bạn rửa tay hay đi mưa nhẹ mà không lo hỏng hóc.</p>

        <h5 style="font-size: 18px; color: #b42020;">Độ chính xác tuyệt vời – Chỉ số đồng hồ chính xác cao</h5>
        <p>Được trang bị bộ máy <strong>quartz</strong> hoặc <strong>automatic</strong> với độ chính xác cao, chiếc đồng hồ này đảm bảo rằng bạn luôn biết thời gian chính xác nhất mà không phải lo lắng về việc điều chỉnh đồng hồ quá thường xuyên. Đồng hồ có khả năng hoạt động ổn định, thậm chí khi thay đổi múi giờ hay trong môi trường có sự thay đổi về nhiệt độ và độ ẩm.</p>

        <h5 style="font-size: 18px; color: #b42020;">Tính năng đa dạng – Phù hợp mọi nhu cầu</h5>
        <ul style="margin-left: 20px; padding-left: 0;">
            <li><strong>Chức năng bấm giờ (Chronograph):</strong> Thích hợp cho những ai yêu thích thể thao, giúp theo dõi thời gian chính xác trong mỗi lần thi đấu.</li>
            <li><strong>Chức năng ngày/giờ:</strong> Giúp bạn dễ dàng xem ngày và giờ mà không cần phải tra cứu lịch trên điện thoại.</li>
            <li><strong>Đèn nền sáng:</strong> Đảm bảo bạn có thể xem giờ ngay cả trong bóng tối, đặc biệt khi di chuyển vào ban đêm.</li>
        </ul>

        <h5 style="font-size: 18px; color: #b42020;">Đồng hồ cao cấp – Đầu tư xứng đáng</h5>
        <p>Đồng hồ cao cấp không chỉ là một món đồ trang sức, mà còn là một sự đầu tư lâu dài. Với thiết kế bền vững, chất liệu cao cấp và bộ máy hoạt động ổn định, chiếc đồng hồ này sẽ luôn đồng hành cùng bạn trong suốt những năm tháng tới. Đặc biệt, nếu được bảo quản và bảo dưỡng đúng cách, đồng hồ có thể trở thành món đồ có giá trị gia tăng theo thời gian.</p>

        <h5 style="font-size: 18px; color: #b42020;">Bảo hành và dịch vụ khách hàng tận tâm</h5>
        <p>Đồng hồ cao cấp đi kèm với chính sách bảo hành lên đến <strong>5 năm</strong> cho bộ máy và <strong>1 năm</strong> cho dây đeo, kính. Ngoài ra, bạn còn nhận được sự hỗ trợ tận tình từ đội ngũ dịch vụ khách hàng của chúng tôi, đảm bảo chiếc đồng hồ luôn hoạt động trong tình trạng tốt nhất. Chúng tôi cũng cung cấp dịch vụ thay dây đồng hồ, sửa chữa và bảo dưỡng sản phẩm ngay tại cửa hàng.</p>

        <p style="font-weight: bold;">Với những ưu điểm vượt trội về chất lượng, tính năng và thiết kế, chiếc đồng hồ cao cấp là sự lựa chọn hoàn hảo dành cho những ai yêu thích sự tinh tế và đẳng cấp. Đừng để thời gian trôi qua mà không sở hữu một sản phẩm xứng tầm, giúp bạn ghi dấu ấn cá nhân trong mỗi khoảnh khắc.</p>
    </div>
';


        $products = [
            ['name' => 'Rolex Submariner', 'avatar' => 'products/product1.jpeg', 'brand' => 'Rolex', 'category' => 'Đồng hồ lặn', 'price' => 200000000],
            ['name' => 'Rolex Daytona', 'avatar' => 'products/product2.jpeg', 'brand' => 'Rolex', 'category' => 'Đồng hồ thể thao', 'price' => 350000000],
            ['name' => 'Omega Seamaster', 'avatar' => 'products/product3.jpeg', 'brand' => 'Omega', 'category' => 'Đồng hồ lặn', 'price' => 120000000],
            ['name' => 'Omega Speedmaster', 'avatar' => 'products/product4.jpeg', 'brand' => 'Omega', 'category' => 'Đồng hồ thể thao', 'price' => 150000000],
            ['name' => 'TAG Heuer Carrera', 'avatar' => 'products/product5.jpeg', 'brand' => 'TAG Heuer', 'category' => 'Đồng hồ thể thao', 'price' => 80000000],
            ['name' => 'TAG Heuer Monaco', 'avatar' => 'products/product6.jpeg', 'brand' => 'TAG Heuer', 'category' => 'Đồng hồ cao cấp', 'price' => 100000000],
            ['name' => 'Seiko Prospex', 'avatar' => 'products/product7.jpeg', 'brand' => 'Seiko', 'category' => 'Đồng hồ lặn', 'price' => 15000000],
            ['name' => 'Seiko Automatic', 'avatar' => 'products/product8.jpeg', 'brand' => 'Seiko', 'category' => 'Đồng hồ cơ', 'price' => 10000000],
            ['name' => 'Casio G-Shock', 'avatar' => 'products/product9.jpeg', 'brand' => 'Casio', 'category' => 'Đồng hồ thể thao', 'price' => 3000000],
            ['name' => 'Casio Edifice', 'avatar' => 'products/product10.jpeg', 'brand' => 'Casio', 'category' => 'Đồng hồ quartz', 'price' => 2500000],
            ['name' => 'Tissot Le Locle', 'avatar' => 'products/product11.jpeg', 'brand' => 'Tissot', 'category' => 'Đồng hồ cao cấp', 'price' => 15000000],
            ['name' => 'Tissot PRX', 'avatar' => 'products/product12.jpeg', 'brand' => 'Tissot', 'category' => 'Đồng hồ thời trang', 'price' => 12000000],
            ['name' => 'Citizen Eco-Drive', 'avatar' => 'products/product13.jpeg', 'brand' => 'Citizen', 'category' => 'Đồng hồ quartz', 'price' => 8000000],
            ['name' => 'Citizen Promaster', 'avatar' => 'products/product14.jpeg', 'brand' => 'Citizen', 'category' => 'Đồng hồ lặn', 'price' => 10000000],
            ['name' => 'Fossil Townsman', 'avatar' => 'products/product15.jpeg', 'brand' => 'Fossil', 'category' => 'Đồng hồ thời trang', 'price' => 5000000],
            ['name' => 'Fossil Neutra', 'avatar' => 'products/product16.jpeg', 'brand' => 'Fossil', 'category' => 'Đồng hồ dây da', 'price' => 4500000],
            ['name' => 'Garmin Instinct', 'avatar' => 'products/product17.jpeg', 'brand' => 'Garmin', 'category' => 'Đồng hồ thông minh', 'price' => 7000000],
            ['name' => 'Garmin Venu', 'avatar' => 'products/product18.jpeg', 'brand' => 'Garmin', 'category' => 'Đồng hồ thông minh', 'price' => 9000000],
            ['name' => 'Apple Watch Series 9', 'avatar' => 'products/product19.jpeg', 'brand' => 'Apple', 'category' => 'Apple Watch', 'price' => 12000000],
            ['name' => 'Apple Watch Ultra', 'avatar' => 'products/product20.jpeg', 'brand' => 'Apple', 'category' => 'Apple Watch', 'price' => 20000000],
            ['name' => 'Rolex Datejust Pair', 'avatar' => 'products/product21.jpeg', 'brand' => 'Rolex', 'category' => 'Đồng hồ cặp tình nhân', 'price' => 400000000],
            ['name' => 'Tissot Couple', 'avatar' => 'products/product22.jpeg', 'brand' => 'Tissot', 'category' => 'Đồng hồ cặp tình nhân', 'price' => 25000000],
            ['name' => 'Fossil Anniversary Set', 'avatar' => 'products/product23.jpeg', 'brand' => 'Fossil', 'category' => 'Đồng hồ anniversary', 'price' => 8000000],
            ['name' => 'Omega Constellation', 'avatar' => 'products/product24.jpeg', 'brand' => 'Omega', 'category' => 'Đồng hồ đính đá', 'price' => 180000000],
            ['name' => 'Seiko Presage', 'avatar' => 'products/product25.jpeg', 'brand' => 'Seiko', 'category' => 'Đồng hồ dây da', 'price' => 12000000],
            ['name' => 'Casio Sheen', 'avatar' => 'products/product26.jpeg', 'brand' => 'Casio', 'category' => 'Đồng hồ dây kim loại', 'price' => 3500000],
            ['name' => 'Citizen Diamond', 'avatar' => 'products/product27.jpeg', 'brand' => 'Citizen', 'category' => 'Đồng hồ đính đá', 'price' => 9000000],
            ['name' => 'Fossil Carlie', 'avatar' => 'products/product28.jpeg', 'brand' => 'Fossil', 'category' => 'Đồng hồ thời trang', 'price' => 4000000],
            ['name' => 'Leather Strap', 'avatar' => 'products/product29.jpeg', 'brand' => 'Tissot', 'category' => 'Dây đồng hồ', 'price' => 1000000],
            ['name' => 'Watch Box', 'avatar' => 'products/product30.jpeg', 'brand' => 'Fossil', 'category' => 'Hộp đựng đồng hồ', 'price' => 1500000],
            ['name' => 'Watch Battery', 'avatar' => 'products/product31.jpeg', 'brand' => 'Casio', 'category' => 'Pin đồng hồ', 'price' => 200000],
            ['name' => 'Sapphire Glass', 'avatar' => 'products/product32.jpeg', 'brand' => 'Seiko', 'category' => 'Kính đồng hồ', 'price' => 500000],
            ['name' => 'Maintenance Service', 'avatar' => 'products/product33.jpeg', 'brand' => 'Omega', 'category' => 'Hộp đựng đồng hồ', 'price' => 2000000],
            ['name' => 'Rolex Oyster Perpetual', 'avatar' => 'products/product34.jpeg', 'brand' => 'Rolex', 'category' => 'Đồng hồ cao cấp', 'price' => 150000000],
            ['name' => 'Apple Watch SE', 'avatar' => 'products/product35.jpeg', 'brand' => 'Apple', 'category' => 'Apple Watch', 'price' => 8000000],
            ['name' => 'Tissot Wedding Set', 'avatar' => 'products/product36.jpeg', 'brand' => 'Tissot', 'category' => 'Đồng hồ cưới', 'price' => 30000000],

            ['name' => 'Seiko Presage Cocktail Time', 'stock' => 100, 'avatar' => 'products/product37.jpeg', 'brand' => 'Seiko', 'category' => 'Đồng hồ cơ', 'price' => 12500000],
            ['name' => 'Casio G-Shock GA-2100', 'stock' => 100, 'avatar' => 'products/product38.jpeg', 'brand' => 'Casio', 'category' => 'Đồng hồ thể thao', 'price' => 3600000],
            ['name' => 'Tissot Eco-Drive Chandler', 'stock' => 100, 'avatar' => 'products/product39.jpeg', 'brand' => 'Tissot', 'category' => 'Đồng hồ quartz', 'price' => 6200000],
            ['name' => 'Seiko Bambino Open Heart', 'stock' => 100, 'avatar' => 'products/product40.jpeg', 'brand' => 'Seiko', 'category' => 'Đồng hồ cơ', 'price' => 7800000],
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
                    'stock' => $p['stock'] ?? null,
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
