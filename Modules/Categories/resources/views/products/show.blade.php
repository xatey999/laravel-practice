@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product Images -->
        <div>
            @if($product->images->count() > 0)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}"
                     class="w-full h-96 object-cover rounded-lg shadow-md" id="main-image">
            </div>
            @if($product->images->count() > 1)
            <div class="flex gap-2 overflow-x-auto">
                @foreach($product->images as $image)
                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}"
                     class="w-20 h-20 object-cover rounded cursor-pointer border-2 border-transparent hover:border-blue-500 thumbnail">
                @endforeach
            </div>
            @endif
            @else
            <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                <span class="text-gray-500">No Image Available</span>
            </div>
            @endif
        </div>

        <!-- Product Details -->
        <div>
            <nav class="mb-4">
                <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-800">Categories</a>
                @if($product->category)
                <span class="mx-2">></span>
                <a href="{{ route('categories.show', $product->category) }}" class="text-blue-600 hover:text-blue-800">{{ $product->category->name }}</a>
                @endif
                <span class="mx-2">></span>
                <span class="text-gray-600">{{ $product->name }}</span>
            </nav>

            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>

            <div class="mb-6">
                <span class="text-3xl font-bold text-green-600">${{ number_format($product->price, 2) }}</span>
                <span class="ml-4 text-gray-600">Stock: {{ $product->stock_quantity }}</span>
            </div>

            @if($product->description)
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Description</h2>
                <p class="text-gray-700">{{ $product->description }}</p>
            </div>
            @endif

            @if($product->supplier)
            <div class="mb-6">
                <p class="text-sm text-gray-600">Sold by: {{ $product->supplier->name }}</p>
            </div>
            @endif

            <div class="mb-6">
                @if($canAddToCart)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex gap-4 items-end">
                        @csrf
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                   class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <button type="submit" class="px-8 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 font-semibold {{ $product->stock_quantity < 1 ? 'bg-gray-400 cursor-not-allowed hover:bg-gray-400' : '' }}"
                                {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>
                            Add to Cart
                        </button>
                    </form>
                @elseif($showCartRestrictedMessage)
                    <p class="inline-block px-4 py-3 bg-gray-100 text-gray-600 rounded-lg text-sm">
                        Cart is available for customer accounts only.
                    </p>
                @elseif($showLoginToPurchase)
                    <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                        Login to Purchase
                    </a>
                @endif
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold mb-2">Product Status</h3>
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusBadgeClass }}">
                    {{ $statusLabel }}
                </span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.getElementById('main-image');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            mainImage.src = this.src;
            // Remove border from all thumbnails
            thumbnails.forEach(t => t.classList.remove('border-blue-500'));
            // Add border to clicked thumbnail
            this.classList.add('border-blue-500');
        });
    });
});
</script>
@endsection