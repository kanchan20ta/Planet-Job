@extends('layouts.panel')
@section('title', 'Job Alerts - Planet Job Portal')

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
<h1 class="text-xl font-bold text-gray-900 mb-6">Job Alerts</h1>

<form method="POST" action="{{ route('jobseeker.job-alerts.store') }}" class="bg-white border border-gray-200 rounded-xl p-5 grid grid-cols-1 sm:grid-cols-5 gap-3 mb-6">
    @csrf
    <input type="text" name="keyword" placeholder="Keyword" class="sm:col-span-2 rounded-lg border-gray-300 text-sm">
    <select name="category_id" class="rounded-lg border-gray-300 text-sm">
        <option value="">Any Category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    <select name="frequency" class="rounded-lg border-gray-300 text-sm">
        <option value="instant">Instant</option>
        <option value="daily" selected>Daily</option>
        <option value="weekly">Weekly</option>
    </select>
    <button class="bg-brand-600 text-white font-semibold rounded-lg text-sm">Create Alert</button>
</form>

<div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100">
    @forelse ($alerts as $alert)
        <div class="p-4 flex items-center justify-between text-sm">
            <div>
                <p class="font-medium text-gray-800">{{ $alert->keyword ?: 'Any keyword' }} @if($alert->category) &middot; {{ $alert->category->name }} @endif</p>
                <p class="text-xs text-gray-400">{{ ucfirst($alert->frequency) }} alerts</p>
            </div>
            <form method="POST" action="{{ route('jobseeker.job-alerts.destroy', $alert) }}">
                @csrf @method('DELETE')
                <button class="text-xs text-red-600">Remove</button>
            </form>
        </div>
    @empty
        <p class="p-6 text-center text-gray-400 text-sm">No job alerts set up yet.</p>
    @endforelse
</div>
@endsection
