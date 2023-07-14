<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GoCarHubException extends Exception
{
    /**
     * @throws GoCarHubException
     */
    public static function unAuthorized()
    {
        throw new GoCarHubException(UNAUTHENTICATED, STATUS_UNAUTHORIZED);
    }

    public function render($message, $code = STATUS_BAD_REQUEST): JsonResponse
    {
        return response()->json(['success' => FALSE, 'status' => $code, 'message' => $message]);
    }

    /**
     * @throws GoCarHubException
     */
    public static function assertValidation(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = Validator::make($data, $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            throw new GoCarHubException($validator->errors()->first(), 400);
        }
    }
}

