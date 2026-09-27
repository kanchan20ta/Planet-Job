<?php

namespace App\Policies;

use App\Models\JobseekerProfile;
use App\Models\User;

class JobseekerProfilePolicy
{
    /**
     * Public/company view of a jobseeker profile:
     * only if the profile owner marked it public, or viewer is the owner/admin,
     * or viewer is an employer with an active plan that includes CV access
     * (that entitlement check belongs in the controller, not the policy).
     */
    public function view(User $user, JobseekerProfile $profile): bool
    {
        return $profile->profile_public
            || $user->isAdmin()
            || $profile->user_id === $user->id;
    }

    public function update(User $user, JobseekerProfile $profile): bool
    {
        return $user->isAdmin() || $profile->user_id === $user->id;
    }
}
