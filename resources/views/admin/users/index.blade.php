@extends('layouts.panel')
@section('title', 'Manage Users - Planet Job Portal')

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
<h1 class="text-xl font-bold text-gray-900 mb-6">Manage Users</h1>

<form method="GET" class="flex gap-3 mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email" class="rounded-lg border-gray-300 text-sm flex-1">
    <select name="role" class="rounded-lg border-gray-300 text-sm">
        <option value="">All Roles</option>
        <option value="admin" @selected(request('role') === 'admin')>Admin</option>
        <option value="employer" @selected(request('role') === 'employer')>Employer</option>
        <option value="jobseeker" @selected(request('role') === 'jobseeker')>Jobseeker</option>
    </select>
    <button class="bg-brand-600 text-white text-sm font-semibold px-4 rounded-lg">Filter</button>
</form>

<div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100">
    @forelse ($users as $user)
        <div class="p-4 flex items-center justify-between text-sm">
            <div>
                @if ($user->role === 'jobseeker')
                    <a href="{{ route('admin.users.show', $user) }}" class="font-medium text-brand-600 hover:text-brand-700 hover:underline">{{ $user->name }}</a>
                @else
                    <p class="font-medium text-gray-800">{{ $user->name }}</p>
                @endif
                <p class="text-xs text-gray-400">{{ $user->email }} &middot; {{ ucfirst($user->role) }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs px-2 py-1 rounded-full {{ $user->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} capitalize">{{ $user->status }}</span>
                @if ($user->role !== 'admin')
                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                        @csrf
                        <button class="text-xs text-brand-600 font-medium">{{ $user->status === 'active' ? 'Ban' : 'Activate' }}</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="p-8 text-center text-gray-400 text-sm">No users found.</p>
    @endforelse
</div>

<div class="mt-6">{{ $users->links() }}</div>
@endsection
