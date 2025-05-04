<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::pluck('id')->toArray();
        $products = Product::pluck('id')->toArray();
        $posts = Post::pluck('id')->toArray();
        $orders = Order::where('status', 'completed')->pluck('id')->toArray();

        $productComments = [
            ['content' => 'Sản phẩm rất đẹp, dây đeo chắc chắn. Giao hàng nhanh!', 'rating' => 5],
            ['content' => 'Đồng hồ chính hãng, thiết kế tinh xảo. Rất đáng tiền.', 'rating' => 5],
            ['content' => 'Mặt kính hơi dễ trầy, nhưng nhìn chung ổn.', 'rating' => 3],
            ['content' => 'Hàng về đúng mô tả, đóng gói kỹ. Sẽ ủng hộ lần sau.', 'rating' => 4],
            ['content' => 'Pin dùng khá lâu, rất hài lòng.', 'rating' => 5],
            ['content' => 'Dịch vụ chăm sóc khách hàng rất tốt.', 'rating' => 4],
            ['content' => 'Đồng hồ đẹp nhưng giao chậm hơn dự kiến.', 'rating' => 3],
            ['content' => 'Giao hàng nhanh, chất lượng tốt, đáng tiền.', 'rating' => 5],
            ['content' => 'Không vừa tay, phải mang đi chỉnh lại.', 'rating' => 2],
            ['content' => 'Màu sắc tinh tế, phù hợp đi làm và đi chơi.', 'rating' => 5],
        ];

        $postComments = [
            'Bài viết rất hữu ích, giúp tôi hiểu thêm cách chọn đồng hồ.',
            'Rất thích các bài chia sẻ phong cách phối đồ với đồng hồ.',
            'Nội dung chất lượng, mong shop ra nhiều bài hơn.',
            'Bài viết khá hay nhưng cần thêm hình ảnh minh họa.',
            'Tôi đã áp dụng các mẹo từ bài viết và thấy hiệu quả rõ rệt.',
            'Rất chi tiết và dễ hiểu, cảm ơn shop.',
            'Thông tin hữu ích cho người mới bắt đầu chơi đồng hồ.',
            'Bài chia sẻ rất thực tế và thiết thực.',
            'Tôi mới mua một mẫu tương tự, cảm ơn bài viết đã gợi ý.',
            'Bài viết dài nhưng đáng đọc, nhiều thông tin hay.',
        ];

        // Mảng để lưu bình luận sẽ được insert vào DB
        $comments_to_insert = [];

        // Tạo bình luận sản phẩm
        foreach ($orders as $order_id) {
            // Lấy tất cả sản phẩm trong đơn hàng
            $order_items = OrderItem::with('productVariant.product')->where('order_id', $order_id)->get();

            // Nếu không có sản phẩm trong đơn hàng thì bỏ qua
            if ($order_items->isEmpty()) {
                continue;
            }

            // Lấy user đã tạo đơn hàng
            foreach ($order_items as $item) {
                $product_id = $item->productVariant->product->id;

                // Chọn ngẫu nhiên một bình luận mẫu
                $comment_data = $productComments[array_rand($productComments)];

                $comments_to_insert[] = [
                    'user_id'     => $users[array_rand($users)], // Random user
                    'entity_type' => 'product',
                    'entity_id'   => $product_id,
                    'order_id'    => $order_id,
                    'content'     => $comment_data['content'],
                    'rating'      => $comment_data['rating'],
                    'parent_id'   => null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }

        // Chỉ insert nếu có bình luận
        if (!empty($comments_to_insert)) {
            Comment::insert($comments_to_insert);
        }

        // Tạo bình luận bài viết
        foreach ($postComments as $content) {
            Comment::create([
                'user_id'     => $users[array_rand($users)], // Random user
                'entity_type' => 'post',
                'entity_id'   => $posts[array_rand($posts)], // Random post
                'content'     => $content,
                'rating'      => null,
                'order_id'    => null,
                'parent_id'   => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
