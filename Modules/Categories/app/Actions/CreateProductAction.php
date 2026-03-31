<?php

namespace Modules\Categories\Actions;

use App\DataTransferObjects\ProductDTO;
use Modules\Categories\Models\Product;

class CreateProductAction
{
    public function execute(ProductDTO $productDTO): Product
    {
        return Product::create($productDTO->toArray());
    }
}
