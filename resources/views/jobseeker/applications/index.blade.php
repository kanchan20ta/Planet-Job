@extends('layouts.panel')
@section('title', 'My Applications - Planet Job Portal')

@php
$panelTitle = 'My Account';
$panelLinks = [
    ['label' => 'Dashboard', 'url' => route('jobseeker.dashboard'), 'active' => 'jobseeker.dashboard'],
    ['label' => 'My Profile', 'url' => route('jobseeker.profile.edit'), 'active' => 'jobseeker.profile.*'],
    ['label' => 'My Applications', 'url' => route('jobseeker.applications.index'), 'active' => 'jobseeker.applications.*'],
    ['label' => 'Saved Jobs', 'url' => route('jobseeker.saved-jobs.index'), 'active' => 'jobseeker.saved-jobs.*'],
    ['label' => 'Job Alerts', 'url' => route('jobseeker.job-alerts.index'), 'active' => 'jobseeker.job-alerts.*'],
];
@endphp

@section('panel-content')
<h1 class="text-xl font-bold text-gray-900 mb-6">My Applications</h1>

<div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100">
    @forelse ($applications as $app)
        <div class="p-5 flex items-center justify-between">
            <div>
                <a href="{{ route('jobs.show', $app->job) }}" class="font-semibold text-gray-900 hover:text-brand-600">{{ $app->job->title }}</a>
                <p class="text-sm text-gray-500">{{ $app->job->company->name }} &middot; Applied {{ $app->applied_at->diffForHumans() }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 capitalize">{{ $app->status }}</span>
                @if ($app->status === 'pending')
                    <form method="POST" action="{{ route('jobseeker.applications.withdraw', $app) }}" onsubmit="return confirm('Withdraw this application?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-600 font-medium">Withdraw</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="p-8 text-center text-gray-400 text-sm">You haven't applied to any jobs yet.</p>
    @endforelse
</div>

<div class="mt-6">{{ $applications->links() }}</div>
@endsection
