<?php

namespace App\Http\Middleware;

use Closure;

class IsAmbassador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            abort(401);
        }

        if (!auth()->user()->isAmbassador && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return $next($request);
    }
}
