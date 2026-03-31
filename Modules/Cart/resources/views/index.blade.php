@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if($cart->items->count() > 0)
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="p-6">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Product</th>
                        <th class="text-center py-2">Price</th>
                        <th class="text-center py-2">Quantity</th>
                        <th class="text-center py-2">Total</th>
                        <th class="text-center py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart->items as $item)
                    <tr class="border-b">
                        <td class="py-4">
                            <div class="flex items-center">
                                @if($item->product->images->first())
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                     alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded mr-4">
                                @endif
                                <div>
                                    <h3 class="font-semibold">
                                        <a href="{{ route('products.show', $item->product) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $item->product->name }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-600">{{ Str::limit($item->product->description, 50) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="text-center py-4">${{ number_format($item->price, 2) }}</td>
                        <td class="text-center py-4">
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                       max="{{ $item->product->stock_quantity }}" class="w-16 px-2 py-1 border border-gray-300 rounded text-center">
                                <button type="submit" class="ml-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                    Update
                                </button>
                            </form>
                        </td>
                        <td class="text-center py-4 font-semibold">${{ number_format($item->quantity * $item->price, 2) }}</td>
                        <td class="text-center py-4">
                            <form action="{{ route('cart.remove', $item) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm"
                                        onclick="return confirm('Remove this item from cart?')">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-between items-center">
        <div>
            <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                        onclick="return confirm('Clear entire cart?')">
                    Clear Cart
                </button>
            </form>
        </div>

        <div class="text-right">
            <div class="text-xl font-semibold mb-4">
                Total: ${{ number_format($cart->items->sum(function($item) { return $item->quantity * $item->price; }), 2) }}
            </div>
            <a href="{{ route('orders.checkout') }}" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                Proceed to Checkout
            </a>
        </div>
    </div>
    @else
    <div class="text-center py-12">
        <div class="text-gray-400 text-6xl mb-4">🛒</div>
        <h2 class="text-2xl font-semibold text-gray-600 mb-4">Your cart is empty</h2>
        <p class="text-gray-500 mb-6">Add some products to get started!</p>
        <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
            Browse Products
        </a>
    </div>
    @endif
</div>
@endsection
