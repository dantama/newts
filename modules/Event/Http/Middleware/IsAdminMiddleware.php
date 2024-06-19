<?php

namespace Modules\Event\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->flattenManagerials()->count()) {
            return $next($request);
        }

        return abort(403);
    }
}