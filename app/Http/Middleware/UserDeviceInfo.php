<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UserDeviceInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        Log::info("d".json_encode($request->device_token));

        $user = auth()->user();

        if ($user && !empty($request->device_token)) {

            $user = User::find(auth()->id());
            if ($user) {
                saveDeviceToken($user,$request->device_type,$request->device_token);
            }
        }

        return $next($request);
    }
}
