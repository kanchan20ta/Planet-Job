<?php

namespace App\Policies;

use App\Models\SubscriptionPlan;
use App\Models\User;

class SubscriptionPlanPolicy
{
    /** Anyone can browse pricing plans. */
    public function view(User $user, SubscriptionPlan $plan): bool
    {
        return true;
    }

    /** Only admin manages the pricing catalog. */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, SubscriptionPlan $plan): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, SubscriptionPlan $plan): bool
    {
        return $user->isAdmin();
    }
}
