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
        $faker = Faker::create('vi_VN'); // Dùng tiếng Việt

        // Lấy tất cả người dùng hiện có
        $users = User::all();

        foreach ($users as $user) {
            // Tạo địa chỉ mặc định
            UserAddress::create([
                'user_id'        => $user->id,
                'full_name'      => $user->name,
                'phone_number'   => $faker->numerify('09########'), // Số điện thoại VN
                'email'          => $user->email,
                'street_address' => $faker->streetAddress,
                'ward'           => "Phường " . rand(1, 20),
                'district'       => "Quận " . rand(1, 12),
                'city'           => $faker->randomElement(['Hồ Chí Minh', 'Hà Nội', 'Đà Nẵng', 'Cần Thơ']),
                'country'        => 'Vietnam',
                'is_default'     => true,
                'note'           => 'Địa chỉ mặc định'
            ]);

            // Tạo địa chỉ phụ (không mặc định)
            UserAddress::create([
                'user_id'        => $user->id,
                'full_name'      => $user->name,
                'phone_number'   => $faker->numerify('09########'),
                'email'          => $user->email,
                'street_address' => $faker->streetAddress,
                'ward'           => "Phường " . rand(1, 20),
                'district'       => "Quận " . rand(1, 12),
                'city'           => $faker->randomElement(['Hồ Chí Minh', 'Hà Nội', 'Đà Nẵng', 'Cần Thơ']),
                'country'        => 'Vietnam',
                'is_default'     => false,
                'note'           => 'Địa chỉ dự phòng'
            ]);
        }
    }
}
