<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class MemberValidation extends Middleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if ($request->cookie(config('auth.cookie'))) {
            new Interceptor\AuthorizationInterceptor($request);
            Auth::user()?->load('meta');
        }

        return $next($request);
    }
}
