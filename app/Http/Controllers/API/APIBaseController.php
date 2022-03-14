<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use Auth;

class APIBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        $user = Auth::guard('api')->user();

        $csrf = null;
        if ($user) {
            $user->rollCsrfKey();
            $csrf = $user->csrf_token;
        }

        $response = [
            'response_code' => 1,
            'data' => $result,
            'message' => $message,
            'csrf_token' => $csrf,
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $responseCode = -1, $errorMessages = [], $code = 404)
    {
        $user = Auth::guard('api')->user();

        $csrf = null;
        if ($user) {
            $user->rollCsrfKey();
            $csrf = $user->csrf_token;
        }

        $response = [
            'response_code' => $responseCode,
            'message' => $error,
            'csrf_token' => $csrf,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
