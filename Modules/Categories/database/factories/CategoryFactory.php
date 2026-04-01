<?php

namespace Modules\Categories\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Categories\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Categories\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name . '-' . fake()->unique()->numberBetween(10, 9999)),
            'description' => fake()->optional()->sentence(),
            'parent_id' => null,
        ];
    }
}
