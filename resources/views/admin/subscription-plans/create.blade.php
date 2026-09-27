@extends('layouts.panel')
@section('title', 'Add Subscription Plan - Planet Job Portal')

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
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Add Subscription Plan</h1>
        <p class="text-sm text-gray-500">Create a pricing plan for either Latest Jobs or Featured Jobs listings.</p>
    </div>
    <a href="{{ route('admin.subscription-plans.index') }}"
        class="text-sm font-medium text-gray-600 hover:text-gray-900">
        &larr; Back to plans
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 max-w-3xl">
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.subscription-plans.store') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        @csrf

        <div class="sm:col-span-2">
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Plan Name</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Standard Listing" required
                class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Plan Type</label>
            <select name="type" required
                class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                <option value="latest" @selected(old('type') === 'latest')>Latest Jobs</option>
                <option value="featured" @selected(old('type') === 'featured')>Featured Jobs</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Price</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-sm text-gray-400">Rs.</span>
                <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" placeholder="0.00" required
                    class="block w-full rounded-lg border border-gray-300 pl-10 pr-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            </div>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Display Duration</label>
            <select name="duration_days" required
                class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                <option value="15" @selected(old('duration_days') == 15)>15 days</option>
                <option value="30" @selected(old('duration_days', 30) == 30)>30 days</option>
                <option value="60" @selected(old('duration_days') == 60)>60 days</option>
                <option value="90" @selected(old('duration_days') == 90)>90 days</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Job Post Limit</label>
            <input type="number" min="1" name="job_post_limit" value="{{ old('job_post_limit') }}" placeholder="e.g. 10" required
                class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
        </div>

        <div class="sm:col-span-2 flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.subscription-plans.index') }}"
                class="rounded-lg px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors">
                Cancel
            </a>
            <button class="bg-brand-600 text-white font-semibold rounded-lg px-6 py-2.5 text-sm hover:bg-brand-700 transition-colors">
                Add Plan
            </button>
        </div>
    </form>
</div>
@endsection
