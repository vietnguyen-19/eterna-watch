<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'Nguyễn Văn An',
                'email' => 'vanan@example.com',
                'message' => 'Tôi muốn hỏi về bảo hành của mẫu đồng hồ mã DW001.',
                'status' => 'new',
                'sent_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Trần Thị Bình',
                'email' => 'thibinh@example.com',
                'message' => 'Đồng hồ nữ mã SW003 còn hàng không ạ?',
                'status' => 'read',
                'sent_at' => now()->subHours(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lê Văn Cường',
                'email' => 'cuongle@example.com',
                'message' => 'Tôi đặt nhầm mẫu, có thể đổi đơn hàng được không?',
                'status' => 'done',
                'sent_at' => now()->subDay(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phạm Minh Duy',
                'email' => 'duypm@example.com',
                'message' => 'Cửa hàng có hỗ trợ gói quà tặng không?',
                'status' => 'new',
                'sent_at' => now()->subMinutes(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đỗ Thị Hạnh',
                'email' => 'hanhdt@example.com',
                'message' => 'Tôi cần xuất hóa đơn công ty cho đơn hàng vừa mua.',
                'status' => 'read',
                'sent_at' => now()->subHours(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vũ Mạnh Hùng',
                'email' => 'hungvm@example.com',
                'message' => 'Tôi muốn mua sỉ đồng hồ, vui lòng liên hệ lại.',
                'status' => 'new',
                'sent_at' => now()->subMinutes(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lý Thị Kim',
                'email' => 'kimly@example.com',
                'message' => 'Cho tôi xin kích thước mặt đồng hồ mẫu GU1002.',
                'status' => 'done',
                'sent_at' => now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ngô Quang Khải',
                'email' => 'khaingo@example.com',
                'message' => 'Mẫu đồng hồ Rolex có phải chính hãng không?',
                'status' => 'read',
                'sent_at' => now()->subDay(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Trịnh Mỹ Linh',
                'email' => 'linhtm@example.com',
                'message' => 'Làm sao để biết cổ tay mình vừa size nào?',
                'status' => 'new',
                'sent_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đinh Văn Tùng',
                'email' => 'tungdv@example.com',
                'message' => 'Tôi chưa nhận được đơn hàng đã đặt hôm qua.',
                'status' => 'read',
                'sent_at' => now()->subHours(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('contacts')->insert($contacts);
    }
    
}
