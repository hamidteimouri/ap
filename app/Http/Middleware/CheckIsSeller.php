<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->isSeller()) {
            return response()->json([
                'error' => 'Access denied'
            ], 403);
        }
        return $next($request);
    }
}
