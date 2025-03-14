<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    // Khai báo bảng mà Model này sẽ quản lý
    protected $table = 'role_has_permissions';

    // Nếu bảng không có trường `created_at` và `updated_at`
    public $timestamps = false;

    // Khai báo các cột có thể thay đổi
    protected $fillable = [
        'permission_id',
        'role_id',
    ];

    // Quan hệ với Model Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Quan hệ với Model Permission
    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
