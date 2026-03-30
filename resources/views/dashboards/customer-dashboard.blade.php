@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-2">Welcome, {{ Auth::user()->first_name }}!</h1>
                <p class="text-gray-600 mb-6">Discover and shop amazing products</p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Browse Products -->
                    <div class="bg-blue-50 p-6 rounded-lg border-l-4 border-blue-600">
                        <h2 class="text-lg font-semibold text-blue-900 mb-2">Browse Products</h2>
                        <p class="text-blue-700 mb-4">Explore our wide range of products</p>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Shop Now
                        </a>
                    </div>

                    <!-- Categories -->
                    <div class="bg-green-50 p-6 rounded-lg border-l-4 border-green-600">
                        <h2 class="text-lg font-semibold text-green-900 mb-2">Categories</h2>
                        <p class="text-green-700 mb-4">Browse by category</p>
                        <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            View Categories
                        </a>
                    </div>

                    <!-- Shopping Cart -->
                    <div class="bg-purple-50 p-6 rounded-lg border-l-4 border-purple-600">
                        <h2 class="text-lg font-semibold text-purple-900 mb-2">Shopping Cart</h2>
                        <p class="text-purple-700 mb-4">View and manage your cart</p>
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">
                            View Cart
                        </a>
                    </div>

                    <!-- My Orders -->
                    <div class="bg-indigo-50 p-6 rounded-lg border-l-4 border-indigo-600">
                        <h2 class="text-lg font-semibold text-indigo-900 mb-2">My Orders</h2>
                        <p class="text-indigo-700 mb-4">Track and manage your orders</p>
                        <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            View Orders
                        </a>
                    </div>

                    <!-- Wishlist (Future Feature) -->
                    <div class="bg-pink-50 p-6 rounded-lg border-l-4 border-pink-600">
                        <h2 class="text-lg font-semibold text-pink-900 mb-2">Favorites</h2>
                        <p class="text-pink-700 mb-4">View your saved items</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700">
                            View Favorites
                        </a>
                    </div>

                    <!-- Account Settings -->
                    <div class="bg-yellow-50 p-6 rounded-lg border-l-4 border-yellow-600">
                        <h2 class="text-lg font-semibold text-yellow-900 mb-2">Account</h2>
                        <p class="text-yellow-700 mb-4">Manage your profile and settings</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                            Settings
                        </a>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Your Account Information</h2>
                    <div class="mt-4 space-y-2 text-gray-600">
                        <p><strong>Status:</strong> <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold capitalize">{{ Auth::user()->role }}</span></p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Phone:</strong> {{ Auth::user()->phone }}</p>
                    </div>
                    <p class="text-gray-600 mt-4">Happy shopping! Browse our products and add items to your cart.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
