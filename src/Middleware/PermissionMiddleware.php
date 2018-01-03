<?php

namespace Muan\Acl\Middleware;

use Closure;

/**
 * Class PermissionMiddleware
 *
 * @package Muan\Acl\Middleware
 */
class PermissionMiddleware
{
    
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure  $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (! $user = $request->user()) {
            abort(403, "Access denied!");
        }

        if (! $user->can($permission)) {
            abort(403, "Access denied!");
        }

        return $next($request);
    }

}
