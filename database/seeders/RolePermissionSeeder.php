<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo quyền
        $permissions = ['create post', 'edit post', 'delete post', 'publish post'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Tạo vai trò
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Gán quyền cho vai trò
        $adminRole->givePermissionTo(Permission::all());  // Admin có tất cả quyền
        $staffRole->givePermissionTo(['create post', 'edit post']); // Nhân viên có quyền giới hạn
        $customerRole->givePermissionTo([]); // Khách hàng không có quyền đặc biệt


        // Gán vai trò cho user có ID = 1 (chỉnh lại ID nếu cần)
        $user = User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
