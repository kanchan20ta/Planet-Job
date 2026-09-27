@extends('layouts.panel')
@section('title', 'Applicants - Planet Job Portal')

@php
$panelTitle = 'Employer Panel';
$panelLinks = [
    ['label' => 'Dashboard', 'url' => route('employer.dashboard'), 'active' => 'employer.dashboard'],
    ['label' => 'My Jobs', 'url' => route('employer.jobs.index'), 'active' => 'employer.jobs.*'],
    ['label' => 'Subscription', 'url' => route('employer.subscription.index'), 'active' => 'employer.subscription.*'],
    ['label' => 'Company Profile', 'url' => route('employer.company.edit'), 'active' => 'employer.company.*'],
];
@endphp

@section('panel-content')
<h1 class="text-xl font-bold text-gray-900 mb-1">Applicants</h1>
<p class="text-sm text-gray-500 mb-6">{{ $job->title }}</p>

<div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100">
    @forelse ($applications as $app)
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-semibold text-gray-800">{{ $app->applicant->name }}</p>
                    <p class="text-xs text-gray-400">{{ $app->applicant->email }} &middot; applied {{ $app->applied_at->diffForHumans() }}</p>
                </div>
                <form method="POST" action="{{ route('employer.applications.update-status', $app) }}" class="flex items-center gap-2">
                    @csrf @method('PUT')
                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-300">
                        @foreach (['pending','reviewed','shortlisted','interview','rejected','hired'] as $status)
                            <option value="{{ $status }}" @selected($app->status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            @if ($app->cover_letter)
                <p class="text-sm text-gray-600 mt-3 bg-gray-50 rounded-lg p-3">{{ $app->cover_letter }}</p>
            @endif
            @if ($app->resume_path)
                <a href="{{ Storage::url($app->resume_path) }}" target="_blank" class="text-xs text-brand-600 font-medium mt-2 inline-block">Download Resume</a>
            @endif
        </div>
    @empty
        <p class="p-8 text-center text-gray-400 text-sm">No applicants yet.</p>
    @endforelse
</div>

<div class="mt-6">{{ $applications->links() }}</div>
@endsection
