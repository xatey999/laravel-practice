<?php

namespace App\DataTransferObjects;

class RegisterFormPayload
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $role,
        public readonly string $password,
    ) {}

    public static function fromRequest(array $validated)
    {
        return new self(
            $validated['first_name'],
            $validated['last_name'],
            $validated['email'],
            $validated['phone'],
            $validated['role'],
            $validated['password']
        );
    }
}