<?php

namespace Modules\Categories\Repositories;

use App\Enums\ProductStatus;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Categories\Models\Category;
use Modules\Categories\Models\Product;

class ProductRepository
{
    public function getAllCategories(): Collection
    {
        return Category::query()
            ->select(['id', 'name', 'slug', 'description', 'parent_id'])
            ->with(['children.products.images', 'parent.products.images', 'products.images'])
            ->orderBy('name')
            ->get();
    }

    public function getFeaturedProducts(int $limit = 8)
    {
        return Product::with('images', 'category')
            ->where('status', 'active')
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    public function searchAndFilter(
        ?string $search = null,
        ?int $categoryId = null,
        int $perPage = 12
    ): LengthAwarePaginator  {
        $query = Product::with('category', 'supplier', 'images')
            ->where('status', ProductStatus::ACTIVE);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Products for admin (all suppliers) or supplier (scoped to $supplierId).
     */
    public function listForManagement(?string $search, ?int $categoryId, ?int $supplierId): Collection
    {
        $query = Product::query()
            ->with(['category', 'supplier'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId));

        if ($supplierId !== null) {
            $query->where('supplier_id', $supplierId);
        }

        return $query->get();
    }

    public function getWithImages(Product $product)
    {
        return $product->load('category', 'supplier', 'images');
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }
}
