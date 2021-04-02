<?php

namespace Combindma\Blog\Database\Factories;

use Combindma\Blog\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true)
        ];
    }
}
