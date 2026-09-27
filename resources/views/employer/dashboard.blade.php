@extends('layouts.panel')
@section('title', 'Employer Dashboard - Planet Job Portal')

@php
$panelTitle = 'Employer Panel';
$panelLinks = [
    ['label' => 'Dashboard', 'url' => route('employer.dashboard'), 'active' => 'employer.dashboard'],
    ['label' => 'My Jobs', 'url' => route('employer.jobs.index'), 'active' => 'employer.jobs.*'],
    ['label' => 'Subscription', 'url' => route('employer.subscription.index'), 'active' => 'employer.subscription.*'],
    ['label' => 'Company Profile', 'url' => route('employer.company.edit'), 'active' => 'employer.company.*'],
];

// Chart data: pass $applicationsChartLabels / $applicationsChartData from the controller
// (e.g. last 7 days of application counts). Falls back to a flat placeholder if not supplied.
$chartLabels = $applicationsChartLabels ?? collect(range(6, 0))->map(fn ($d) => now()->subDays($d)->format('D'))->all();
$chartData = $applicationsChartData ?? array_fill(0, count($chartLabels), 0);
@endphp

@section('panel-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $company->name }}</h1>
    <a href="{{ route('employer.jobs.create') }}"
       class="inline-flex items-center gap-1.5 bg-brand-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-brand-700 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Post a Job
    </a>
</div>

{{-- Stat cards --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white border border-gray-200 rounded-xl p-5 transition-shadow hover:shadow-md">
        <div class="w-10 h-10 rounded-lg bg-brand-50 flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
        </div>
        <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $stats['total_jobs'] }}</p>
        <p class="text-sm text-gray-500 mt-1.5">Total Jobs</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-5 transition-shadow hover:shadow-md">
        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $stats['active_jobs'] }}</p>
        <p class="text-sm text-gray-500 mt-1.5">Active Jobs</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-5 transition-shadow hover:shadow-md">
        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
        </div>
        <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $stats['total_applications'] }}</p>
        <p class="text-sm text-gray-500 mt-1.5">Applications</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-5 transition-shadow hover:shadow-md">
        <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
            </svg>
        </div>
        <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $stats['pending_applications'] }}</p>
        <p class="text-sm text-gray-500 mt-1.5">Pending Review</p>
    </div>
</div>

{{-- Applications chart --}}
<div class="bg-white border border-gray-200 rounded-xl p-5 mb-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="font-semibold text-gray-900 text-sm">Applications Overview</h2>
            <p class="text-xs text-gray-400 mt-0.5">Applications received over the last 7 days</p>
        </div>
    </div>
    <div class="h-56">
        <canvas id="applicationsChart"></canvas>
    </div>
</div>

@if ($subscription)
    <div class="bg-brand-50 border border-brand-100 rounded-xl p-5 mb-8 flex items-center justify-between">
        <div>
            <p class="text-sm text-brand-800 font-semibold">{{ $subscription->plan->name }} Plan</p>
            <p class="text-xs text-brand-600">{{ $subscription->jobs_posted }} / {{ $subscription->plan->job_post_limit }} jobs posted &middot; expires {{ $subscription->ends_at->format('M d, Y') }}</p>
        </div>
        <a href="{{ route('employer.subscription.index') }}" class="text-xs font-semibold text-brand-700">Manage &rarr;</a>
    </div>
@else
    <div class="bg-amber-50 border border-amber-100 rounded-xl p-5 mb-8">
        <p class="text-sm text-amber-800">You don't have an active subscription plan yet.
            <a href="{{ route('employer.subscription.index') }}" class="font-semibold underline">Choose a plan</a> to start posting jobs.
        </p>
    </div>
@endif

{{-- Recent job postings --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="p-5 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-semibold text-gray-900 text-sm">Recent Job Postings</h2>
        <a href="{{ route('employer.jobs.index') }}" class="text-xs text-brand-600 font-semibold hover:text-brand-700">View all &rarr;</a>
    </div>
    <div class="divide-y divide-gray-100">
        @forelse ($jobs as $job)
            @php
                $statusStyles = match($job->status) {
                    'active' => 'bg-green-100 text-green-700',
                    'pending' => 'bg-amber-100 text-amber-700',
                    'expired' => 'bg-red-100 text-red-700',
                    default => 'bg-gray-100 text-gray-600',
                };
            @endphp
            <div class="p-4 flex items-center justify-between text-sm transition-colors hover:bg-gray-50">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                        <svg class="w-4.5 h-4.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-medium text-gray-800 truncate">{{ $job->title }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $job->applications_count }} {{ Str::plural('application', $job->applications_count) }}</p>
                    </div>
                </div>
                <span class="text-xs px-2.5 py-1 rounded-full font-semibold capitalize shrink-0 {{ $statusStyles }}">{{ $job->status }}</span>
            </div>
        @empty
            <p class="p-6 text-center text-gray-400 text-sm">No jobs posted yet.</p>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    (function () {
        const ctx = document.getElementById('applicationsChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Applications',
                    data: @json($chartData),
                    backgroundColor: 'rgba(37, 99, 235, 0.15)',
                    borderColor: 'rgb(37, 99, 235)',
                    borderWidth: 1.5,
                    borderRadius: 6,
                    maxBarThickness: 36,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(0,0,0,0.04)' } },
                    x: { grid: { display: false } },
                },
            },
        });
    })();
</script>
@endpush
