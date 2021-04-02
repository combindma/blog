<?php

namespace Combindma\Blog\Database\Factories;

use Combindma\Blog\Enums\Languages;
use Combindma\Blog\Models\Author;
use Combindma\Blog\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(10, true),
            'author_id' => Author::factory(),
            'language' => Languages::French,
            'content' => $this->faker->sentence(1000),
            'description' => $this->faker->sentence(55),
            'reading_time' => '5 min',
            'published_at' => now(),
            'modified_at' => now(),
            'is_published' => $this->faker->boolean,
            'is_featured' => $this->faker->boolean,
            'meta_title' => $this->faker->words(10, true),
            'meta_description' => $this->faker->sentence(10),
            'meta' => [],
        ];
    }
}
