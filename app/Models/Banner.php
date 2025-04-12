<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'position',
        'title',
        'image',
        'link',
        'description',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public static function getByPosition(string $position)
    {
        return static::where('position', $position)
            ->where('is_active', true)
            ->latest() // sắp xếp mới nhất lên trước
            ->get();
    }
}
