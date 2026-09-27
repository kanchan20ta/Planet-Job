@extends('layouts.panel')
@section('title', 'Manage Jobs - Planet Job Portal')

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
@endphp

@section('panel-content')
<h1 class="text-xl font-bold text-gray-900 mb-6">Manage Jobs</h1>

<div class="flex gap-2 mb-4 text-sm">
    @foreach (['' => 'All', 'pending' => 'Pending', 'active' => 'Active', 'closed' => 'Closed'] as $value => $label)
        <a href="{{ route('admin.jobs.index', array_filter(['status' => $value])) }}"
           class="px-3 py-1.5 rounded-full {{ request('status', '') === $value ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-600' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100">
    @forelse ($jobs as $job)
        <div class="p-4 flex items-center justify-between">
            <div>
                <p class="font-semibold text-gray-800 text-sm">{{ $job->title }}</p>
                <p class="text-xs text-gray-400">{{ $job->company->name }} &middot; {{ $job->category->name }}</p>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span class="px-2 py-1 rounded-full bg-gray-100 capitalize">{{ $job->status }}</span>
                @if ($job->status === 'pending')
                    <form method="POST" action="{{ route('admin.jobs.approve', $job) }}">
                        @csrf
                        <button class="text-green-600 font-semibold">Approve</button>
                    </form>
                    <form method="POST" action="{{ route('admin.jobs.reject', $job) }}">
                        @csrf
                        <button class="text-red-600 font-semibold">Reject</button>
                    </form>
                @endif
                <a href="{{ route('admin.jobs.edit', $job) }}" class="text-brand-600 font-semibold">Edit</a>
                <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}" onsubmit="return confirm('Delete this job?')">
                    @csrf @method('DELETE')
                    <button class="text-gray-500">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p class="p-8 text-center text-gray-400 text-sm">No jobs found.</p>
    @endforelse
</div>

<div class="mt-6">{{ $jobs->links() }}</div>
@endsection
