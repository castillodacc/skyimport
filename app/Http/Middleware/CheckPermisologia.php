<?php

namespace skyimport\Http\Middleware;

use Closure;
use Auth;

class CheckPermisologia
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $rol = 1)
    {
        if (Auth::user()->rol_id == 1) {
            return $next($request);
        }

        return abort(401, 'Unauthorized.');
    }
}
