<?php

namespace Modules\Categories\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Categories\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::query()->delete();

        $rootCategories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Devices, gadgets, and accessories.',
            ],
            [
                'name' => 'Home & Kitchen',
                'slug' => 'home-kitchen',
                'description' => 'Daily-use home and kitchen essentials.',
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Clothing and style products.',
            ],
            [
                'name' => 'Sports & Fitness',
                'slug' => 'sports-fitness',
                'description' => 'Equipment and essentials for active lifestyles.',
            ],
            [
                'name' => 'Books & Stationery',
                'slug' => 'books-stationery',
                'description' => 'Books, office supplies, and learning tools.',
            ],
            [
                'name' => 'Health & Personal Care',
                'slug' => 'health-personal-care',
                'description' => 'Wellness, grooming, and personal care products.',
            ],
        ];

        foreach ($rootCategories as $category) {
            Category::factory()->create($category);
        }

        $subCategories = [
            ['name' => 'Mobiles', 'slug' => 'mobiles', 'parent_slug' => 'electronics'],
            ['name' => 'Laptops', 'slug' => 'laptops', 'parent_slug' => 'electronics'],
            ['name' => 'Audio', 'slug' => 'audio', 'parent_slug' => 'electronics'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'parent_slug' => 'electronics'],
            ['name' => 'Cookware', 'slug' => 'cookware', 'parent_slug' => 'home-kitchen'],
            ['name' => 'Home Decor', 'slug' => 'home-decor', 'parent_slug' => 'home-kitchen'],
            ['name' => 'Men Clothing', 'slug' => 'men-clothing', 'parent_slug' => 'fashion'],
            ['name' => 'Women Clothing', 'slug' => 'women-clothing', 'parent_slug' => 'fashion'],
            ['name' => 'Footwear', 'slug' => 'footwear', 'parent_slug' => 'fashion'],
            ['name' => 'Gym Equipment', 'slug' => 'gym-equipment', 'parent_slug' => 'sports-fitness'],
            ['name' => 'Outdoor Sports', 'slug' => 'outdoor-sports', 'parent_slug' => 'sports-fitness'],
            ['name' => 'Fiction', 'slug' => 'fiction', 'parent_slug' => 'books-stationery'],
            ['name' => 'Stationery', 'slug' => 'stationery', 'parent_slug' => 'books-stationery'],
            ['name' => 'Skincare', 'slug' => 'skincare', 'parent_slug' => 'health-personal-care'],
            ['name' => 'Nutrition', 'slug' => 'nutrition', 'parent_slug' => 'health-personal-care'],
        ];

        foreach ($subCategories as $subCategory) {
            $parent = Category::query()->where('slug', $subCategory['parent_slug'])->first();
            if (! $parent) {
                continue;
            }

            Category::factory()->create([
                'name' => $subCategory['name'],
                'slug' => $subCategory['slug'],
                'description' => null,
                'parent_id' => $parent->id,
            ]);
        }
    }
}
