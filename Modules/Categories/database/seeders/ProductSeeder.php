<?php

namespace Modules\Categories\Database\Seeders;

use App\Enums\ProductStatus;
use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Categories\Models\Category;
use Modules\Categories\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::query()->delete();

        $suppliers = User::query()
            ->where('role', UserRoleEnum::SUPPLIER)
            ->orderBy('id')
            ->get();
        if ($suppliers->isEmpty()) {
            return;
        }

        $products = [
            [
                'name' => 'Smartphone X100',
                'slug' => 'smartphone-x100',
                'description' => '6.5-inch display smartphone with dual camera.',
                'price' => 18999,
                'stock' => 50,
                'category_slug' => 'mobiles',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'UltraBook Air 14',
                'slug' => 'ultrabook-air-14',
                'description' => 'Lightweight laptop ideal for work and travel.',
                'price' => 54999,
                'stock' => 20,
                'category_slug' => 'laptops',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Nonstick Pan Set',
                'slug' => 'nonstick-pan-set',
                'description' => 'Durable 3-piece nonstick cookware set.',
                'price' => 2499,
                'stock' => 120,
                'category_slug' => 'cookware',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Classic Cotton Shirt',
                'slug' => 'classic-cotton-shirt',
                'description' => 'Breathable cotton shirt for daily wear.',
                'price' => 999,
                'stock' => 200,
                'category_slug' => 'men-clothing',
                'status' => ProductStatus::INACTIVE,
            ],
            [
                'name' => 'Wireless Earbuds Z',
                'slug' => 'wireless-earbuds-z',
                'description' => 'Compact true wireless earbuds with clear sound.',
                'price' => 2999,
                'stock' => 80,
                'category_slug' => 'electronics',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Bluetooth Speaker Mini',
                'slug' => 'bluetooth-speaker-mini',
                'description' => 'Portable speaker with deep bass and 10-hour playback.',
                'price' => 3499,
                'stock' => 65,
                'category_slug' => 'audio',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'USB-C Fast Charger 45W',
                'slug' => 'usb-c-fast-charger-45w',
                'description' => 'Fast charging adapter compatible with modern devices.',
                'price' => 1499,
                'stock' => 150,
                'category_slug' => 'accessories',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Ceramic Dinner Set',
                'slug' => 'ceramic-dinner-set',
                'description' => 'Elegant 18-piece ceramic dinner set for families.',
                'price' => 3299,
                'stock' => 40,
                'category_slug' => 'home-decor',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Air Fryer 4L',
                'slug' => 'air-fryer-4l',
                'description' => 'Oil-free fryer with preset cooking modes.',
                'price' => 6799,
                'stock' => 30,
                'category_slug' => 'cookware',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Men Running T-Shirt',
                'slug' => 'men-running-tshirt',
                'description' => 'Quick-dry sports t-shirt for everyday training.',
                'price' => 799,
                'stock' => 110,
                'category_slug' => 'men-clothing',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Women Casual Kurti',
                'slug' => 'women-casual-kurti',
                'description' => 'Comfort-fit kurti suitable for daily wear.',
                'price' => 1199,
                'stock' => 95,
                'category_slug' => 'women-clothing',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Trail Running Shoes',
                'slug' => 'trail-running-shoes',
                'description' => 'Durable shoes with extra grip for trail runs.',
                'price' => 3599,
                'stock' => 70,
                'category_slug' => 'footwear',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Adjustable Dumbbell Set',
                'slug' => 'adjustable-dumbbell-set',
                'description' => 'Space-saving dumbbell set for home workouts.',
                'price' => 8999,
                'stock' => 25,
                'category_slug' => 'gym-equipment',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Yoga Mat Pro',
                'slug' => 'yoga-mat-pro',
                'description' => 'Non-slip mat with extra cushioning for yoga.',
                'price' => 1499,
                'stock' => 120,
                'category_slug' => 'gym-equipment',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Cricket Bat Premium',
                'slug' => 'cricket-bat-premium',
                'description' => 'Seasoned willow bat for club-level matches.',
                'price' => 4999,
                'stock' => 35,
                'category_slug' => 'outdoor-sports',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Mystery Novel Collection',
                'slug' => 'mystery-novel-collection',
                'description' => 'Set of bestselling mystery and thriller novels.',
                'price' => 1899,
                'stock' => 55,
                'category_slug' => 'fiction',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Office Stationery Kit',
                'slug' => 'office-stationery-kit',
                'description' => 'Complete stationery set for students and offices.',
                'price' => 699,
                'stock' => 200,
                'category_slug' => 'stationery',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Vitamin C Serum',
                'slug' => 'vitamin-c-serum',
                'description' => 'Brightening serum for daily skincare routine.',
                'price' => 899,
                'stock' => 130,
                'category_slug' => 'skincare',
                'status' => ProductStatus::ACTIVE,
            ],
            [
                'name' => 'Whey Protein 1kg',
                'slug' => 'whey-protein-1kg',
                'description' => 'High-protein supplement for post-workout recovery.',
                'price' => 2499,
                'stock' => 90,
                'category_slug' => 'nutrition',
                'status' => ProductStatus::ACTIVE,
            ],
        ];

        $categoriesBySlug = Category::query()->pluck('id', 'slug');

        foreach ($products as $index => $productData) {
            $categoryId = $categoriesBySlug[$productData['category_slug']] ?? null;
            if (! $categoryId) {
                continue;
            }

            $supplier = $suppliers[$index % $suppliers->count()];

            Product::factory()->create([
                'name' => $productData['name'],
                'slug' => $productData['slug'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'category_id' => $categoryId,
                'supplier_id' => $supplier->id,
                'status' => $productData['status'],
            ]);
        }
    }
}
