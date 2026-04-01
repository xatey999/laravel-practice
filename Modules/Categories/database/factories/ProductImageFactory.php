<?php

namespace Modules\Categories\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Categories\Models\Product;
use Modules\Categories\Models\ProductImage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Categories\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition(): array
    {
        $product = Product::query()->inRandomOrder()->first() ?? Product::factory()->create();

        return [
            'product_id' => $product->id,
            'image_path' => 'products/' . $product->slug . '/image-' . fake()->numberBetween(1, 4) . '.jpg',
            'is_primary' => false,
        ];
    }
}
