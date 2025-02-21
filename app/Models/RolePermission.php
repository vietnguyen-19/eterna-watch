<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    protected $table = 'role_permission';
    public $incrementing = false; // Vì khóa chính là tổ hợp
    protected $primaryKey = ['role_id', 'permission_id'];
}
