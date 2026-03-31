<?php

namespace Modules\Cart\Repositories;

use Modules\Cart\Models\Cart;
use Modules\Cart\Models\CartItem;
use Modules\Categories\Models\Product;

class CartRepository
{
    public function getOrCreateCart(int $userId): Cart
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    public function getCartWithItems(Cart $cart)
    {
        return $cart->load('items.product.images');
    }

    public function addItemToCart(Cart $cart, Product $product, int $quantity): CartItem
    {
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + $quantity]);
            return $cartItem;
        }

        return $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price,
        ]);
    }

    public function updateItemQuantity(CartItem $item, int $quantity): CartItem
    {
        $item->update(['quantity' => $quantity]);
        return $item;
    }

    public function removeItem(CartItem $item): bool
    {
        return $item->delete();
    }

    public function clearCart(Cart $cart): bool
    {
        return $cart->items()->delete();
    }
}
