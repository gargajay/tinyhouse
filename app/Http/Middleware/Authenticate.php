<?php

namespace App\Http\Middleware;

use App\Exceptions\GoCarHubException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     * @throws GoCarHubException
     */
    protected function redirectTo($request)
    {
        if ($request->is('api/*')) {
            throw GoCarHubException::unAuthorized();
        }
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
