<?php

namespace Combindma\Blog\Database\Factories;

use Combindma\Blog\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostCategoryFactory extends Factory
{
    protected $model = PostCategory::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(10),
        ];
    }
}
