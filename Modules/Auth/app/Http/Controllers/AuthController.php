<?php

namespace Modules\Auth\Http\Controllers;

use App\Actions\CreateUserAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\DataTransferObjects\RegisterFormPayload;
use Modules\Auth\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (!Auth::attempt($validated)) {
            return $this->sendError("Invalid credentials", Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user('sanctum');

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

    public function logout(Request $request)
    {
        if ($request->bearerToken() === null) {
            return $this->sendError("Bearer token not provided!", Response::HTTP_BAD_REQUEST);
        }

        $user = $request->user('sanctum');

        if ($user) {
            $user->currentAccessToken()->delete();
            return $this->sendResponse([], "Logged out Successfully!");
        }

        return $this->sendError('User not authenticated', Response::HTTP_UNAUTHORIZED);
    }
}
