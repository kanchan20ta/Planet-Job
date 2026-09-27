@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center bg-[#F7F5EF] px-4 py-16">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#0F2A4A]">
                <svg class="h-6 w-6 text-[#C9A54B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 9h10.5a2.25 2.25 0 002.25-2.25v-6a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </div>
            <h1 class="text-2xl font-semibold text-[#0F2A4A]">Reset your password</h1>
            <p class="mt-2 text-sm text-slate-500">
                Enter the email address on your account and we'll send you a link to reset your password.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl shadow-[#0F2A4A]/5 border border-slate-100 overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-[#0F2A4A] via-[#163862] to-[#C9A54B]"></div>

            <div class="p-8">
                @if (session('status'))
                    <div class="mb-6 flex items-start gap-3 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3">
                        <svg class="h-5 w-5 text-emerald-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-emerald-800">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-[#0F2A4A] mb-1.5">
                            Email address
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus
                                placeholder="you@example.com"
                                class="w-full rounded-lg border @error('email') border-red-400 @else border-slate-200 @enderror bg-slate-50/50 pl-11 pr-4 py-3 text-sm text-[#0F2A4A] placeholder:text-slate-400 transition focus:border-[#C9A54B] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#C9A54B]/15"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="group relative w-full overflow-hidden rounded-lg bg-[#0F2A4A] px-4 py-3 text-sm font-semibold text-white transition-all hover:bg-[#163862] focus:outline-none focus:ring-4 focus:ring-[#0F2A4A]/20"
                    >
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            Send password reset link
                            <svg class="h-4 w-4 text-[#C9A54B] transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <p class="mt-6 text-center text-sm text-slate-500">
            Remembered your password?
            <a href="{{ route('login') }}" class="font-medium text-[#0F2A4A] hover:text-[#C9A54B] transition-colors">
                Back to sign in
            </a>
        </p>
    </div>
</div>
@endsection
