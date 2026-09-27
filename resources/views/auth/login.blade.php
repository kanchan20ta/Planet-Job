@extends('layouts.app')
@section('title', 'Login - Planet Job Portal')

@section('content')
<div class="min-h-[calc(100vh-var(--header-height,0px))] grid grid-cols-1 lg:grid-cols-2 items-center">

    {{-- Left: Form --}}
    <div class="h-full min-h-0 flex items-center justify-center px-4 py-16 sm:py-24 bg-white overflow-y-auto">
        <div class="w-full max-w-md">
            <h1 class="text-2xl font-bold text-gray-900 mb-1">Welcome back</h1>
            <p class="text-gray-500 mb-8">Login to your Planet Job Portal account.</p>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-6">
                    {{ $errors->first() }}
                </div>
            @endif
            <div class="grid grid-cols-2 gap-3 mb-6">
                <a href="{{ route('auth.google') }}"
                    class="flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50">
                    <svg class="h-4 w-4" viewBox="0 0 48 48" aria-hidden="true">
                        <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                        <path fill="#FF3D00" d="M6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/>
                        <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                        <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                    </svg>
                    Google
                </a>
                <a href="{{ route('auth.social.redirect', 'facebook') }}"
                    class="flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="#1877F2" aria-hidden="true">
                        <path d="M22 12.06C22 6.505 17.523 2 12 2S2 6.505 2 12.06c0 5.02 3.657 9.184 8.438 9.94v-7.03H7.898v-2.91h2.54V9.845c0-2.522 1.492-3.915 3.777-3.915 1.094 0 2.238.197 2.238.197v2.475h-1.26c-1.243 0-1.63.775-1.63 1.57v1.888h2.773l-.443 2.91h-2.33V22c4.78-.756 8.437-4.92 8.437-9.94z"/>
                    </svg>
                    Facebook
                </a>
            </div>

            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="bg-white px-3 text-gray-400">or login with email</span>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 pr-11 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                        <button type="button" onclick="togglePassword()" aria-label="Show password"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-400 hover:text-gray-600">
                            <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-off-icon" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M10.584 10.587a2 2 0 002.828 2.83M9.363 5.365A9.466 9.466 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.875 3.28M6.228 6.228A10.045 10.045 0 002.458 12c1.274 4.057 5.064 7 9.542 7a9.5 9.5 0 004.606-1.174" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-gray-600">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500/30">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-brand-600 font-medium hover:text-brand-700">Forgot password?</a>
                    @endif
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-brand-600 to-brand-500 text-white font-semibold py-2.5 rounded-xl shadow-sm hover:shadow-md hover:from-brand-700 hover:to-brand-600 transition-all">
                    Login
                </button>
            </form>

            <p class="text-sm text-gray-500 mt-6 text-center">
                Don't have an account? <a href="{{ route('register') }}" class="text-brand-600 font-medium hover:text-brand-700">Register</a>
            </p>

            @if (app()->environment(['local', 'staging']))
                <div class="mt-8 text-xs text-gray-400 border-t border-gray-200 pt-4">
                    Demo accounts (password: <code class="bg-gray-100 rounded px-1 py-0.5">password</code>):
                    admin@planetjob.com · employer@planetjob.com · jobseeker@planetjob.com
                </div>
            @endif
        </div>
    </div>

    {{-- Right: Image panel --}}
<div class="hidden lg:block relative h-[550px] min-h-0 overflow-hidden">
    <img src="/images/login.png" alt="Planet Job Portal"
         class="w-full h-full object-cover object-top">
</div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeOffIcon = document.getElementById('eye-off-icon');
    const isHidden = passwordInput.type === 'password';

    passwordInput.type = isHidden ? 'text' : 'password';
    eyeIcon.classList.toggle('hidden', isHidden);
    eyeOffIcon.classList.toggle('hidden', !isHidden);
}
</script>
@endsection
