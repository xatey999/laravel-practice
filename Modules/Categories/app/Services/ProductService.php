<?php

namespace Modules\Categories\Services;

use App\DataTransferObjects\ProductDTO;
use Modules\Categories\Models\Product;
use Modules\Categories\Actions\CreateProductAction;
use Modules\Categories\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $repository,
        private CreateProductAction $createAction,
    ) {}

    public function getFeaturedProducts(int $limit = 8)
    {
        return $this->repository->getFeaturedProducts($limit);
    }

    public function getAllCategories()
    {
        return $this->repository->getAllCategories();
    }

    public function searchAndFilter(
        ?string $search = null,
        ?int $categoryId = null,
        int $perPage = 12
    ) {
        return $this->repository->searchAndFilter($search, $categoryId, $perPage);
    }

    public function listForManagement(?string $search, ?int $categoryId, ?int $supplierId = null)
    {
        return $this->repository->listForManagement($search, $categoryId, $supplierId);
    }

    public function getProductWithImages(Product $product)
    {
        return $this->repository->getWithImages($product);
    }

    public function createProduct(array $data): Product
    {
        $productDTO = ProductDTO::fromArray($data);
        return $this->createAction->execute($productDTO);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        if (! array_key_exists('supplier_id', $data)) {
            $data['supplier_id'] = $product->supplier_id;
        }

        $productDTO = ProductDTO::fromArray($data);
        $product->update($productDTO->toArray());

        return $product->fresh();
    }

    public function deleteProduct(Product $product): bool
    {
        return $this->repository->delete($product);
    }
}
