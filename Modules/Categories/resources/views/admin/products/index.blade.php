@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold">{{ $routePrefix === 'admin' ? 'Manage Products' : 'My Products' }}</h1>
                    <a href="{{ route($routePrefix . '.products.create') }}"
                       class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Add New Product
                    </a>
                </div>

                @if($message = session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md">
                    {{ $message }}
                </div>
                @endif

                <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <form method="GET" action="{{ route($routePrefix . '.products.index') }}" class="md:col-span-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search products..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 font-medium">Name</th>
                                <th class="px-6 py-3 font-medium">Slug</th>
                                <th class="px-6 py-3 font-medium">Category</th>
                                @if($routePrefix === 'admin')
                                <th class="px-6 py-3 font-medium">Supplier</th>
                                @endif
                                <th class="px-6 py-3 font-medium">Price</th>
                                <th class="px-6 py-3 font-medium">Stock</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                                <th class="px-6 py-3 font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border-t">
                            @forelse($products as $product)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:underline">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-xs">{{ $product->slug }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $product->category->name ?? 'N/A' }}</td>
                                @if($routePrefix === 'admin')
                                <td class="px-6 py-4 text-gray-600">{{ $product->supplier->full_name ?? $product->supplier->email ?? 'N/A' }}</td>
                                @endif
                                <td class="px-6 py-4 text-gray-600">${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $product->stock_quantity }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full {{ $product->status === \App\Enums\ProductStatus::ACTIVE ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $product->status->value }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 space-x-2">
                                    <a href="{{ route($routePrefix . '.products.edit', $product) }}"
                                       class="inline px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    <a href="{{ route('products.show', $product) }}"
                                       class="inline px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        View
                                    </a>
                                    <form method="POST" action="{{ route($routePrefix . '.products.destroy', $product) }}"
                                          class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $routePrefix === 'admin' ? 8 : 7 }}" class="px-6 py-4 text-center text-gray-500">
                                    No products found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ route('categories.index') }}" class="text-blue-600 hover:underline">
                        ← Back to Categories
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
