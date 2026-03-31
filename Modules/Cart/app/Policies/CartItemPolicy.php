<?php

namespace Modules\Cart\Policies;

use App\Models\User;
use Modules\Cart\Models\CartItem;

class CartItemPolicy
{
    public function update(User $user, CartItem $cartItem): bool
    {
        return (int) $cartItem->cart->user_id === (int) $user->id;
    }

    public function delete(User $user, CartItem $cartItem): bool
    {
        return $this->update($user, $cartItem);
    }
}
