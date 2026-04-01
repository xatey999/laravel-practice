<?php

namespace Modules\Categories\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Modules\Categories\Models\Product;
use Modules\Categories\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductImage::query()->delete();

        $products = Product::query()->get();
        $basePublicStoragePath = public_path('storage/products');

        foreach ($products as $product) {
            $productDirectory = "{$basePublicStoragePath}/{$product->slug}";
            $primaryImagePath = "products/{$product->slug}/primary.jpg";
            $primaryImageFile = "{$productDirectory}/primary.jpg";

            if (! File::exists($primaryImageFile)) {
                continue;
            }

            ProductImage::factory()->create([
                'product_id' => $product->id,
                'image_path' => $primaryImagePath,
                'is_primary' => true,
            ]);
        }
    }
}
