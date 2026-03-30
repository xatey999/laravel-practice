<?php

namespace Modules\Categories\Services;

use App\DataTransferObjects\CategoryDTO;
use Modules\Categories\Models\Category;
use Modules\Categories\Actions\CreateCategoryAction;
use Modules\Categories\Actions\UpdateCategoryAction;
use Modules\Categories\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(
        private CategoryRepository $repository,
        private CreateCategoryAction $createAction,
        private UpdateCategoryAction $updateAction,
    ) {}

    public function getFeaturedCategories(int $limit = 6)
    {
        return $this->repository->getFeaturedCategories($limit);
    }

    public function getAllCategories()
    {
        return $this->repository->getAll();
    }

    public function getCategoryWithProducts(Category $category)
    {
        return $this->repository->getWithProducts($category);
    }

    public function createCategory(array $data): Category
    {
        $categoryDTO = CategoryDTO::fromArray($data);
        return $this->createAction->execute($categoryDTO);
    }

    public function updateCategory(Category $category, array $data): Category
    {
        return $this->updateAction->execute($category, $data);
    }

    public function deleteCategory(Category $category): bool
    {
        return $this->repository->delete($category);
    }
}
