<?php

namespace Modules\Auth\Http\Controllers;

use App\Actions\CreateUserAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\DataTransferObjects\RegisterFormPayload;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if(!$user) {
            return $this->sendError("Invalid email, user doesn't exists!", Response::HTTP_NOT_FOUND);
        }

        if(!Hash::check($validated['password'], $user->password)) {
            return $this->sendError("Unauthorized!", Response::HTTP_UNAUTHORIZED);
        }

        $accessToken = $user->createToken('auth_token')->plainTextToken;

        return $this->sendResponse(
            [
                'user' => new UserResource($user),
                'accessToken' => $accessToken,
            ],
            'Login successful',
            Response::HTTP_OK
        );
    }
}
