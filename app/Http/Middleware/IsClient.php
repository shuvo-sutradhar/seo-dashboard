<?php

namespace App\Http\Middleware;

use Closure;

use Response;

class IsClient
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
        if ($request->user() && !$request->user()->isClient())
        {
            return new Response(view('unauthorized'));
        }
        
        return $next($request);
    
    }
}
