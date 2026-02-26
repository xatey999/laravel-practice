<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiBaseController extends Controller
{
    public function sendResponse($data, $message = "Success", $successCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message
        ], $successCode);
    }

    public function sendError($error, $errorCode = 404): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $error,
        ], $errorCode);
    }
}
