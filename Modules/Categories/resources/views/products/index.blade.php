@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Products</h1>
        @if($manageProductsUrl)
            <a href="{{ $manageProductsUrl }}" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Manage Products
            </a>
        @endif
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $searchValue }}" placeholder="Search products..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="md:w-64">
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $selectedCategoryId == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                Search
            </button>
        </form>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($product->images->first())
            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-500">No Image</span>
            </div>
            @endif

            <div class="p-4">
                <h3 class="font-semibold mb-2">
                    <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:text-blue-800">
                        {{ $product->name }}
                    </a>
                </h3>
                <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 50) }}</p>
                <div class="flex justify-between items-center mb-4">
                    <span class="font-bold text-lg">${{ number_format($product->price, 2) }}</span>
                    <span class="text-sm text-gray-500">Stock: {{ $product->stock_quantity }}</span>
                </div>

                @if($canAddToCart)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                               class="w-16 px-2 py-1 border border-gray-300 rounded text-center">
                        <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500"
                                {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>
                            Add to Cart
                        </button>
                    </form>
                @elseif($showCartRestrictedMessage)
                    <p class="w-full text-center px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm">
                        Cart is available for customer accounts only.
                    </p>
                @elseif($showLoginToPurchase)
                <a href="{{ route('login') }}" class="w-full block text-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    Login to Purchase
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->appends($paginationQuery)->links() }}
    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-500 text-lg">No products found.</p>
        @if($hasActiveFilters)
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 mt-4 inline-block">Clear filters</a>
        @endif
    </div>
    @endif
</div>
@endsection