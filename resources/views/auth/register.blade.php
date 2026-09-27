@extends('layouts.app')
@section('title', 'Register - Planet Job Portal')

@section('content')

{{-- Guards against a flash of both panels if [x-cloak] isn't already defined globally in layouts.app --}}
<style>[x-cloak] { display: none !important; }</style>

<div class="min-h-screen grid lg:grid-cols-2" x-data="{ role: '{{ old('role', 'jobseeker') }}', showPassword: false, showConfirm: false }">

    {{-- ============ LEFT: REGISTRATION FORM ============ --}}
    <div class="flex items-center justify-center px-4 py-14 sm:py-16">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Create your account</h1>
                <p class="text-gray-500">Join Planet Job Portal as a job seeker or company.</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8">

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-6">
                        <ul class="list-disc pl-5 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Social login --}}
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <a href="{{ route('auth.google') }}"
                       class="flex items-center justify-center gap-2 border border-gray-300 rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                        <svg class="h-4 w-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M23.49 12.27c0-.79-.07-1.54-.2-2.27H12v4.3h6.47a5.53 5.53 0 0 1-2.4 3.63v3.02h3.88c2.27-2.09 3.54-5.17 3.54-8.68z"/>
                            <path fill="#34A853" d="M12 24c3.24 0 5.95-1.07 7.94-2.9l-3.88-3.02c-1.08.72-2.46 1.15-4.06 1.15-3.13 0-5.78-2.11-6.73-4.96H1.26v3.11A12 12 0 0 0 12 24z"/>
                            <path fill="#FBBC05" d="M5.27 14.27a7.2 7.2 0 0 1 0-4.54V6.62H1.26a12 12 0 0 0 0 10.76l4.01-3.11z"/>
                            <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.44-3.44C17.94 1.19 15.24 0 12 0A12 12 0 0 0 1.26 6.62l4.01 3.11C6.22 6.87 8.87 4.75 12 4.75z"/>
                        </svg>
                        Google
                    </a>
                    <a href="{{ route('auth.facebook') }}"
                       class="flex items-center justify-center gap-2 border border-gray-300 rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="#1877F2">
                            <path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07c0 6.02 4.39 11.01 10.13 11.93v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.68.24 2.68.24v2.97h-1.51c-1.49 0-1.95.93-1.95 1.89v2.26h3.32l-.53 3.49h-2.79v8.44C19.61 23.08 24 18.09 24 12.07z"/>
                        </svg>
                        Facebook
                    </a>
                </div>

                <div class="flex items-center gap-3 mb-6">
                    <div class="h-px flex-1 bg-gray-200"></div>
                    <span class="text-xs font-medium text-gray-400 uppercase tracking-wide">or continue with email</span>
                    <div class="h-px flex-1 bg-gray-200"></div>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">I am a...</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="border border-gray-300 rounded-xl p-3 text-center text-sm font-medium text-gray-700 cursor-pointer transition-colors hover:border-gray-400 has-[:checked]:border-green-600 has-[:checked]:bg-green-600 has-[:checked]:text-white"
                                   @click="role = 'jobseeker'">
                                <input type="radio" name="role" value="jobseeker" x-model="role" class="sr-only">
                                Job Seeker
                            </label>
                            <label class="border border-gray-300 rounded-xl p-3 text-center text-sm font-medium text-gray-700 cursor-pointer transition-colors hover:border-gray-400 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-600 has-[:checked]:text-white"
                                   @click="role = 'employer'">
                                <input type="radio" name="role" value="employer" x-model="role" class="sr-only">
                                Company
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                    </div>

                    <div x-show="role === 'employer'" x-cloak>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Company Name</label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}"
                            class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                    class="block w-full rounded-xl border border-gray-300 pl-4 pr-10 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                                <button type="button"
                                        @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 focus:outline-none"
                                        :aria-label="showPassword ? 'Hide password' : 'Show password'"
                                        tabindex="-1">
                                    <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm</label>
                            <div class="relative">
                                <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                                    class="block w-full rounded-xl border border-gray-300 pl-4 pr-10 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                                <button type="button"
                                        @click="showConfirm = !showConfirm"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 focus:outline-none"
                                        :aria-label="showConfirm ? 'Hide password' : 'Show password'"
                                        tabindex="-1">
                                    <i class="fa-solid text-sm" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                       class="w-full bg-gradient-to-r from-brand-600 to-brand-500 text-white font-semibold py-2.5 rounded-xl shadow-sm hover:shadow-md hover:from-brand-700 hover:to-brand-600 transition-all">
                        Create Account
                    </button>
                </form>
            </div>

            <p class="text-sm text-gray-500 mt-6 text-center">
                Already have an account? <a href="{{ route('login') }}" class="text-brand-600 font-medium hover:text-brand-700">Login</a>
            </p>
        </div>
    </div>

    {{-- ============ RIGHT: DYNAMIC INFOGRAPHIC ============ --}}
    <div class="hidden lg:flex relative bg-gradient-to-br from-brand-900 via-brand-800 to-slate-900 text-white items-center justify-center p-14 overflow-hidden">
        {{-- Decorative texture, consistent with other dark panels on the site --}}
        <div class="absolute inset-0 opacity-[0.06] pointer-events-none"
             style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 22px 22px;"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl pointer-events-none -translate-y-1/3 translate-x-1/4"></div>

        <div class="relative w-full max-w-sm">

            {{-- Job seeker path --}}
            <template x-if="role === 'jobseeker'">
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <span class="inline-flex items-center gap-2 text-sm font-semibold text-green-300 bg-green-400/10 rounded-full px-4 py-1.5">
                    <i class="fa-solid fa-user text-xs"></i>
                    For Job Seekers
                </span>
                <h2 class="text-4xl font-extrabold mt-5 leading-tight">Your path to a new job</h2>
                <p class="inline-flex items-center gap-2 text-sm font-semibold text-green-300 bg-green-400/10 rounded-full px-4 py-1.5 mt-3">
                    <i class="fa-solid fa-circle-check text-xs"></i>
                    Free Job for Job Seekers
                </p>
                <p class="text-brand-100/70 text-sm mt-3">Four simple steps from search to signed offer.</p>

                <div class="mt-10 space-y-0">
                    @php
                        $seekerSteps = [
                            ['icon' => 'fa-magnifying-glass', 'title' => 'Search Jobs', 'desc' => 'Browse thousands of listings across every industry.'],
                            ['icon' => 'fa-file-arrow-up', 'title' => 'Apply Online', 'desc' => 'Submit your application in just a few clicks.'],
                            ['icon' => 'fa-comments', 'title' => 'Interview', 'desc' => 'Connect with employers and showcase your skills.'],
                            ['icon' => 'fa-handshake', 'title' => 'Get Hired', 'desc' => 'Accept your offer and start your new role.'],
                        ];
                    @endphp
                    @foreach($seekerSteps as $i => $step)
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-11 h-11 shrink-0 rounded-full bg-white/10 border border-white/15 flex items-center justify-center">
                                    <i class="fa-solid {{ $step['icon'] }} text-green-300 text-sm"></i>
                                </div>
                                @if(!$loop->last)
                                    <div class="w-px flex-1 bg-white/15 my-1"></div>
                                @endif
                            </div>
                            <div class="pb-8">
                                <p class="font-semibold">{{ $step['title'] }}</p>
                                <p class="text-sm text-brand-100/60 mt-1 leading-relaxed">{{ $step['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            </template>

            {{-- Employer path --}}
            <template x-if="role === 'employer'">
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <span class="inline-flex items-center gap-2 text-base font-semibold text-orange-300 bg-orange-400/10 rounded-full px-5 py-2">
                    <i class="fa-solid fa-building text-sm"></i>
                    For Employers &middot; For Company
                </span>
                <h2 class="text-4xl font-extrabold mt-5 leading-tight">Your path to your next hire</h2>
                <p class="text-brand-100/70 text-sm mt-3">From company profile to signed offer letter.</p>

                <div class="mt-10 space-y-0">
                    @php
                        $employerSteps = [
                            ['icon' => 'fa-building', 'title' => 'Create Your Profile', 'desc' => 'Set up your company page in minutes.'],
                            ['icon' => 'fa-bullhorn', 'title' => 'Post a Job', 'desc' => 'Publish an opening and reach qualified candidates.'],
                            ['icon' => 'fa-users', 'title' => 'Review Applicants', 'desc' => 'Screen resumes and shortlist top talent.'],
                            ['icon' => 'fa-handshake', 'title' => 'Hire Staff', 'desc' => 'Extend an offer and grow your team.'],
                        ];
                    @endphp
                    @foreach($employerSteps as $i => $step)
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 shrink-0 rounded-full bg-white/10 border border-white/15 flex items-center justify-center">
                                    <i class="fa-solid {{ $step['icon'] }} text-orange-300 text-2xl"></i>
                                </div>
                                @if(!$loop->last)
                                    <div class="w-px flex-1 bg-white/15 my-1"></div>
                                @endif
                            </div>
                            <div class="pb-8">
                                <p class="font-semibold text-lg">{{ $step['title'] }}</p>
                                <p class="text-sm text-brand-100/60 mt-1 leading-relaxed">{{ $step['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            </template>
        </div>
    </div>
</div>
@endsection
