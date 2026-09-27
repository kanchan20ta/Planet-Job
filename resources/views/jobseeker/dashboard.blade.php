@extends('layouts.panel')
@section('title', 'Jobseeker Dashboard - Planet Job Portal')

@php
$panelTitle = 'My Account';
$panelLinks = [
    ['label' => 'Dashboard', 'url' => route('jobseeker.dashboard'), 'active' => 'jobseeker.dashboard'],
    ['label' => 'My Profile', 'url' => route('jobseeker.profile.edit'), 'active' => 'jobseeker.profile.*'],
    ['label' => 'Build Your CV', 'url' => route('jobseeker.cv.build'), 'active' => 'jobseeker.cv.*'],
    ['label' => 'My Applications', 'url' => route('jobseeker.applications.index'), 'active' => 'jobseeker.applications.*'],
    ['label' => 'Saved Jobs', 'url' => route('jobseeker.saved-jobs.index'), 'active' => 'jobseeker.saved-jobs.*'],
    ['label' => 'Job Alerts', 'url' => route('jobseeker.job-alerts.index'), 'active' => 'jobseeker.job-alerts.*'],
];

// Same status-color convention used on the job details page, applied to application statuses.
$statusStyle = function ($status) {
    return match(strtolower($status ?? '')) {
        'shortlisted' => 'bg-blue-50 text-blue-700 border-blue-100',
        'interview', 'interviewing' => 'bg-purple-50 text-purple-700 border-purple-100',
        'hired', 'accepted', 'offered' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
        'rejected', 'declined' => 'bg-red-50 text-red-700 border-red-100',
        default => 'bg-amber-50 text-amber-700 border-amber-100', // pending / applied / submitted
    };
};
@endphp

@section('panel-content')

<div class="mb-7">
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h1>
    <p class="text-sm text-gray-500 mt-1">Here's where things stand with your job search.</p>
</div>

{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 flex items-start gap-3.5">
        <div class="w-11 h-11 shrink-0 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
            <i class="fa-solid fa-paper-plane"></i>
        </div>
        <div class="min-w-0">
            <p class="text-2xl font-bold text-gray-900 leading-tight">{{ $stats['applications'] }}</p>
            <p class="text-sm text-gray-500">Applications sent</p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 flex items-start gap-3.5">
        <div class="w-11 h-11 shrink-0 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <i class="fa-solid fa-star"></i>
        </div>
        <div class="min-w-0">
            <p class="text-2xl font-bold text-gray-900 leading-tight">{{ $stats['shortlisted'] }}</p>
            <p class="text-sm text-gray-500">Shortlisted</p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 flex items-start gap-3.5">
        <div class="w-11 h-11 shrink-0 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
            <i class="fa-solid fa-bookmark"></i>
        </div>
        <div class="min-w-0">
            <p class="text-2xl font-bold text-gray-900 leading-tight">{{ $stats['saved'] }}</p>
            <p class="text-sm text-gray-500">Saved jobs</p>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Recent Applications --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 sm:p-6">
        <div class="flex items-center justify-between mb-1">
            <h2 class="font-semibold text-gray-900">Recent applications</h2>
            <a href="{{ route('jobseeker.applications.index') }}" class="text-xs font-medium text-brand-600 hover:text-brand-700">View all</a>
        </div>
        <p class="text-xs text-gray-400 mb-4">The latest roles you've applied to.</p>

        <div class="divide-y divide-gray-100">
            @forelse ($recentApplications as $app)
                <a href="{{ route('jobs.show', $app->job) }}" class="flex items-center gap-3 py-3 first:pt-0 last:pb-0 group">
                    <div class="w-9 h-9 shrink-0 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center overflow-hidden">
                        @if($app->job->company?->logo)
                            <img src="{{ $app->job->company->logo_url }}" alt="{{ $app->job->company->name }}" class="w-full h-full object-contain">
                        @else
                            <span class="text-sm font-bold text-brand-700">{{ substr($app->job->company->name ?? $app->job->title, 0, 1) }}</span>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-800 truncate group-hover:text-brand-600 transition-colors">{{ $app->job->title }}</p>
                        <p class="text-xs text-gray-400 truncate">
                            {{ $app->job->company->name ?? 'Confidential company' }}
                            @if(!empty($app->created_at))
                                &middot; {{ optional($app->created_at)->diffForHumans() }}
                            @endif
                        </p>
                    </div>

                    <span class="shrink-0 inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-full border capitalize {{ $statusStyle($app->status) }}">
                        {{ $app->status }}
                    </span>
                </a>
            @empty
                <div class="text-center py-8">
                    <div class="w-11 h-11 mx-auto rounded-full bg-gray-50 text-gray-300 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                    <p class="text-sm text-gray-400">No applications yet.</p>
                    <a href="{{ route('jobs.index') }}" class="text-sm text-brand-600 font-medium hover:text-brand-700">Browse jobs</a>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Saved Jobs --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 sm:p-6">
        <div class="flex items-center justify-between mb-1">
            <h2 class="font-semibold text-gray-900">Saved jobs</h2>
            <a href="{{ route('jobseeker.saved-jobs.index') }}" class="text-xs font-medium text-brand-600 hover:text-brand-700">View all</a>
        </div>
        <p class="text-xs text-gray-400 mb-4">Roles you've bookmarked for later.</p>

        <div class="divide-y divide-gray-100">
            @forelse ($savedJobs as $saved)
                <div class="flex items-center gap-3 py-3 first:pt-0 last:pb-0">
                    <div class="w-9 h-9 shrink-0 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center overflow-hidden">
                        @if($saved->job->company?->logo)
                            <img src="{{ $saved->job->company->logo_url }}" alt="{{ $saved->job->company->name }}" class="w-full h-full object-contain">
                        @else
                            <span class="text-sm font-bold text-brand-700">{{ substr($saved->job->company->name ?? $saved->job->title, 0, 1) }}</span>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $saved->job->title }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $saved->job->company->name ?? 'Confidential company' }}</p>
                    </div>

                    <a href="{{ route('jobs.show', $saved->job) }}"
                       class="shrink-0 inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 border border-brand-100 hover:border-brand-200 bg-brand-50/60 hover:bg-brand-50 rounded-lg px-2.5 py-1.5 transition-colors">
                        View <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="w-11 h-11 mx-auto rounded-full bg-gray-50 text-gray-300 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-bookmark"></i>
                    </div>
                    <p class="text-sm text-gray-400">No saved jobs yet.</p>
                    <a href="{{ route('jobs.index') }}" class="text-sm text-brand-600 font-medium hover:text-brand-700">Browse jobs</a>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
