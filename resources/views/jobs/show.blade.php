@extends('layouts.app')
@section('title', $job->title . ' - Planet Job Portal')

@section('content')
@php
    $daysLeft = $job->deadline ? now()->startOfDay()->diffInDays($job->deadline->startOfDay(), false) : null;
    $isClosingSoon = $daysLeft !== null && $daysLeft >= 0 && $daysLeft <= 5;
    $isExpired = $daysLeft !== null && $daysLeft < 0;
@endphp

<div class="bg-slate-50 min-h-screen">
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to jobs
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2">

            {{-- ===== Header ===== --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-4 min-w-0">
                        <div class="w-20 h-20 rounded-2xl shrink-0 flex items-center justify-center
                            @if ($job->company->logo)
                                bg-white border border-slate-200 shadow-md p-2.5
                            @else
                                bg-brand-600 text-white font-bold text-2xl
                            @endif">
                            @if ($job->company->logo)
                                <img src="{{ asset('storage/' . $job->company->logo) }}"
                                     alt="{{ $job->company->name }} logo"
                                     class="h-full w-full object-contain">
                            @else
                                {{ substr($job->company->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="min-w-0 pt-0.5">
                            <h1 class="text-[26px] sm:text-3xl font-bold text-slate-900 leading-tight tracking-tight">{{ $job->title }}</h1>
                            <a href="{{ route('companies.show', $job->company) }}" class="inline-flex items-center gap-1.5 text-[15px] text-slate-600 font-medium hover:text-brand-600 mt-1.5 transition-colors">
                                {{ $job->company->name }}
                            </a>
                        </div>
                    </div>
                    <span class="shrink-0 inline-flex items-center rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-1.5">
                        {{ $job->jobType->name }}
                    </span>
                </div>

                <div class="flex flex-wrap items-center gap-x-5 gap-y-2 mt-5 pt-5 border-t border-slate-100 text-sm text-slate-600">
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $job->is_remote ? 'Remote' : $job->city }}
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6-4a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        {{ $job->vacancy }} {{ Str::plural('opening', $job->vacancy) }}
                    </span>
                </div>
            </div>

            {{-- ===== Key facts: salary / experience / deadline ===== --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">

                <div class="sm:col-span-1 rounded-2xl bg-emerald-700 text-white p-5 flex flex-col justify-between">
                    <span class="text-xs font-medium text-emerald-100">Salary</span>
                    @if ($job->salary_min)
                        <p class="text-2xl font-bold leading-tight mt-2">
                            Rs. {{ number_format($job->salary_min / 1000, 0) }}k&ndash;{{ number_format($job->salary_max / 1000, 0) }}k
                        </p>
                        <p class="text-xs text-emerald-200 mt-1">per {{ $job->salary_type }}</p>
                    @else
                        <p class="text-lg font-semibold leading-tight mt-2">Negotiable</p>
                        <p class="text-xs text-emerald-200 mt-1">discussed at interview</p>
                    @endif
                </div>

                <div class="rounded-2xl bg-white border border-slate-200 p-5 flex flex-col justify-between">
                    <span class="text-xs font-medium text-slate-500">Experience</span>
                    <p class="text-lg font-bold text-slate-900 mt-2 leading-tight">{{ ucfirst($job->experience_level ?? 'Any level') }}</p>
                    <p class="text-xs text-slate-400 mt-1">required for this role</p>
                </div>

                <div class="rounded-2xl border p-5 flex flex-col justify-between
                    @if ($isExpired) bg-slate-100 border-slate-200
                    @elseif ($isClosingSoon) bg-rose-50 border-rose-200
                    @else bg-white border-slate-200 @endif">
                    <span class="text-xs font-medium @if($isClosingSoon && !$isExpired) text-rose-600 @else text-slate-500 @endif">Application Deadline</span>
                    <p class="text-lg font-bold mt-2 leading-tight @if($isClosingSoon && !$isExpired) text-rose-700 @else text-slate-900 @endif">
                        {{ $job->deadline?->format('M d, Y') ?? 'Open' }}
                    </p>
                    <p class="text-xs mt-1 @if($isClosingSoon && !$isExpired) text-rose-500 @else text-slate-400 @endif">
                        @if ($isExpired) Closed
                        @elseif ($daysLeft === 0) Closes today
                        @elseif ($daysLeft === 1) 1 day left
                        @elseif ($daysLeft !== null) {{ $daysLeft }} days left
                        @else Rolling basis @endif
                    </p>
                </div>
            </div>

            {{-- ===== Description & details ===== --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 mt-4">
                <div>
                    <h2 class="font-bold text-slate-900 text-lg mb-3">Job description</h2>
                    <p class="text-[15px] text-slate-600 leading-relaxed whitespace-pre-line max-w-[68ch]">{{ $job->description }}</p>
                </div>

                @if ($job->responsibilities)
                <div class="mt-8 pt-8 border-t border-slate-100">
                    <h2 class="font-bold text-slate-900 text-lg mb-3">Responsibilities</h2>
                    <ul class="space-y-2.5">
                        @foreach (preg_split('/\r\n|\r|\n/', trim($job->responsibilities)) as $line)
                            @continue(trim($line) === '')
                            <li class="flex items-start gap-3 text-[15px] text-slate-600 leading-relaxed">
                                <svg class="w-4 h-4 text-brand-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>{{ trim($line) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if ($job->requirements)
                <div class="mt-8 pt-8 border-t border-slate-100">
                    <h2 class="font-bold text-slate-900 text-lg mb-3">Requirements</h2>
                    <ul class="space-y-2.5">
                        @foreach (preg_split('/\r\n|\r|\n/', trim($job->requirements)) as $line)
                            @continue(trim($line) === '')
                            <li class="flex items-start gap-3 text-[15px] text-slate-600 leading-relaxed">
                                <svg class="w-4 h-4 text-brand-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>{{ trim($line) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if ($job->benefits)
                <div class="mt-8 pt-8 border-t border-slate-100">
                    <h2 class="font-bold text-slate-900 text-lg mb-3">Benefits</h2>
                    <ul class="space-y-2.5">
                        @foreach (preg_split('/\r\n|\r|\n/', trim($job->benefits)) as $line)
                            @continue(trim($line) === '')
                            <li class="flex items-start gap-3 text-[15px] text-slate-600 leading-relaxed">
                                <svg class="w-4 h-4 text-brand-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>{{ trim($line) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if ($job->skills->count())
                <div class="mt-8 pt-8 border-t border-slate-100">
                    <h2 class="font-bold text-slate-900 text-lg mb-3">Skills</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($job->skills as $skill)
                            <span class="inline-flex items-center rounded-lg bg-slate-100 text-slate-700 text-sm font-medium px-3 py-1.5">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- ===== Related jobs ===== --}}
            @if ($relatedJobs->count())
            <div class="mt-10">
                <div class="mb-4">
                    <h2 class="font-bold text-slate-900 text-lg">Related jobs</h2>
                    <p class="text-sm text-slate-500 mt-0.5">More {{ $job->category->name }} roles you might like</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @foreach ($relatedJobs as $related)
                        @include('partials.job-card', ['job' => $related])
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- ===== Sidebar: Apply ===== --}}
        <div class="lg:col-span-1">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sticky top-20">

                <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
                    <div>
                        <p class="text-xs text-slate-500">Application deadline</p>
                        <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $job->deadline?->format('M d, Y') ?? 'Open' }}</p>
                    </div>
                    @if ($isClosingSoon && !$isExpired)
                        <span class="text-xs font-semibold text-rose-600 bg-rose-50 rounded-full px-2.5 py-1">
                            {{ $daysLeft === 0 ? 'Today' : $daysLeft . 'd left' }}
                        </span>
                    @endif
                </div>

                @auth
                    @if (auth()->user()->isJobseeker())
                        @if ($alreadyApplied)
                            <button disabled class="w-full bg-slate-100 text-slate-400 font-semibold py-3 rounded-xl cursor-not-allowed">
                                Already applied
                            </button>
                        @else
                            <form method="POST" action="{{ route('jobseeker.jobs.apply', $job) }}" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Cover letter (optional)</label>
                                    <textarea name="cover_letter" rows="4" placeholder="Tell them why you're a great fit..."
                                              class="w-full text-sm rounded-xl border-slate-300 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none"></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Resume</label>
                                    <input type="file" name="resume"
                                           class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                                </div>
                                <button type="submit" class="w-full bg-brand-600 text-white font-semibold py-3 rounded-xl hover:bg-brand-700 transition-colors shadow-sm">
                                    Apply now
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('jobseeker.jobs.save', $job) }}" class="mt-3">
                            @csrf
                            <button class="w-full border border-slate-300 text-slate-700 font-medium py-3 rounded-xl hover:bg-slate-50 hover:border-slate-400 transition-colors">
                                Save job
                            </button>
                        </form>
                    @else
                        <p class="text-sm text-slate-500">Only job seekers can apply for jobs.</p>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block text-center w-full bg-brand-600 text-white font-semibold py-3 rounded-xl hover:bg-brand-700 transition-colors shadow-sm">
                        Login to apply
                    </a>
                @endauth

                <div class="mt-5 pt-5 border-t border-slate-100 space-y-2 text-sm text-slate-500">
                    <p class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7h-3V5a2 2 0 00-2-2H9a2 2 0 00-2 2v2H4a1 1 0 00-1 1v10a2 2 0 002 2h14a2 2 0 002-2V8a1 1 0 00-1-1zM9 5h6v2H9V5z"/></svg>
                        {{ $job->jobType->name }}
                    </p>
                    <p class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6-4a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        {{ $job->vacancy }} {{ Str::plural('vacancy', $job->vacancy) }} open
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
