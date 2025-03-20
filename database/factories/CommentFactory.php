<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        // Random chọn entity_type và entity_id
        $entityType = $this->faker->randomElement(['post', 'product']);
        $entityId = null;

        if ($entityType === 'post') {
            $entityId = \App\Models\Post::inRandomOrder()->first()->id ?? 1;
        } elseif ($entityType === 'product') {
            $entityId = \App\Models\Product::inRandomOrder()->first()->id ?? 1;
        }

        // Random chọn parent_id (comment gốc) hoặc null (comment mới)
        $parentId = (Comment::exists() && rand(0, 1)) ? Comment::inRandomOrder()->first()->id : null;

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'entity_id' => $entityId,
            'entity_type' => $entityType,
            'content' => $this->faker->paragraph,
            'rating' => $entityType === 'product' ? $this->faker->numberBetween(1, 5) : null,
            'parent_id' => $parentId,
        ];
    }
}
