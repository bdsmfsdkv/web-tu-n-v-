<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Prevent browser from serving stale HTML when user hits Back.
 * Only affects HTML responses; static assets (images, CSS, JS) are unaffected.
 */
class NoCacheHtml
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only apply to HTML page responses, not API/AJAX/asset requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return $response;
        }

        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }
}
