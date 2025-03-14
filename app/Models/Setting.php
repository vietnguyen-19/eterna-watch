<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'settings'; // Tên bảng trong database

    protected $fillable = ['key_name', 'value']; // Các cột có thể ghi dữ liệu vào

}
