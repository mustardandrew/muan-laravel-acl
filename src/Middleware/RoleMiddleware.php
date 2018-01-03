<?php

namespace Muan\Acl\Middleware;

use Closure;

/**
 * Class RoleMiddleware
 *
 * @package Muan\Acl\Middleware
 */
class RoleMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure  $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (! $user = $request->user()) {
            abort(403, "Access denied!");
        }

        if (! $user->hasRole($role)) {
            abort(403, "Access denied!");
        }

        return $next($request);
    }
    
}
