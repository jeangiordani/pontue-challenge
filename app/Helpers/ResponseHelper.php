<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function responseSuccess($data, $statusCode): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], $statusCode);
    }

    public static function responseFail($messages, $statusCode): JsonResponse
    {
        return response()->json([
            'status' => 'fail',
            'messages' => $messages
        ], $statusCode);
    }

    public static function responseNotFound($messages, $statusCode): JsonResponse
    {
        return response()->json([
            'status' => 'not found',
            'messages' => $messages
        ], $statusCode);
    }
}
