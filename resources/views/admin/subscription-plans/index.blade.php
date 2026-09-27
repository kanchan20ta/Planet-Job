@extends('layouts.panel')
@section('title', 'Subscription Plans - Planet Job Portal')

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

// Group plans by type so "Latest Jobs" and "Featured Jobs" plans render as separate sections.
// Assumes a `type` column on subscription_plans: 'latest' | 'featured'.
$latestPlans = $plans->where('type', 'latest');
$featuredPlans = $plans->where('type', 'featured');
@endphp

@section('panel-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold text-gray-900">Subscription Plans</h1>
    <p class="text-sm text-gray-500">Manage pricing and display duration for job listings</p>
</div>

{{-- Add New Plan --}}
<div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-8">
    <h2 class="font-semibold text-gray-900 mb-1">Add New Plan</h2>
    <p class="text-sm text-gray-500 mb-5">Create a pricing plan for either Latest Jobs or Featured Jobs listings.</p>

    <form method="POST" action="{{ route('admin.subscription-plans.store') }}" class="grid grid-cols-1 sm:grid-cols-6 gap-4">
        @csrf

        <div class="sm:col-span-2">
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Plan Name</label>
            <input type="text" name="name" placeholder="e.g. Standard Listing" required
                class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Plan Type</label>
            <select name="type" required
                class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                <option value="latest">Latest Jobs</option>
                <option value="featured">Featured Jobs</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Price</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-sm text-gray-400">Rs.</span>
                <input type="number" step="0.01" min="0" name="price" placeholder="0.00" required
                    class="block w-full rounded-lg border border-gray-300 pl-10 pr-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            </div>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Display Duration</label>
            <select name="duration_days" required
                class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                <option value="15">15 days</option>
                <option value="30" selected>30 days</option>
                <option value="60">60 days</option>
                <option value="90">90 days</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Job Post Limit</label>
            <input type="number" min="1" name="job_post_limit" placeholder="e.g. 10" required
                class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
        </div>

        <div class="sm:col-span-6 flex justify-end">
            <button class="bg-brand-600 text-white font-semibold rounded-lg px-6 py-2.5 text-sm hover:bg-brand-700 transition-colors">
                Add Plan
            </button>
        </div>
    </form>
</div>

{{-- Latest Jobs Plans --}}
<div class="mb-8">
    <div class="flex items-center gap-2 mb-4">
        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
        <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Latest Jobs Plans</h2>
        <span class="text-xs text-gray-400">Standard listings shown in the main job feed</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($latestPlans as $plan)
            @include('admin.subscription-plans.partials.plan-card', ['plan' => $plan, 'accent' => 'blue'])
        @empty
            <p class="text-sm text-gray-400 sm:col-span-3">No Latest Jobs plans yet. Add one above.</p>
        @endforelse
    </div>
</div>

{{-- Featured Jobs Plans --}}
<div>
    <div class="flex items-center gap-2 mb-4">
        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
        <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Featured Jobs Plans</h2>
        <span class="text-xs text-gray-400">Highlighted listings shown at the top and on the homepage</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($featuredPlans as $plan)
            @include('admin.subscription-plans.partials.plan-card', ['plan' => $plan, 'accent' => 'amber'])
        @empty
            <p class="text-sm text-gray-400 sm:col-span-3">No Featured Jobs plans yet. Add one above.</p>
        @endforelse
    </div>
</div>
@endsection
