<?php

namespace Modules\Categories\Database\Factories;

use App\Enums\ProductStatus;
use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Categories\Models\Category;
use Modules\Categories\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Categories\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $category = Category::query()->inRandomOrder()->first() ?? Category::factory()->create();
        $supplier = User::query()
            ->where('role', UserRoleEnum::SUPPLIER)
            ->inRandomOrder()
            ->first() ?? User::factory()->supplier()->create();

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name . '-' . fake()->unique()->numberBetween(10, 9999)),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 99, 60000),
            'stock' => fake()->numberBetween(0, 300),
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'status' => fake()->randomElement(ProductStatus::cases()),
        ];
    }
}
