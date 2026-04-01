<?php

namespace Modules\Cart\Database\Seeders;

use App\Enums\ProductStatus;
use Illuminate\Database\Seeder;
use Modules\Cart\Models\Cart;
use Modules\Cart\Models\CartItem;
use Modules\Categories\Models\Product;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CartItem::query()->delete();

        $products = Product::query()
            ->where('status', ProductStatus::ACTIVE)
            ->orderBy('id')
            ->get();
        if ($products->isEmpty()) {
            return;
        }

        $carts = Cart::query()->orderBy('id')->get();

        foreach ($carts as $cartIndex => $cart) {
            $firstProduct = $products[$cartIndex % $products->count()];
            $secondProduct = $products->count() > 1
                ? $products[($cartIndex + 1) % $products->count()]
                : null;

            $items = [
                [
                    'cart_id' => $cart->id,
                    'product_id' => $firstProduct->id,
                    'quantity' => 1,
                    'price' => $firstProduct->price,
                ],
            ];

            if ($secondProduct && $secondProduct->id !== $firstProduct->id) {
                $items[] = [
                    'cart_id' => $cart->id,
                    'product_id' => $secondProduct->id,
                    'quantity' => 2,
                    'price' => $secondProduct->price,
                ];
            }

            foreach ($items as $item) {
                CartItem::factory()->create([
                    'cart_id' => $item['cart_id'],
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        }
    }
}
