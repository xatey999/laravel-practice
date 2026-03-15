<?php

namespace Modules\Auth\Http\Controllers;

use App\Actions\CreateUserAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\DataTransferObjects\RegisterFormPayload;
use Modules\Auth\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends ApiBaseController
{
    public function register(RegisterRequest $request, CreateUserAction $action)
    {
        $user = $action->handle(RegisterFormPayload::fromRequest($request->validated()));
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->sendResponse(
            [
                'user' => new UserResource($user),
                'token' => $token,
            ],
            'User registered successfully',
            Response::HTTP_CREATED
        );
    }
}
