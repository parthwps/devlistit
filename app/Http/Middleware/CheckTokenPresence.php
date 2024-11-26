<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTokenPresence
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
         $excludedRoutes = [
            'api/v1/settings',
            'api/v1/login',
            'api/v1/register',
            'api/v1/send-reset-password-link',
            'api/v1/update-password',
            'api/v1/validate-request',
            'api/v1/resend-code',
            'api/v1/email/verify',
            'api/v1/auth/google',
            'api/v1/auth/google/callback',
            'api/v1/ad-status'
        ];

        // Check if the current route path is not in the excluded list
        if (!in_array($request->path(), $excludedRoutes)) 
        {
            if (!$request->hasHeader('Authorization')) {
                return response()->json(['error' => 'Authorization header is missing.'], 401);
            }
        }

        // Token is present or not required, continue to next request
        return $next($request);
    }
}

