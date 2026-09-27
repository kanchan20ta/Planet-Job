<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleGoogleCallback()
    {
        return $this->loginSocialUser(Socialite::driver('google')->user());
    }

    public function handleFacebookCallback()
    {
        return $this->loginSocialUser(Socialite::driver('facebook')->user());
    }

    /**
     * ASSUMPTIONS — please confirm against your actual `users` schema:
     * - There's a `role` column, and new social sign-ups should default to 'jobseeker'
     *   (matching the public "Apply Now" flow, since that's the role Socialite login
     *   would typically serve). Admins/employers presumably don't sign in via Google/Facebook.
     * - Matching an existing account by email is acceptable (i.e. if someone already
     *   registered with email/password and then uses "Sign in with Google" using the
     *   same email, this links them to the same account rather than erroring).
     * - `password` is nullable-safe with a random value since the user never sets one
     *   for social-only accounts; adjust if your `users` table requires something else.
     */
    private function loginSocialUser($socialUser)
    {
        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'password' => bcrypt(Str::random(24)),
                'role' => 'jobseeker',
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user, true);

        return redirect()->intended(route('jobseeker.dashboard'));
    }
}
