<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\Product;
// use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'entity_id',
        'entity_type',
        'content',
        'rating',
        'parent_id',
    ];

    // Liên kết với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Liên kết Polymorphic: Post hoặc Product
    public function entity()
    {
        return $this->morphTo();
    }

    // Liên kết để lấy các reply của comment
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Liên kết để lấy comment gốc (nếu là reply)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

}
