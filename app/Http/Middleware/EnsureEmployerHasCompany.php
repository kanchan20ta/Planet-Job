<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmployerHasCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::user()->company) {
            return redirect()
                ->route('employer.company.create') // adjust to your actual route name
                ->with('error', 'Please set up your company profile before managing jobs.');
        }

        return $next($request);
    }
}
