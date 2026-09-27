<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Standard Laravel Breeze/Fortify-style guest redirect, updated to send
 * an already-authenticated user to their role-specific dashboard instead
 * of a single hardcoded /dashboard route.
 */
class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::homeFor(Auth::guard($guard)->user()));
            }
        }

        return $next($request);
    }
}
