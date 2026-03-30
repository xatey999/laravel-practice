@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Products Card -->
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h2 class="text-lg font-semibold text-blue-900 mb-2">Products</h2>
                        <p class="text-blue-700 mb-4">Browse and manage products</p>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            View Products
                        </a>
                    </div>

                    <!-- Cart Card -->
                    <div class="bg-green-50 p-6 rounded-lg">
                        <h2 class="text-lg font-semibold text-green-900 mb-2">Shopping Cart</h2>
                        <p class="text-green-700 mb-4">View and manage your cart</p>
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            View Cart
                        </a>
                    </div>

                    <!-- Orders Card -->
                    <div class="bg-purple-50 p-6 rounded-lg">
                        <h2 class="text-lg font-semibold text-purple-900 mb-2">Orders</h2>
                        <p class="text-purple-700 mb-4">Track your orders</p>
                        <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            View Orders
                        </a>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Welcome back, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!</h2>
                    <div class="mt-4 space-y-2 text-gray-600">
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Phone:</strong> {{ Auth::user()->phone }}</p>
                    </div>
                    <p class="text-gray-600 mt-4">You're logged in to your account. Use the navigation above to browse products, manage your cart, and track your orders.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection