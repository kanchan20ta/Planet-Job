@extends('layouts.panel')
@section('title', 'Manage FAQs - Planet Job Portal')

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
<h1 class="text-xl font-bold text-gray-900 mb-6">Manage FAQs</h1>

<form method="POST" action="{{ route('admin.faqs.store') }}" class="bg-white border border-gray-200 rounded-xl p-5 space-y-3 mb-8">
    @csrf
    <input type="text" name="question" placeholder="Question" required class="w-full rounded-lg border-gray-300 text-sm">
    <textarea name="answer" placeholder="Answer" required rows="2" class="w-full rounded-lg border-gray-300 text-sm"></textarea>
    <div class="flex gap-3">
        <select name="category" class="rounded-lg border-gray-300 text-sm">
            <option value="general">General</option>
            <option value="employer">Employer</option>
            <option value="jobseeker">Jobseeker</option>
            <option value="billing">Billing</option>
        </select>
        <input type="number" name="order" placeholder="Order" class="w-24 rounded-lg border-gray-300 text-sm">
        <button class="bg-brand-600 text-white font-semibold px-4 rounded-lg text-sm">Add FAQ</button>
    </div>
</form>

<div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100">
    @foreach ($faqs as $faq)
        <div class="p-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="font-medium text-gray-800 text-sm">{{ $faq->question }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $faq->answer }}</p>
                    <span class="text-[10px] text-gray-400 uppercase">{{ $faq->category }}</span>
                </div>
                <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Delete this FAQ?')">
                    @csrf @method('DELETE')
                    <button class="text-xs text-red-600">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
