<?php

namespace Modules\Auth\Http\Controllers;

use App\Actions\CreateUserAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\DataTransferObjects\RegisterFormPayload;
use Modules\Auth\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

        if (!$user) {
            return $this->sendError("Invalid email, user doesn't exists!", Response::HTTP_NOT_FOUND);
        }

        if (!Hash::check($validated['password'], $user->password)) {
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

    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if ($token === null) {
            return $this->sendError("Bearer token not provided!", Response::HTTP_BAD_REQUEST);
        }

        $tokenId = Str::before($token, '|');

        $user = auth()->user();

        if ($user) {
            $user->tokens()->where('id', $tokenId)->delete();
            return $this->sendResponse([], "Logged out Successfully!");
        }

        return $this->sendError('User not authenticated', Response::HTTP_UNAUTHORIZED);
    }
}
