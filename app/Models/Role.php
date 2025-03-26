<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role as SpatieRole;


class Role extends Model
{
    use HasFactory,HasRoles;

    protected $table = 'roles'; // Tên bảng trong CSDL

    protected $fillable = ['name','guard_name']; // Các cột có thể gán giá trị hàng loạt
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }
}

