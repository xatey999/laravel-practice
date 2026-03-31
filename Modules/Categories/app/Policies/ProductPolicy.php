<?php

namespace Modules\Categories\Policies;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Modules\Categories\Models\Product;

class ProductPolicy
{
    public function create(User $user): bool
    {
        return in_array($user->role, [UserRoleEnum::ADMIN, UserRoleEnum::SUPPLIER], true);
    }

    public function update(User $user, Product $product): bool
    {
        if ($user->role === UserRoleEnum::ADMIN) {
            return true;
        }

        return $user->role === UserRoleEnum::SUPPLIER
            && (int) $product->supplier_id === (int) $user->id;
    }

    public function delete(User $user, Product $product): bool
    {
        return $this->update($user, $product);
    }
}
