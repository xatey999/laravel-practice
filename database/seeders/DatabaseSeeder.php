<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Cart\Database\Seeders\CartDatabaseSeeder;
use Modules\Categories\Database\Seeders\CategoriesDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategoriesDatabaseSeeder::class,
            CartDatabaseSeeder::class,
        ]);
    }
}
