<?php

namespace Muan\Acl\Middleware;

use Closure;

/**
 * Class PerrmissionMiddleware
 *
 * @package Muan\Acl
 * @subpackage Middleware
 */
class PerrmissionMiddleware
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
        if (! $request->user()->can($permission)) {
            abort(403);
        }

        return $next($request);
    }

}
