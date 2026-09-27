<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function view(User $user, Company $company): bool
    {
        return true; // company profiles are public
    }

    public function update(User $user, Company $company): bool
    {
        return $user->isAdmin() || $company->user_id === $user->id;
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->isAdmin() || $company->user_id === $user->id;
    }

    public function verify(User $user, Company $company): bool
    {
        return $user->isAdmin();
    }
}
