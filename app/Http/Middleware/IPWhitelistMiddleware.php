<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\IpUtils;

class IPWhitelistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedOrigins = [
            'https://gocarhub.app',
            'https://www.gocarhub.app',
            'http://carhub.mi6.global'
        ];
        $origin = $request->header('Origin');

        Log::info("orign" . json_encode($origin));

        if (in_array($origin, $allowedOrigins)) {
            return $next($request)->header('Access-Control-Allow-Origin', $origin)->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')->header('Access-Control-Allow-Headers', 'Content-Type');
        } else {
            return response('Unauthorized', 401);
        }

    }
}
