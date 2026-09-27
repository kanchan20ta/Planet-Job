<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    /**
     * Activate a plan for an employer. In production, call this only after
     * a successful Payment webhook/callback confirms the transaction.
     */
    public function subscribe(User $employer, SubscriptionPlan $plan): Subscription
    {
        return DB::transaction(function () use ($employer, $plan) {
            // Expire any currently active subscription before starting the new one.
            $employer->subscriptions()->where('status', 'active')->update(['status' => 'expired']);

            return Subscription::create([
                'user_id' => $employer->id,
                'plan_id' => $plan->id,
                'starts_at' => now(),
                'ends_at' => now()->addDays($plan->duration_days),
                'status' => 'active',
            ]);
        });
    }

    public function activeSubscription(User $employer): ?Subscription
    {
        return $employer->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>=', now())
            ->latest('starts_at')
            ->first();
    }

    /** Can this employer post another job right now under their current plan? */
    public function canPostJob(User $employer): bool
    {
        $subscription = $this->activeSubscription($employer);

        if (! $subscription) {
            return false; // no active plan at all — must subscribe first (even Free plan)
        }

        return $subscription->jobs_posted < $subscription->plan->job_post_limit;
    }

    public function canFeatureJob(User $employer): bool
    {
        $subscription = $this->activeSubscription($employer);

        return $subscription && $subscription->featured_jobs_used < $subscription->plan->featured_job_limit;
    }

    public function recordJobPosted(Subscription $subscription, bool $featured = false): void
    {
        $subscription->increment('jobs_posted');

        if ($featured) {
            $subscription->increment('featured_jobs_used');
        }
    }
}
