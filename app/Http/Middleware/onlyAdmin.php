<?php

namespace skyimport\Http\Middleware;

use Closure;

class onlyAdmin
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
        if (\Auth::user()->role_id != 1) return redirect()->to('/');
        
        return $next($request);
    }
}
