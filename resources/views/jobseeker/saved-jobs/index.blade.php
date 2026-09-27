@extends('layouts.panel')
@section('title', 'Saved Jobs - Planet Job Portal')

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
<h1 class="text-xl font-bold text-gray-900 mb-6">Saved Jobs</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    @forelse ($savedJobs as $saved)
        <div class="relative">
            @include('partials.job-card', ['job' => $saved->job])
            <form method="POST" action="{{ route('jobseeker.jobs.unsave', $saved->job) }}" class="absolute top-3 right-3">
                @csrf @method('DELETE')
                <button class="text-xs text-red-600 bg-white px-2 py-1 rounded-full border">Remove</button>
            </form>
        </div>
    @empty
        <p class="text-gray-400 text-sm">No saved jobs yet.</p>
    @endforelse
</div>

<div class="mt-6">{{ $savedJobs->links() }}</div>
@endsection
