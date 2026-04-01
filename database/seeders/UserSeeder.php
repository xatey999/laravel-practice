<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->delete();

        User::factory()->admin()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@mail.com',
            'password' => 'Admin@123',
            'phone' => '9876543210',
        ]);

        User::factory()->customer()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'Password@123',
            'phone' => '1234567890',
        ]);

        User::factory()->supplier()->create([
            'first_name' => 'Test',
            'last_name' => 'Supplier',
            'email' => 'supplier@example.com',
            'password' => 'Password@123',
            'phone' => '9875641230',
        ]);

        User::factory()->customer()->create([
            'first_name' => 'Jane',
            'last_name' => 'Customer',
            'email' => 'jane.customer@example.com',
            'password' => 'Password@123',
            'phone' => '9000000001',
        ]);

        User::factory()->supplier()->create([
            'first_name' => 'Michael',
            'last_name' => 'Supplier',
            'email' => 'michael.supplier@example.com',
            'password' => 'Password@123',
            'phone' => '9000000002',
        ]);
    }
}
