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
    public function handle($request, Closure $next, $module = null, $action = null)
    {
        return $next($request);

        // return abort(401, 'Unauthorized.');
    }
}
