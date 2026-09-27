<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restricts a route (or route group) to one or more user roles.
 *
 * Usage in routes:
 *   Route::middleware(['auth', 'role:admin'])->group(...)
 *   Route::middleware(['auth', 'role:employer,admin'])->group(...)
 */
class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401, 'Unauthenticated.');
        }

        if ($user->status !== 'active') {
            abort(403, 'Your account is not active. Please contact support.');
        }

        if (! in_array($user->role, $roles, true)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
