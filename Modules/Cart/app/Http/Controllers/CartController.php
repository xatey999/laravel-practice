<?php

namespace Modules\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\Http\Requests\AddToCartRequest;
use Modules\Cart\Models\CartItem;
use Modules\Cart\Services\CartService;
use Modules\Categories\Models\Product;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService,
    ) {}

    /**
     * Display the user's cart.
     */
    public function index()
    {
        $cart = $this->cartService->getUserCart(Auth::user()->id);
        return view('cart::index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(AddToCartRequest $request, Product $product)
    {
        $this->cartService->addToCart(Auth::user()->id, $product, $request->validated()['quantity']);

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorize('update', $cartItem);

        $request->validate(['quantity' => 'required|integer|min:1']);

        $this->cartService->updateCartItem($cartItem, $request->quantity);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove item from cart.
     */
    public function remove(CartItem $cartItem)
    {
        $this->authorize('delete', $cartItem);

        $this->cartService->removeFromCart($cartItem);

        return redirect()->route('cart.index')->with('success', 'Item removed from cart successfully.');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        $this->cartService->clearUserCart(Auth::user()->id);

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully.');
    }
}
