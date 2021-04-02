<?php

namespace Combindma\Blog\Database\Factories;

use Combindma\Blog\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

Class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'job' => $this->faker->text(10),
            'description' => $this->faker->text(100),
            'meta' => [],
        ];
    }
}
