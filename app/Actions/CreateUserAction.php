<?php

namespace App\Actions;

use App\DataTransferObjects\RegisterFormPayload;
use App\Models\User;

class CreateUserAction
{
    public function __construct(
    )
    {}

    public function handle(RegisterFormPayload $dto)
    {
        return User::create([
            'first_name' => $dto->firstName,
            'last_name' => $dto->lastName,
            'email' => $dto->email,
            'phone' => cleanPhoneNumber($dto->phone),
            'role' => $dto->role,
            'password' => bcrypt($dto->password)
        ]);
    }
}