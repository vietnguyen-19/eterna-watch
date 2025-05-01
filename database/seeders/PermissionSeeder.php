<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
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
            'manage_contacts'
        ];

        $permissions = [];

        foreach ($permissionNames as $name) {
            $permissions[] = [
                'name' => $name,
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('permissions')->insert($permissions);
    }
}