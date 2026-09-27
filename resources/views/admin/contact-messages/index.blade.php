@extends('layouts.panel')
@section('title', 'Contact Messages - Planet Job Portal')

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
<h1 class="text-xl font-bold text-gray-900 mb-6">Contact Messages</h1>

<div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100">
    @forelse ($messages as $message)
        <a href="{{ route('admin.contact-messages.show', $message) }}" class="p-4 flex items-center justify-between text-sm hover:bg-gray-50 block">
            <div>
                <p class="font-medium text-gray-800 {{ $message->is_read ? '' : 'font-bold' }}">{{ $message->name }} &middot; {{ $message->subject ?: 'No subject' }}</p>
                <p class="text-xs text-gray-400">{{ $message->email }} &middot; {{ $message->created_at->diffForHumans() }}</p>
            </div>
            @unless ($message->is_read)
                <span class="w-2 h-2 rounded-full bg-brand-600"></span>
            @endunless
        </a>
    @empty
        <p class="p-8 text-center text-gray-400 text-sm">No messages yet.</p>
    @endforelse
</div>

<div class="mt-6">{{ $messages->links() }}</div>
@endsection
