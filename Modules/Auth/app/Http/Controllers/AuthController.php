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
        return $this->sendResponse(
            new UserResource(
                $action->handle(RegisterFormPayload::fromRequest($request->validated()))
            ),
            'User registered successfully',
            Response::HTTP_CREATED
        );
    }
}
