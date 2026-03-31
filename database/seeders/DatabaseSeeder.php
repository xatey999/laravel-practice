<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@mail.com',
            'password' => bcrypt('Admin@123'),
            'role' => UserRoleEnum::ADMIN,
            'phone' => '9876543210'
        ]);

        // Create test customer user
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('Password@123'),
            'role' => UserRoleEnum::CUSTOMER,
            'phone' => '1234567890'
        ]);

        //Create test supplier user
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'Supplier',
            'email' => 'supplier@example.com',
            'password' => bcrypt('Password@123'),
            'role' => UserRoleEnum::SUPPLIER,
            'phone' => '9875641230'
        ]);
    }
}
