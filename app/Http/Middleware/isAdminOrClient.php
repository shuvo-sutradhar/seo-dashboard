<?php

namespace App\Http\Middleware;

use Closure;


class isAdminOrClient
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
        if ($request->user() && !$request->user()->isAdminOrClient())
        {
            return redirect()->route('unauthorized');
        }
        
        return $next($request);
    }
}
