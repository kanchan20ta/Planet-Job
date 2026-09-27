@extends('layouts.panel')
@section('title', 'My Jobs - Planet Job Portal')

@php
$panelTitle = 'Employer Panel';
$panelLinks = [
    ['label' => 'Dashboard', 'url' => route('employer.dashboard'), 'active' => 'employer.dashboard'],
    ['label' => 'My Jobs', 'url' => route('employer.jobs.index'), 'active' => 'employer.jobs.*'],
    ['label' => 'Subscription', 'url' => route('employer.subscription.index'), 'active' => 'employer.subscription.*'],
    ['label' => 'Company Profile', 'url' => route('employer.company.edit'), 'active' => 'employer.company.*'],
];

// Prefer stats passed from the controller (accurate across all pages, not just this one).
// Falls back to the current page's collection if they aren't supplied.
$totalJobs = $totalJobs ?? $jobs->total();
$activeJobs = $activeJobsCount ?? $jobs->getCollection()->where('status', 'active')->count();
$totalApplications = $totalApplications ?? $jobs->getCollection()->sum('applications_count');
@endphp

@section('panel-content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">My Jobs</h1>
        <p class="text-sm text-gray-500 mt-1">Manage your listings and track applicant activity.</p>
    </div>
    <a href="{{ route('employer.jobs.create') }}"
       class="inline-flex items-center gap-1.5 bg-brand-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-brand-700 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Post a Job
    </a>
</div>

{{-- Summary stats --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white border border-gray-200 rounded-xl p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-lg bg-brand-50 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $totalJobs }}</p>
            <p class="text-xs text-gray-500 mt-1.5">Total jobs posted</p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $activeJobs }}</p>
            <p class="text-xs text-gray-500 mt-1.5">Currently active</p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $totalApplications }}</p>
            <p class="text-xs text-gray-500 mt-1.5">Total applications</p>
        </div>
    </div>
</div>

{{-- Job cards --}}
@if ($jobs->count())
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @foreach ($jobs as $job)
            @php
                $statusStyles = match($job->status) {
                    'active' => 'bg-green-100 text-green-700',
                    'pending' => 'bg-amber-100 text-amber-700',
                    'expired' => 'bg-red-100 text-red-700',
                    default => 'bg-gray-100 text-gray-600',
                };
            @endphp
            <div class="bg-white border border-gray-200 rounded-xl p-5 transition-all duration-200 hover:shadow-md hover:border-gray-300">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h3 class="font-semibold text-gray-900 text-sm truncate">{{ $job->title }}</h3>
                        <p class="text-xs text-gray-400 mt-1">posted {{ $job->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="shrink-0 px-2.5 py-1 rounded-full text-[11px] font-semibold capitalize {{ $statusStyles }}">
                        {{ $job->status }}
                    </span>
                </div>

                <div class="flex items-center gap-1.5 text-sm text-gray-600 mt-4">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>{{ $job->applications_count }} {{ Str::plural('application', $job->applications_count) }}</span>
                </div>

                <div class="h-px bg-gray-100 my-4"></div>

                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('employer.jobs.applications', $job) }}" class="text-brand-600 font-medium hover:text-brand-700">Applicants</a>
                        <a href="{{ route('employer.jobs.edit', $job) }}" class="text-gray-500 font-medium hover:text-gray-700">Edit</a>
                        @if (in_array($job->status, ['expired', 'closed']))
                            <form method="POST" action="{{ route('employer.jobs.renew', $job) }}">
                                @csrf
                                <button class="text-brand-600 font-medium hover:text-brand-700">Renew (+30 days)</button>
                            </form>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('employer.jobs.destroy', $job) }}" onsubmit="return confirm('Delete this job?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 font-medium hover:text-red-600">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
        <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" />
        </svg>
        <p class="text-gray-400 text-sm">You haven't posted any jobs yet.</p>
        <a href="{{ route('employer.jobs.create') }}" class="inline-block mt-4 text-brand-600 font-semibold text-sm hover:text-brand-700">Post your first job &rarr;</a>
    </div>
@endif

<div class="mt-6">{{ $jobs->links() }}</div>
@endsection
