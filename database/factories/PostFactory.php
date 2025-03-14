<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'excerpt' => $this->faker->text(100),
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'image' => 'blogs/blog-' . rand(1,16) . '.jpg',
            'published_at' => $this->faker->boolean(70) ? now() : null,
        ];
    }

    public function withTagsAndCategories($tags, $categories)
    {
        return $this->afterCreating(function (Post $post) use ($tags, $categories) {
            // Gán tags
            if ($tags->count() > 0) {
                $post->tags()->attach($tags->random(rand(1, min(3, $tags->count())))->pluck('id')->toArray());
            }

            // Gán categories
            if ($categories->count() > 0) {
                $post->categories()->attach($categories->random(rand(1, min(2, $categories->count())))->pluck('id')->toArray());
            }
        });
    }
}
