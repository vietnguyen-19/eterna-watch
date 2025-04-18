<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $permissionNames = [

            // ===== Dashboard =====
            'view_dashboard',

            // ===== Categories =====
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',

            // ===== Banners =====
            'view_banners',
            'restore_banners',
            'delete_banners',

            // ===== Vouchers =====
            'view_vouchers',
            'create_vouchers',
            'edit_vouchers',
            'restore_vouchers',
            'delete_vouchers',
            

            // ===== Users =====
            'view_users',

            // ===== Attributes =====
            'view_attributes',
            'create_attributes',
            'edit_attributes',
            'delete_attributes',

            // ===== Products =====
            'view_products',
            'create_products',
            'edit_products',
            'delete_products',

            // ===== Orders =====
            'view_orders',
            'create_orders',
            'edit_orders',
            'delete_orders',
            'restore_orders',

            // ===== Brands (Thương hiệu) =====
            'view_brands',
            'create_brands',
            'edit_brands',
            'delete_brands',

            // ===== Permissions & Roles (Phân quyền) =====
            'manage_permissions',
            'manage_roles',

            // ===== Comments (Bình luận) =====
            'view_comments',
            'edit_comments',

            // ===== Posts (Bài viết) =====
            'view_posts',
            'create_posts',
            'edit_posts',
            'delete_posts',

            // ===== Images (Hình ảnh sản phẩm) =====
            'edit_product_images',

            // ===== Settings (Cài đặt) =====
            'manage_settings',
        ];

        // Tạo từng permission nếu chưa có
        foreach ($permissionNames as $name) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web'
            ]);
        }

        // Tạo các vai trò
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Gán toàn bộ quyền cho admin
        $adminRole->syncPermissions(Permission::all());

        // Gán quyền giới hạn cho nhân viên
        $staffPermissions = [
            'view_dashboard',

            'view_categories',

            'view_products',
            'create_products',
            'edit_products',

            'view_orders',
            'edit_orders',

            'view_vouchers',

            'view_comments',
            'edit_comments',

            'view_posts',
            'create_posts',

        ];
        $staffRole->syncPermissions($staffPermissions);

        // Khách hàng không có quyền hệ thống
        $customerRole->syncPermissions([]);

       
    }
}