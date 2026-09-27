<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogPolicy
{
    public function view(User $user, Blog $blog): bool
    {
        return $blog->status === 'published' || $user->isAdmin() || $blog->user_id === $user->id;
    }

    /** Only admin staff write blog content on this platform. */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Blog $blog): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Blog $blog): bool
    {
        return $user->isAdmin();
    }
}
