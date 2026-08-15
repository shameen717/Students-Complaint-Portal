<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Restrict a route to authenticated admin users only (RBAC).
     * Register this in app/Http/Kernel.php $middlewareAliases as 'admin' => IsAdmin::class,
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admins only.');
        }

        return $next($request);
    }
}
