<?php

namespace Modules\Cart\Database\Factories;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cart\Models\Cart;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Cart\Models\Cart>
 */
class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition(): array
    {
        $customer = User::query()
            ->where('role', UserRoleEnum::CUSTOMER)
            ->inRandomOrder()
            ->first() ?? User::factory()->customer()->create();

        return [
            'user_id' => $customer->id,
        ];
    }
}
