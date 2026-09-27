@extends('layouts.panel')
@section('title', 'Edit ' . $page->title . ' - Planet Job Portal')

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
<h1 class="text-xl font-bold text-gray-900 mb-6">Edit: {{ $page->title }}</h1>

<form method="POST" action="{{ route('admin.pages.update', $page) }}" class="bg-white border border-gray-200 rounded-xl p-6 space-y-5">
    @csrf @method('PUT')
    <div>
        <label class="text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" value="{{ old('title', $page->title) }}" required class="w-full mt-1 rounded-lg border-gray-300 text-sm">
    </div>
    <div>
        <label class="text-sm font-medium text-gray-700">Content</label>
        <textarea name="content" rows="10" required class="w-full mt-1 rounded-lg border-gray-300 text-sm">{{ old('content', $page->content) }}</textarea>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium text-gray-700">Meta Title</label>
            <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" class="w-full mt-1 rounded-lg border-gray-300 text-sm">
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700">Meta Description</label>
            <input type="text" name="meta_description" value="{{ old('meta_description', $page->meta_description) }}" class="w-full mt-1 rounded-lg border-gray-300 text-sm">
        </div>
    </div>
    <button class="bg-brand-600 text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-brand-700 text-sm">Save Changes</button>
</form>
@endsection
