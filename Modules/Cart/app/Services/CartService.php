<?php

namespace Modules\Cart\Services;

use Modules\Cart\Models\Cart;
use Modules\Cart\Models\CartItem;
use Modules\Cart\Repositories\CartRepository;
use Modules\Categories\Models\Product;

class CartService
{
    public function __construct(
        private CartRepository $repository,
    ) {}

    public function getUserCart(int $userId): Cart
    {
        $cart = $this->repository->getOrCreateCart($userId);
        return $this->repository->getCartWithItems($cart);
    }

    public function addToCart(int $userId, Product $product, int $quantity): CartItem
    {
        $cart = $this->repository->getOrCreateCart($userId);
        return $this->repository->addItemToCart($cart, $product, $quantity);
    }

    public function updateCartItem(CartItem $item, int $quantity): CartItem
    {
        return $this->repository->updateItemQuantity($item, $quantity);
    }

    public function removeFromCart(CartItem $item): bool
    {
        return $this->repository->removeItem($item);
    }

    public function clearUserCart(int $userId): bool
    {
        $cart = $this->repository->getOrCreateCart($userId);
        return $this->repository->clearCart($cart);
    }

    public function getCartTotal(Cart $cart): float
    {
        return $cart->items->sum(fn($item) => $item->quantity * $item->price);
    }
}
