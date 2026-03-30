@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold">Manage Categories</h1>
                    <a href="{{ route('admin.categories.create') }}" 
                       class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Add New Category
                    </a>
                </div>

                @if($message = session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md">
                    {{ $message }}
                </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 font-medium">Name</th>
                                <th class="px-6 py-3 font-medium">Slug</th>
                                <th class="px-6 py-3 font-medium">Products</th>
                                <th class="px-6 py-3 font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border-t">
                            @forelse($categories as $category)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <a href="{{ route('categories.show', $category) }}" class="text-blue-600 hover:underline">
                                        {{ $category->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $category->slug }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $category->products->count() }}</td>
                                <td class="px-6 py-4 space-x-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" 
                                       class="inline px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    <a href="{{ route('categories.show', $category) }}" 
                                       class="inline px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        View
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
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
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No categories found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
