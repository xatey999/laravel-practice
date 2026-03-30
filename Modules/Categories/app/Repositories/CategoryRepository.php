<?php

namespace Modules\Categories\Repositories;

use Modules\Categories\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function getFeaturedCategories(int $limit = 6): Collection
    {
        return Category::with('products')
            ->where('parent_id', null)
            ->limit($limit)
            ->get();
    }

    public function getWithProducts(Category $category)
    {
        return $category->load('products.images', 'children.products.images');
    }

    public function getAll()
    {
        return Category::with('products')->get();
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
