@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">{{ $category->name }}</h1>
        @if($category->description)
        <p class="text-gray-600">{{ $category->description }}</p>
        @endif
    </div>

    <div class="mb-6">
        <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Back to Categories</a>
    </div>

    <h2 class="text-2xl font-semibold mb-6">Products in this Category</h2>

    @if($category->products->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="w-full h-48 object-cover">

            <div class="p-4">
                <h3 class="font-semibold mb-2">
                    <a href="{{ $product['show_url'] }}" class="text-blue-600 hover:text-blue-800">
                        {{ $product['name'] }}
                    </a>
                </h3>
                <p class="text-gray-600 text-sm mb-2">{{ $product['description'] }}</p>
                <div class="flex justify-between items-center">
                    <span class="font-bold text-lg">${{ number_format($product['price'], 2) }}</span>
                    <span class="text-sm text-gray-500">Stock: {{ $product['stock'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-gray-500">No products in this category yet.</p>
    @endif

    @if($category->children->count() > 0)
    <div class="mt-12">
        <h2 class="text-2xl font-semibold mb-6">Subcategories</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($category->children as $subcategory)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-2">
                    <a href="{{ route('categories.show', $subcategory) }}" class="text-blue-600 hover:text-blue-800">
                        {{ $subcategory->name }}
                    </a>
                </h3>
                @if($subcategory->description)
                <p class="text-gray-600 mb-4">{{ Str::limit($subcategory->description, 100) }}</p>
                @endif
                <div class="text-sm text-gray-500">
                    {{ $subcategory->products->count() }} products
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection