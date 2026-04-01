<?php

namespace Modules\Cart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cart\Models\Cart;
use Modules\Cart\Models\CartItem;
use Modules\Categories\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Cart\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition(): array
    {
        $cart = Cart::query()->inRandomOrder()->first() ?? Cart::factory()->create();
        $product = Product::query()->inRandomOrder()->first() ?? Product::factory()->create();

        return [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => fake()->numberBetween(1, 4),
            'price' => $product->price,
        ];
    }
}
