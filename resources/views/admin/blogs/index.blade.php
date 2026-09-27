@extends('layouts.panel')
@section('title', 'Manage Blog - Planet Job Portal')

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
    <h1 class="text-xl font-bold text-gray-900">Blog Posts</h1>
    <a href="{{ route('admin.blogs.create') }}" class="bg-brand-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-brand-700">+ New Post</a>
</div>

<div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100">
    @forelse ($blogs as $blog)
        <div class="p-4 flex items-center justify-between text-sm">
            <div>
                <p class="font-medium text-gray-800">{{ $blog->title }}</p>
                <p class="text-xs text-gray-400">{{ $blog->category?->name }} &middot; {{ $blog->views }} views</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 capitalize">{{ $blog->status }}</span>
                <a href="{{ route('admin.blogs.edit', $blog) }}" class="text-xs text-brand-600 font-medium">Edit</a>
                <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" onsubmit="return confirm('Delete this post?')">
                    @csrf @method('DELETE')
                    <button class="text-xs text-red-600">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p class="p-8 text-center text-gray-400 text-sm">No blog posts yet.</p>
    @endforelse
</div>

<div class="mt-6">{{ $blogs->links() }}</div>
@endsection
