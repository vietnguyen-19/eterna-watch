<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $users = User::factory(5)->create();
        }

        // Lấy tất cả tags, nếu chưa có thì tạo 10 tags
        $tags = Tag::all();
        if ($tags->isEmpty()) {
            $tags = Tag::factory(10)->create();
        }

        // Lấy tất cả categories, nếu chưa có thì tạo 5 categories
        $categories = Category::all();
        if ($categories->isEmpty()) {
            $categories = Category::factory(5)->create();
        }

        // Tạo bài viết và gán tags + categories
        foreach ($users as $user) {
            Post::factory(2)->create(['user_id' => $user->id])->each(function ($post) use ($tags, $categories) {
                // Gán từ 2-4 tags cho mỗi bài viết
                $post->tags()->attach($tags->random(rand(2, 4))->pluck('id')->toArray());

                // Gán từ 1-2 categories cho mỗi bài viết
                $post->categories()->attach($categories->random(rand(1, 2))->pluck('id')->toArray());
            });
        }
    }
}
