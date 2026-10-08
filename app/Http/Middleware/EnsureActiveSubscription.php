<?php

namespace App\Http\Middleware;

use App\Services\SubscriptionService;
use Closure;
use Illuminate\Http\Request;

class EnsureActiveSubscription
{
    public function __construct(protected SubscriptionService $subscriptions)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Subscriptions are only created when an admin approves a payment,
        // so an active subscription here is always an approved one.
        if (! $user || ! $this->subscriptions->activeSubscription($user)) {
            $message = 'You need an active, approved subscription to post jobs.';

            if ($request->expectsJson()) {
                abort(403, $message);
            }

            return redirect()->route('employer.subscription.index')->with('error', $message);
        }

        return $next($request);
    }
}
