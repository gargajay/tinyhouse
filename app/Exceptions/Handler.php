<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

     /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->route() && ($request->route()->getPrefix() == "api" || $request->route()->getPrefix() == "api/external")) {   //add Accept: application/json in request
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return $this->handleApiException($request, $e);
        } else {
            return parent::render($request, $e);
        }
    }

    private function handleApiException(Request $request, Throwable $exception): JsonResponse
    {
        $exception = $this->prepareException($exception);
       
        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception): JsonResponse
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 400;
        }

        $response = [];
        $response['message'] = 'Error occurred, please contact App Support. Error Code = ' . $statusCode;

        if ($exception instanceof GoCarHubException) {
            $response['message'] = $exception->getMessage();
        }
        
        if (config('app.debug')) {
            $response['trace'] = $exception->getMessage();
            $response['code'] = $exception->getCode();
        }

        $response['status'] = $statusCode;

        return response()->json($response, $statusCode);
    }
}
