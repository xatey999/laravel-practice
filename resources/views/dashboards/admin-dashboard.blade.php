@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-2">Admin Dashboard</h1>
                <p class="text-gray-600 mb-6">Manage your e-commerce platform</p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Users Management -->
                    <div class="bg-blue-50 p-6 rounded-lg border-l-4 border-blue-600">
                        <h2 class="text-lg font-semibold text-blue-900 mb-2">Users Management</h2>
                        <p class="text-blue-700 mb-4">Manage all users and their roles</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Manage Users
                        </a>
                    </div>

                    <!-- Categories Management -->
                    <div class="bg-purple-50 p-6 rounded-lg border-l-4 border-purple-600">
                        <h2 class="text-lg font-semibold text-purple-900 mb-2">Categories</h2>
                        <p class="text-purple-700 mb-4">Create and manage product categories</p>
                        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">
                            Manage Categories
                        </a>
                    </div>

                    <!-- Products Management -->
                    <div class="bg-green-50 p-6 rounded-lg border-l-4 border-green-600">
                        <h2 class="text-lg font-semibold text-green-900 mb-2">Products</h2>
                        <p class="text-green-700 mb-4">View and manage all products</p>
                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            Manage Products
                        </a>
                    </div>

                    <!-- Orders Management -->
                    <div class="bg-indigo-50 p-6 rounded-lg border-l-4 border-indigo-600">
                        <h2 class="text-lg font-semibold text-indigo-900 mb-2">Orders</h2>
                        <p class="text-indigo-700 mb-4">Monitor and manage customer orders</p>
                        <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            View Orders
                        </a>
                    </div>

                    <!-- Suppliers Management -->
                    <div class="bg-yellow-50 p-6 rounded-lg border-l-4 border-yellow-600">
                        <h2 class="text-lg font-semibold text-yellow-900 mb-2">Suppliers</h2>
                        <p class="text-yellow-700 mb-4">Manage supplier accounts and inventory</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                            Manage Suppliers
                        </a>
                    </div>

                    <!-- Reports & Analytics -->
                    <div class="bg-red-50 p-6 rounded-lg border-l-4 border-red-600">
                        <h2 class="text-lg font-semibold text-red-900 mb-2">Reports</h2>
                        <p class="text-red-700 mb-4">View sales and platform analytics</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                            View Reports
                        </a>
                    </div>
                </div>

                <!-- Admin Info -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Welcome back, {{ Auth::user()->first_name }}!</h2>
                    <div class="mt-4 space-y-2 text-gray-600">
                        <p><strong>Role:</strong> <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold capitalize">{{ Auth::user()->role }}</span></p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
