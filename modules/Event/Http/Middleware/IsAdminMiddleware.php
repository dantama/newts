<?php

namespace Modules\Event\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Gate::allows('event::access')) {
            return $next($request);
        }
        return abort(403);
    }
}
