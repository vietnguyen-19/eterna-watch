<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role_id', 2)->get();

        if ($users->isEmpty()) {
            $users = User::factory(3)->create([
                'role_id' => 2
            ]);
        }


        $tags = Tag::all();
        if ($tags->isEmpty()) {
            $tags = Tag::factory(10)->create();
        }

        $categories = Category::where('parent_id', null)->get();
        if ($categories->isEmpty()) {
            $categories = Category::factory(5)->create();
        }

        $titles = [
            'Khám Phá Thế Giới Đồng Hồ Cơ: Đỉnh Cao Của Nghệ Thuật Cơ Khí',
            'Tại Sao Đồng Hồ Thụy Sĩ Luôn Được Ưa Chuộng Trên Toàn Thế Giới?',
            'Đồng Hồ Thông Minh Có Thể Thay Thế Đồng Hồ Truyền Thống Không?',
            'Top 5 Thương Hiệu Đồng Hồ Cao Cấp Đáng Đầu Tư Năm Nay',
            'Cách Chọn Đồng Hồ Phù Hợp Với Phong Cách Cá Nhân',
            'Bí Quyết Bảo Quản Đồng Hồ Cơ Luôn Bền Và Chính Xác',
            'Lịch Sử Phát Triển Của Đồng Hồ Qua Các Thời Kỳ',
            'Đồng Hồ Và Đẳng Cấp: Khi Thời Gian Gắn Liền Với Phong Cách',
            'So Sánh Đồng Hồ Cơ, Quartz Và Smartwatch: Loại Nào Phù Hợp Với Bạn?',
            'Những Mẫu Đồng Hồ Nam Được Yêu Thích Nhất Hiện Nay',
            'Đồng Hồ Nữ – Phụ Kiện Thời Trang Không Thể Thiếu',
            'Khám Phá Những Bộ Máy Đồng Hồ Độc Đáo Nhất Thế Giới'
        ];
        $excerpts = [
            'Khám phá thế giới đồng hồ cơ: Đỉnh cao của nghệ thuật cơ khí và tinh tế.',
            'Tại sao đồng hồ Thụy Sĩ luôn được ưa chuộng và là biểu tượng của sự sang trọng.',
            'Đồng hồ thông minh có thể thay thế đồng hồ truyền thống trong cuộc sống hiện đại.',
            'Top 5 thương hiệu đồng hồ cao cấp đáng đầu tư trong năm nay.',
            'Cách chọn đồng hồ phù hợp với phong cách cá nhân và sự kiện.',
            'Bí quyết bảo quản đồng hồ cơ để duy trì độ bền và chính xác theo thời gian.',
            'Lịch sử phát triển của đồng hồ qua các thời kỳ và sự đổi mới không ngừng.',
            'Đồng hồ không chỉ là công cụ đo thời gian, mà là phần không thể thiếu trong phong cách sống.',
            'So sánh đồng hồ cơ, quartz và smartwatch: Loại nào phù hợp với bạn?',
            'Những mẫu đồng hồ nam được yêu thích nhất hiện nay và những xu hướng mới.',
            'Đồng hồ nữ – Phụ kiện thời trang không thể thiếu cho các cô gái hiện đại.',
            'Khám phá những bộ máy đồng hồ độc đáo nhất thế giới và câu chuyện đằng sau chúng.'
        ];

        $content = <<<TEXT
        Khám Phá Thế Giới Đồng Hồ: Định Nghĩa Thời Gian và Phong Cách Sống
        Trong thế giới hiện đại ngày nay, đồng hồ không chỉ là công cụ đo lường thời gian mà còn là một phần không thể thiếu trong phong cách sống và là biểu tượng của sự tinh tế và đẳng cấp cá nhân. Dù là một chiếc đồng hồ cơ học cổ điển, đồng hồ thụy sĩ đẳng cấp hay những mẫu đồng hồ thông minh hiện đại, mỗi chiếc đồng hồ đều có câu chuyện riêng và mang đến cho chủ nhân của nó một trải nghiệm đặc biệt.

        1. Các Loại Đồng Hồ Phổ Biến
        Đồng Hồ Cơ (Automatic Watches): Đồng hồ cơ học là loại đồng hồ sử dụng cơ chế tự động để lên dây cót nhờ chuyển động của cổ tay người đeo. Đây là loại đồng hồ được đánh giá cao nhờ sự tinh xảo trong chế tác và khả năng hoạt động không cần pin. Những chiếc đồng hồ này thường có thiết kế đẹp mắt, với các chi tiết nhỏ được chế tác một cách tỉ mỉ, là sự kết hợp giữa nghệ thuật và kỹ thuật. Đồng hồ cơ là lựa chọn lý tưởng cho những ai yêu thích sự cổ điển và muốn sở hữu một sản phẩm mang tính chất sưu tầm.

        Đồng Hồ Quartz (Battery-Powered Watches): Đồng hồ quartz là một trong những loại đồng hồ phổ biến nhất hiện nay. Với việc sử dụng pin để duy trì hoạt động, đồng hồ quartz nổi bật với độ chính xác cao và giá thành phải chăng. Chúng có thể có thiết kế đơn giản hoặc phức tạp, phù hợp với nhiều phong cách khác nhau. Đồng hồ quartz không yêu cầu lên dây cót như đồng hồ cơ, giúp người dùng tiết kiệm thời gian và công sức.

        Đồng Hồ Thông Minh (Smartwatches): Trong thời đại công nghệ số, đồng hồ thông minh đã trở thành một phần không thể thiếu trong cuộc sống của nhiều người. Đồng hồ thông minh không chỉ giúp bạn xem giờ mà còn tích hợp nhiều tính năng hiện đại như theo dõi sức khỏe (nhịp tim, giấc ngủ, bước đi), kết nối với điện thoại thông minh để nhận thông báo, và thậm chí có thể giúp bạn thanh toán qua NFC. Mặc dù không có vẻ đẹp cổ điển như đồng hồ cơ, nhưng đồng hồ thông minh lại mang đến sự tiện dụng và đổi mới cho người dùng.

        2. Những Thương Hiệu Đồng Hồ Nổi Tiếng
        Rolex: Rolex là cái tên không thể không nhắc đến khi nói về đồng hồ cao cấp. Đây là thương hiệu đồng hồ nổi tiếng toàn cầu, được biết đến với sự chính xác tuyệt đối và chất lượng vượt trội. Rolex không chỉ là một chiếc đồng hồ, mà là biểu tượng của sự thành công, địa vị và phong cách sống thượng lưu.

        Omega: Omega là thương hiệu đồng hồ Thụy Sĩ được biết đến rộng rãi với các dòng sản phẩm đẳng cấp. Các mẫu đồng hồ Omega luôn nổi bật với sự chính xác và thiết kế tinh tế, đặc biệt là dòng Speedmaster nổi tiếng, đã đồng hành cùng NASA trong chuyến bay lên mặt trăng.

        Patek Philippe: Patek Philippe là thương hiệu đồng hồ siêu cao cấp, được đánh giá là một trong những nhà sản xuất đồng hồ tốt nhất thế giới. Với những mẫu đồng hồ phức tạp và thiết kế vượt thời gian, Patek Philippe là biểu tượng của sự sang trọng và tinh tế.

        Tag Heuer: Tag Heuer nổi bật với các mẫu đồng hồ thể thao và đồng hồ đua xe, luôn được các vận động viên và người yêu thể thao ưa chuộng. Sự kết hợp giữa công nghệ tiên tiến và thiết kế thể thao mạnh mẽ khiến Tag Heuer trở thành sự lựa chọn yêu thích của nhiều người.

        3. Cách Chọn Đồng Hồ Phù Hợp
        Chọn đồng hồ không chỉ là việc tìm kiếm một chiếc đồng hồ đẹp, mà còn là việc chọn một chiếc đồng hồ phù hợp với phong cách và nhu cầu sử dụng của bản thân. Dưới đây là một số lưu ý giúp bạn chọn được chiếc đồng hồ lý tưởng:

        Phong Cách Cá Nhân: Tùy thuộc vào sở thích và phong cách cá nhân, bạn có thể chọn một chiếc đồng hồ cổ điển, hiện đại hay thể thao. Đồng hồ cơ là lựa chọn lý tưởng cho những ai yêu thích sự truyền thống, trong khi đồng hồ thông minh lại phù hợp với những người yêu thích công nghệ.

        Mục Đích Sử Dụng: Nếu bạn là người yêu thích thể thao, một chiếc đồng hồ thể thao với tính năng chống nước và thiết kế chắc chắn là lựa chọn phù hợp. Nếu bạn tìm kiếm một món đồ trang sức, đồng hồ đeo tay cao cấp với thiết kế sang trọng sẽ là sự lựa chọn hoàn hảo.

        Chất Liệu và Độ Bền: Chất liệu của đồng hồ rất quan trọng, ảnh hưởng đến độ bền và vẻ ngoài của sản phẩm. Đồng hồ thép không gỉ, titanium hoặc vàng thường có độ bền cao và dễ dàng bảo dưỡng. Đồng hồ da mang đến vẻ thanh lịch nhưng cần chăm sóc kỹ hơn.

        4. Bảo Quản Đồng Hồ
        Bảo quản đồng hồ đúng cách sẽ giúp tăng tuổi thọ và giữ được vẻ đẹp của nó theo thời gian. Dưới đây là một số lưu ý bảo quản đồng hồ:

        Tránh Nhiệt Độ Cao và Ánh Nắng Mặt Trời: Ánh sáng mặt trời và nhiệt độ cao có thể làm hỏng các bộ phận bên trong đồng hồ, đặc biệt là đồng hồ có pin. Đảm bảo không để đồng hồ tiếp xúc trực tiếp với ánh nắng mặt trời trong thời gian dài.

        Vệ Sinh Định Kỳ: Để đồng hồ luôn giữ được độ sáng bóng, bạn cần vệ sinh chúng thường xuyên bằng khăn mềm. Đối với đồng hồ dây da, hãy dùng một miếng vải ẩm để lau sạch, tránh để da bị khô và nứt.

        Tránh Tiếp Xúc Với Nước (Ngoại Trừ Đồng Hồ Chống Nước): Dù một số đồng hồ có khả năng chống nước, nhưng vẫn nên tránh để chúng tiếp xúc lâu với nước để tránh làm hỏng cơ chế hoạt động.

        5. Kết Luận
        Đồng hồ không chỉ là công cụ đo thời gian mà còn là một phần trong cuộc sống, giúp thể hiện phong cách và cá tính của người sử dụng. Dù là một chiếc đồng hồ cơ với sự tinh xảo trong thiết kế, hay một chiếc đồng hồ thông minh với tính năng hiện đại, mỗi chiếc đồng hồ đều mang đến giá trị riêng và trở thành người bạn đồng hành đáng tin cậy trong suốt hành trình thời gian của mỗi người.
        TEXT;


        for ($i = 0; $i < 12; $i++) {
            $post = Post::create([
                'user_id' => $users->random()->id,
                'title' => $titles[$i],
                'content' => nl2br($content), // Thêm nl2br để xuống dòng đúng cách
                'excerpt' => $excerpts[$i],
                'status' => 'published',
                'image' => 'blogs/blog-' . ($i + 1) . '.jpeg',
                'view_count' => rand(100, 1000),
                'published_at' => now(),
            ]);

            // Gán tags và categories ngẫu nhiên
            $post->tags()->attach($tags->random(rand(2, 4))->pluck('id')->toArray());
            $post->categories()->attach($categories->random(rand(1, 2))->pluck('id')->toArray());
        }
    }
}
