<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AffiliateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('ref')) {
            $ref = $request->input('ref');
            // Check if user exists
            $user = \App\Models\User::where('username', $ref)->first();
            if ($user) {
                // Store in cookie for 30 days
                return $next($request)->cookie('affiliate_ref', $user->id, 60 * 24 * 30);
            }
        }
        
        return $next($request);
    }
}
