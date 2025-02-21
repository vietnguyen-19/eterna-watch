<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles'; // Tên bảng trong CSDL

    protected $fillable = ['name']; // Các cột có thể gán giá trị hàng loạt
}
