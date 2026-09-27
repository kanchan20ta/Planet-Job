@extends('layouts.panel')
@section('title', 'Manage Companies - Planet Job Portal')

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
<h1 class="text-xl font-bold text-gray-900 mb-6">Manage Companies</h1>

<div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100">
    @forelse ($companies as $company)
        <div class="p-4 flex items-center justify-between text-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-700 font-bold flex items-center justify-center">
                    {{ substr($company->name, 0, 1) }}
                </div>
                <div>
                    <a href="{{ route('companies.show', $company) }}" class="font-medium text-gray-800 hover:text-brand-600">{{ $company->name }}</a>
                    <p class="text-xs text-gray-400">{{ $company->jobs_count }} jobs &middot; {{ $company->city }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if ($company->is_verified)
                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Verified</span>
                @else
                    <form method="POST" action="{{ route('admin.companies.verify', $company) }}">
                        @csrf
                        <button class="text-xs text-brand-600 font-medium">Verify</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="p-8 text-center text-gray-400 text-sm">No companies yet.</p>
    @endforelse
</div>

<div class="mt-6">{{ $companies->links() }}</div>
@endsection
