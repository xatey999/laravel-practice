<?php

namespace Modules\Categories\Actions;

use App\DataTransferObjects\CategoryDTO;
use Modules\Categories\Models\Category;

class CreateCategoryAction
{
    public function execute(CategoryDTO $categoryDTO): Category
    {
        return Category::create($categoryDTO->toArray());
    }
}
