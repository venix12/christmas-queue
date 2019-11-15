<?php

namespace App\Http\Middleware;

use Auth;
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
        if(Auth::check() && Auth::user()->isAmbassador)
        {
            return $next($request);
        }

        return redirect('/');
    }
}
