@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Categories</h1>
        @if(Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Manage Categories
        </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-2">
                <a href="{{ route('categories.show', $category) }}" class="text-blue-600 hover:text-blue-800">
                    {{ $category->name }}
                </a>
            </h2>
            @if($category->description)
            <p class="text-gray-600 mb-4">{{ Str::limit($category->description, 100) }}</p>
            @endif
            <div class="text-sm text-gray-500">
                {{ $category->products->count() }} products
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
