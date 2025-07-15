<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // auth check + role check
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'petugas'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
    
}
