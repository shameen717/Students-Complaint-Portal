<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePermissiveCsp
{
    /**
     * Forces a working Content-Security-Policy header on every response,
     * overwriting anything set earlier in the stack (by another middleware,
     * a package, or a proxy/hosting layer) that was blocking our own
     * same-origin CSS/JS/font assets from loading.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; ".
            "style-src 'self' 'unsafe-inline'; ".
            "script-src 'self' 'unsafe-inline'; ".
            "img-src 'self' data:; ".
            "font-src 'self' data:; ".
            "connect-src 'self';"
        );

        return $response;
    }
}
