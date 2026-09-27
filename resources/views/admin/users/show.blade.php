@extends('layouts.panel')
@section('title', $user->name . ' - Planet Job Portal')

@php
$panelTitle = 'Admin Panel';
$panelLinks = [
    ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'active' => 'admin.dashboard'],
    ['label' => 'Jobs', 'url' => route('admin.jobs.index'), 'active' => 'admin.jobs.*'],
    ['label' => 'Users', 'url' => route('admin.users.index'), 'active' => 'admin.users.*'],
    ['label' => 'Companies', 'url' => route('admin.companies.index'), 'active' => 'admin.companies.*'],
    ['label' => 'Subscription Plans', 'url' => route('admin.subscription-plans.index'), 'active' => 'admin.subscription-plans.*'],
    ['label' => 'Blog', 'url' => route('admin.blogs.index'), 'active' => 'admin.blogs.*'],
    ['label' => 'FAQs', 'url' => route('admin.faqs.index'), 'active' => 'admin.faqs.*'],
    ['label' => 'Pages', 'url' => route('admin.pages.index'), 'active' => 'admin.pages.*'],
    ['label' => 'Contact Messages', 'url' => route('admin.contact-messages.index'), 'active' => 'admin.contact-messages.*'],
];

$statusStyles = [
    'accepted' => 'bg-green-100 text-green-700',
    'rejected' => 'bg-red-100 text-red-700',
    'pending'  => 'bg-amber-100 text-amber-700',
    'reviewed' => 'bg-blue-100 text-blue-700',
];
@endphp

@section('panel-content')
<a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to users</a>

<div class="bg-white border border-gray-200 rounded-xl p-6 mt-4 mb-6">
    <div class="flex items-start justify-between gap-4 flex-wrap">
        <div>
            <h1 class="text-xl font-bold text-gray-900">{{ $user->name }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
            <div class="flex items-center gap-2 mt-3 text-xs">
                <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-600 capitalize">{{ $user->role }}</span>
                <span class="px-2 py-1 rounded-full capitalize {{ $user->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $user->status }}</span>
                <span class="text-gray-400">Joined {{ $user->created_at->format('M d, Y') }}</span>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
            @csrf
            <button class="text-sm font-medium text-brand-600 border border-gray-200 rounded-lg px-3.5 py-2 hover:bg-gray-50">
                {{ $user->status === 'active' ? 'Ban user' : 'Activate user' }}
            </button>
        </form>
    </div>
</div>

<h2 class="text-sm font-semibold text-gray-900 mb-3">Applications ({{ $applications->count() }})</h2>

<div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100">
    @forelse ($applications as $application)
        <div class="p-4 flex items-center justify-between gap-4 text-sm">
            <div class="min-w-0">
                <p class="font-medium text-gray-800 truncate">{{ $application->job->title ?? 'Job no longer available' }}</p>
                <p class="text-xs text-gray-400 truncate">
                    {{ $application->job->company->name ?? 'Unknown company' }}
                    &middot; Applied {{ $application->applied_at?->format('M d, Y') ?? $application->created_at->format('M d, Y') }}
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <span class="text-xs px-2 py-1 rounded-full capitalize {{ $statusStyles[$application->status] ?? 'bg-gray-100 text-gray-600' }}">
                    {{ $application->status }}
                </span>
                @if ($application->resume_path)
                    <a href="{{ \Illuminate\Support\Facades\Storage::url($application->resume_path) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 text-xs font-medium text-brand-600 hover:text-brand-700 border border-gray-200 rounded-lg px-2.5 py-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        View CV
                    </a>
                @else
                    <span class="text-xs text-gray-400">No CV</span>
                @endif
            </div>
        </div>
    @empty
        <p class="p-8 text-center text-gray-400 text-sm">This user hasn't applied to any jobs yet.</p>
    @endforelse
</div>
@endsection
