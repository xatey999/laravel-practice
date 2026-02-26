<?php

namespace App\DataTransferObjects;

class RegisterFormPayload
{
    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $email,
        private readonly string $phone,
        private readonly string $role,
    ) {}

    public static function fromRequest(array $validated)
    {
        return new self(
            $validated['first_name'],
            $validated['last_name'],
            $validated['email'],
            $validated['phone'],
            $validated['role']
        );
    }
}