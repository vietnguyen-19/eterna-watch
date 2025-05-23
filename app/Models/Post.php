<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id', 'title', 'content', 'excerpt', 'status', 'image', 'published_at', 'view_count'
    ];
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
    public function categories() {
        return $this->belongsToMany(Category::class, 'post_categories');
    } 
    public function comments()
    {
        return $this->morphMany(Comment::class, 'entity');
    }
}
