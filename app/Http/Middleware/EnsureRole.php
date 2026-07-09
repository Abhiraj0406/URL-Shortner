<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Checks if the logged-in user has the required role.
     *
     * Usage on routes: ->middleware('role:super_admin')
     *                  ->middleware('role:admin')
     *
     * How it works:
     *  - The route passes the required role as a string (e.g. 'admin')
     *  - We convert it to the Role enum using Role::from()
     *  - We compare it against the logged-in user's role (also a Role enum, cast by User model)
     *  - If it doesn't match → abort 403 Forbidden
     *  - If it matches → let the request continue
     *
     * @param string $role  The required role string passed from the route (e.g. 'admin')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Convert the route string (e.g. 'admin') to a Role enum (e.g. Role::Admin)
        $requiredRole = Role::from($role);

        // If the user's role doesn't match → deny access with 403
        if ($request->user()->role !== $requiredRole) {
            abort(403, 'Unauthorized. You do not have the required role.');
        }

        // Role matches → allow the request through to the controller
        return $next($request);
    }
}
