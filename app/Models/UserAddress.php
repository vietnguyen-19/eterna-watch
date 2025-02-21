<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'city', 'district', 'ward', 'specific_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
