<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addresses = [
            [
                'city' => 'Hồ Chí Minh',
                'district' => 'Quận 1',
                'ward' => 'Phường Bến Nghé',
                'street' => '45 Nguyễn Huệ'
            ],
            [
                'city' => 'Hà Nội',
                'district' => 'Quận Hoàn Kiếm',
                'ward' => 'Phường Hàng Trống',
                'street' => '12 Lý Thường Kiệt'
            ],
            [
                'city' => 'Đà Nẵng',
                'district' => 'Quận Hải Châu',
                'ward' => 'Phường Hòa Cường Bắc',
                'street' => '76 Nguyễn Văn Linh'
            ],
            [
                'city' => 'Cần Thơ',
                'district' => 'Quận Ninh Kiều',
                'ward' => 'Phường An Phú',
                'street' => '01 Trần Hưng Đạo'
            ],
            [
                'city' => 'Hồ Chí Minh',
                'district' => 'Quận 3',
                'ward' => 'Phường 6',
                'street' => '159 Pasteur'
            ],
            [
                'city' => 'Hà Nội',
                'district' => 'Quận Đống Đa',
                'ward' => 'Phường Láng Hạ',
                'street' => '23 Chùa Bộc'
            ],
            [
                'city' => 'Đà Nẵng',
                'district' => 'Quận Thanh Khê',
                'ward' => 'Phường Vĩnh Trung',
                'street' => '80 Lê Duẩn'
            ],
            [
                'city' => 'Hồ Chí Minh',
                'district' => 'Quận 10',
                'ward' => 'Phường 12',
                'street' => '22 Lý Thái Tổ'
            ],
            [
                'city' => 'Hà Nội',
                'district' => 'Quận Ba Đình',
                'ward' => 'Phường Điện Biên',
                'street' => '89 Hoàng Diệu'
            ],
            [
                'city' => 'Cần Thơ',
                'district' => 'Quận Bình Thủy',
                'ward' => 'Phường Bình Thủy',
                'street' => '66 Nguyễn Trãi'
            ],
            [
                'city' => 'Cần Thơ',
                'district' => 'Quận Bình Thủy',
                'ward' => 'Phường Bình Thủy',
                'street' => '66 Nguyễn Trãi'
            ],
            [
                'city' => 'Hồ Chí Minh',
                'district' => 'Quận 1',
                'ward' => 'Phường Bến Nghé',
                'street' => '12 Lý Tự Trọng'
            ],
            [
                'city' => 'Hà Nội',
                'district' => 'Quận Cầu Giấy',
                'ward' => 'Phường Dịch Vọng',
                'street' => '18 Trần Thái Tông'
            ],
            [
                'city' => 'Đà Nẵng',
                'district' => 'Quận Hải Châu',
                'ward' => 'Phường Hải Châu 1',
                'street' => '45 Bạch Đằng'
            ],
            [
                'city' => 'Huế',
                'district' => 'Thành phố Huế',
                'ward' => 'Phường Vĩnh Ninh',
                'street' => '97 Hùng Vương'
            ],
            [
                'city' => 'Hải Phòng',
                'district' => 'Quận Lê Chân',
                'ward' => 'Phường An Biên',
                'street' => '200 Trần Nguyên Hãn'
            ],
            [
                'city' => 'Cần Thơ',
                'district' => 'Quận Ninh Kiều',
                'ward' => 'Phường An Khánh',
                'street' => '82 Mậu Thân'
            ],
            [
                'city' => 'Bình Dương',
                'district' => 'Thành phố Thủ Dầu Một',
                'ward' => 'Phường Phú Hòa',
                'street' => '35 Lê Hồng Phong'
            ],
            [
                'city' => 'Biên Hòa',
                'district' => 'Thành phố Biên Hòa',
                'ward' => 'Phường Tân Hiệp',
                'street' => '105 Đồng Khởi'
            ],
            [
                'city' => 'Vũng Tàu',
                'district' => 'Thành phố Vũng Tàu',
                'ward' => 'Phường Thắng Tam',
                'street' => '60 Hoàng Hoa Thám'
            ],
            [
                'city' => 'Nha Trang',
                'district' => 'Thành phố Nha Trang',
                'ward' => 'Phường Phước Hòa',
                'street' => '11 Nguyễn Thị Minh Khai'
            ],
            [
                'city' => 'Đà Lạt',
                'district' => 'Thành phố Đà Lạt',
                'ward' => 'Phường 1',
                'street' => '29 Trần Phú'
            ],
            [
                'city' => 'Long Xuyên',
                'district' => 'Thành phố Long Xuyên',
                'ward' => 'Phường Mỹ Long',
                'street' => '48 Nguyễn Trường Tộ'
            ],
            [
                'city' => 'Quảng Ngãi',
                'district' => 'Thành phố Quảng Ngãi',
                'ward' => 'Phường Trần Phú',
                'street' => '88 Hùng Vương'
            ],
            [
                'city' => 'Hồ Chí Minh',
                'district' => 'Quận 1',
                'ward' => 'Phường Bến Nghé',
                'street' => '45 Nguyễn Huệ'
            ],
            [
                'city' => 'Hà Nội',
                'district' => 'Quận Hoàn Kiếm',
                'ward' => 'Phường Hàng Trống',
                'street' => '12 Lý Thường Kiệt'
            ],
            [
                'city' => 'Đà Nẵng',
                'district' => 'Quận Hải Châu',
                'ward' => 'Phường Hòa Cường Bắc',
                'street' => '76 Nguyễn Văn Linh'
            ],
            [
                'city' => 'Cần Thơ',
                'district' => 'Quận Ninh Kiều',
                'ward' => 'Phường An Phú',
                'street' => '01 Trần Hưng Đạo'
            ],
            [
                'city' => 'Hồ Chí Minh',
                'district' => 'Quận 3',
                'ward' => 'Phường 6',
                'street' => '159 Pasteur'
            ],
            [
                'city' => 'Hà Nội',
                'district' => 'Quận Đống Đa',
                'ward' => 'Phường Láng Hạ',
                'street' => '23 Chùa Bộc'
            ],
            [
                'city' => 'Đà Nẵng',
                'district' => 'Quận Thanh Khê',
                'ward' => 'Phường Vĩnh Trung',
                'street' => '80 Lê Duẩn'
            ],
            [
                'city' => 'Hồ Chí Minh',
                'district' => 'Quận 10',
                'ward' => 'Phường 12',
                'street' => '22 Lý Thái Tổ'
            ],
            [
                'city' => 'Hà Nội',
                'district' => 'Quận Ba Đình',
                'ward' => 'Phường Điện Biên',
                'street' => '89 Hoàng Diệu'
            ],
            [
                'city' => 'Cần Thơ',
                'district' => 'Quận Bình Thủy',
                'ward' => 'Phường Bình Thủy',
                'street' => '66 Nguyễn Trãi'
            ],
            [
                'city' => 'Cần Thơ',
                'district' => 'Quận Bình Thủy',
                'ward' => 'Phường Bình Thủy',
                'street' => '66 Nguyễn Trãi'
            ],
            [
                'city' => 'Hồ Chí Minh',
                'district' => 'Quận 1',
                'ward' => 'Phường Bến Nghé',
                'street' => '12 Lý Tự Trọng'
            ],
            [
                'city' => 'Hà Nội',
                'district' => 'Quận Cầu Giấy',
                'ward' => 'Phường Dịch Vọng',
                'street' => '18 Trần Thái Tông'
            ],
            [
                'city' => 'Đà Nẵng',
                'district' => 'Quận Hải Châu',
                'ward' => 'Phường Hải Châu 1',
                'street' => '45 Bạch Đằng'
            ],
            [
                'city' => 'Huế',
                'district' => 'Thành phố Huế',
                'ward' => 'Phường Vĩnh Ninh',
                'street' => '97 Hùng Vương'
            ],
            [
                'city' => 'Hải Phòng',
                'district' => 'Quận Lê Chân',
                'ward' => 'Phường An Biên',
                'street' => '200 Trần Nguyên Hãn'
            ],
            [
                'city' => 'Cần Thơ',
                'district' => 'Quận Ninh Kiều',
                'ward' => 'Phường An Khánh',
                'street' => '82 Mậu Thân'
            ],
            [
                'city' => 'Bình Dương',
                'district' => 'Thành phố Thủ Dầu Một',
                'ward' => 'Phường Phú Hòa',
                'street' => '35 Lê Hồng Phong'
            ],
            [
                'city' => 'Biên Hòa',
                'district' => 'Thành phố Biên Hòa',
                'ward' => 'Phường Tân Hiệp',
                'street' => '105 Đồng Khởi'
            ],
            [
                'city' => 'Vũng Tàu',
                'district' => 'Thành phố Vũng Tàu',
                'ward' => 'Phường Thắng Tam',
                'street' => '60 Hoàng Hoa Thám'
            ],
            [
                'city' => 'Nha Trang',
                'district' => 'Thành phố Nha Trang',
                'ward' => 'Phường Phước Hòa',
                'street' => '11 Nguyễn Thị Minh Khai'
            ],
            [
                'city' => 'Đà Lạt',
                'district' => 'Thành phố Đà Lạt',
                'ward' => 'Phường 1',
                'street' => '29 Trần Phú'
            ],
            [
                'city' => 'Long Xuyên',
                'district' => 'Thành phố Long Xuyên',
                'ward' => 'Phường Mỹ Long',
                'street' => '48 Nguyễn Trường Tộ'
            ],
            [
                'city' => 'Quảng Ngãi',
                'district' => 'Thành phố Quảng Ngãi',
                'ward' => 'Phường Trần Phú',
                'street' => '88 Hùng Vương'
            ], [
                'city' => 'Bình Dương',
                'district' => 'Thành phố Thủ Dầu Một',
                'ward' => 'Phường Phú Hòa',
                'street' => '35 Lê Hồng Phong'
            ],
            [
                'city' => 'Biên Hòa',
                'district' => 'Thành phố Biên Hòa',
                'ward' => 'Phường Tân Hiệp',
                'street' => '105 Đồng Khởi'
            ],
            [
                'city' => 'Vũng Tàu',
                'district' => 'Thành phố Vũng Tàu',
                'ward' => 'Phường Thắng Tam',
                'street' => '60 Hoàng Hoa Thám'
            ],
            [
                'city' => 'Nha Trang',
                'district' => 'Thành phố Nha Trang',
                'ward' => 'Phường Phước Hòa',
                'street' => '11 Nguyễn Thị Minh Khai'
            ],
            [
                'city' => 'Đà Lạt',
                'district' => 'Thành phố Đà Lạt',
                'ward' => 'Phường 1',
                'street' => '29 Trần Phú'
            ],
            [
                'city' => 'Long Xuyên',
                'district' => 'Thành phố Long Xuyên',
                'ward' => 'Phường Mỹ Long',
                'street' => '48 Nguyễn Trường Tộ'
            ],
            [
                'city' => 'Quảng Ngãi',
                'district' => 'Thành phố Quảng Ngãi',
                'ward' => 'Phường Trần Phú',
                'street' => '88 Hùng Vương'
            ]
        ];

        $users = User::orderBy('id')->get();

        foreach ($users as $index => $user) {
            $addr = $addresses[$index];

            // Địa chỉ mặc định
            UserAddress::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'phone_number' => $user->phone ?? '09' . rand(10000000, 99999999),
                'email' => $user->email,
                'street_address' => $addr['street'],
                'ward' => $addr['ward'],
                'district' => $addr['district'],
                'city' => $addr['city'],
                'country' => 'Vietnam',
                'is_default' => true,
                'note' => 'Địa chỉ mặc định của người dùng.'
            ]);

            // Địa chỉ phụ
            UserAddress::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'phone_number' => $user->phone ?? '09' . rand(10000000, 99999999),
                'email' => $user->email,
                'street_address' => $addr['street'] . ' (Chi nhánh)',
                'ward' => 'Phường ' . rand(1, 20),
                'district' => $addr['district'],
                'city' => $addr['city'],
                'country' => 'Vietnam',
                'is_default' => false,
                'note' => 'Địa chỉ phụ của người dùng.'
            ]);
        }
    }
}
