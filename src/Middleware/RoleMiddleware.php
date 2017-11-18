<?php

namespace Muan\Acl\Middleware;

use Closure;

/**
 * Class RoleMiddleware
 *
 * @package Muan\Acl
 * @subpackage Middleware
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure  $next
     * @param string $role
     * @param string|null $[name] [<description>]
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if (! $request->user()->hasRole($role)) {
            abort(403);
        }

        if ($permission !== null && !$request->user()->can($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
