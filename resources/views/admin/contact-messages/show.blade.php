@extends('layouts.panel')
@section('title', 'Message from ' . $message->name . ' - Planet Job Portal')

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
<a href="{{ route('admin.contact-messages.index') }}" class="text-xs text-brand-600 font-medium">&larr; Back to messages</a>
<div class="bg-white border border-gray-200 rounded-xl p-6 mt-4">
    <h1 class="text-lg font-bold text-gray-900">{{ $message->subject ?: 'No subject' }}</h1>
    <p class="text-sm text-gray-500 mt-1">From {{ $message->name }} &lt;{{ $message->email }}&gt; @if($message->phone) &middot; {{ $message->phone }} @endif</p>
    <p class="text-xs text-gray-400 mt-1">{{ $message->created_at->format('M d, Y h:i A') }}</p>
    <p class="text-sm text-gray-700 mt-6 whitespace-pre-line">{{ $message->message }}</p>
</div>
@endsection
