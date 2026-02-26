<?php

namespace Modules\Auth\Http\Controllers;

use App\Actions\CreateUserAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\DataTransferObjects\RegisterFormPayload;
use Modules\Auth\Http\Requests\RegisterRequest;

class AuthController extends ApiBaseController
{
    public function register(RegisterRequest $request, CreateUserAction $action)
    {
        $validated = $request->validated();

        $this->sendResponse(
            $action->handle(RegisterFormPayload::fromRequest($validated)),
            'User registered sucessfully',
            201
        );
    }
}
