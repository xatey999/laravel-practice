<?php

namespace Modules\Categories\Actions;

use Modules\Categories\Models\Category;

class UpdateCategoryAction
{
    public function execute(Category $category, array $data): Category
    {
        $category->update($data);
        return $category->fresh();
    }
}
