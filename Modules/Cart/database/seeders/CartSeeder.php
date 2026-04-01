<?php

namespace Modules\Cart\Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Cart\Models\Cart;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cart::query()->delete();

        $customers = User::query()->where('role', UserRoleEnum::CUSTOMER)->get();

        foreach ($customers as $customer) {
            Cart::factory()->create([
                'user_id' => $customer->id,
            ]);
        }
    }
}
