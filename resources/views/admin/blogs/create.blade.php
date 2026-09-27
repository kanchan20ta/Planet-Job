@extends('layouts.panel')
@section('title', 'New Blog Post - Planet Job Portal')

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

$inputClasses = 'w-full mt-1.5 rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-800 shadow-sm transition-colors duration-200 placeholder:text-gray-400 hover:border-gray-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 focus:outline-none';
$selectClasses = $inputClasses . ' appearance-none bg-no-repeat bg-[right_0.85rem_center] bg-[length:1rem] pr-10';
$chevron = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E";
@endphp

@section('panel-content')

<div class="flex items-center justify-between mb-6">
    <div>
        <a href="{{ route('admin.blogs.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-400 hover:text-brand-600 transition-colors duration-200">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            Blog Posts
        </a>
        <h1 class="text-xl font-bold text-gray-900 mt-1">New Blog Post</h1>
    </div>
</div>

<form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data"
      class="bg-white border border-gray-200 rounded-2xl shadow-sm shadow-gray-200/60 divide-y divide-gray-100">
    @csrf

    {{-- ---------- Details ---------- --}}
    <div class="p-6 sm:p-7 space-y-5">
        <h2 class="text-sm font-semibold text-gray-900">Details</h2>

        <div>
            <label for="title" class="text-sm font-medium text-gray-700">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   placeholder="e.g. 5 Tips for Writing a Standout Resume"
                   class="{{ $inputClasses }} @error('title') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror">
            @error('title')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="blog_category_id" class="text-sm font-medium text-gray-700">Category</label>
                <select id="blog_category_id" name="blog_category_id" required
                        style="background-image: url(&quot;{{ $chevron }}&quot;);"
                        class="{{ $selectClasses }} @error('blog_category_id') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('blog_category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <p class="mt-1.5 text-xs text-gray-400">Choose the category that best fits this post, so it's filed correctly on the blog.</p>
                @error('blog_category_id')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="status" class="text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status"
                        style="background-image: url(&quot;{{ $chevron }}&quot;);"
                        class="{{ $selectClasses }}">
                    <option value="draft" @selected(old('status', 'draft') === 'draft')>Draft</option>
                    <option value="published" @selected(old('status') === 'published')>Published</option>
                </select>
            </div>
        </div>
    </div>

    {{-- ---------- Thumbnail ---------- --}}
    <div class="p-6 sm:p-7 space-y-2">
        <h2 class="text-sm font-semibold text-gray-900">Thumbnail</h2>
        <label for="thumbnail"
               id="thumbnail-dropzone"
               class="group relative flex flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50/60 px-6 py-8 text-center cursor-pointer transition-colors duration-200 hover:border-brand-400 hover:bg-brand-50/40">
            <div class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 shadow-sm transition-colors duration-200 group-hover:text-brand-600 group-hover:border-brand-200">
                <i class="fa-solid fa-cloud-arrow-up"></i>
            </div>
            <p class="text-sm text-gray-600">
                <span class="font-semibold text-brand-700">Click to upload</span> or drag and drop
            </p>
            <p id="thumbnail-filename" class="text-xs text-gray-400">PNG or JPG, up to 2MB</p>
            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="sr-only">
        </label>
        @error('thumbnail')
            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- ---------- Content ---------- --}}
    <div class="p-6 sm:p-7 space-y-5">
        <h2 class="text-sm font-semibold text-gray-900">Content</h2>

        <div>
            <div class="flex items-center justify-between">
                <label for="excerpt" class="text-sm font-medium text-gray-700">Excerpt</label>
                <span id="excerpt-count" class="text-xs text-gray-400">0 / 500</span>
            </div>
            <textarea id="excerpt" name="excerpt" rows="2" maxlength="500"
                      placeholder="A short summary shown on the blog listing page&hellip;"
                      class="{{ $inputClasses }} resize-y">{{ old('excerpt') }}</textarea>
        </div>

        <div>
            <label for="content" class="text-sm font-medium text-gray-700">Content</label>
            <textarea id="content" name="content" rows="12" required
                      placeholder="Write the full article here&hellip;"
                      class="{{ $inputClasses }} resize-y font-normal leading-relaxed @error('content') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror">{{ old('content') }}</textarea>
            @error('content')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- ---------- Actions ---------- --}}
    <div class="p-6 sm:p-7 flex items-center justify-end gap-3">
        <a href="{{ route('admin.blogs.index') }}"
           class="text-sm font-semibold text-gray-600 px-5 py-2.5 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            Cancel
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 bg-brand-600 text-white font-semibold px-6 py-2.5 rounded-lg shadow-sm transition-all duration-200 hover:bg-brand-700 hover:shadow-md active:scale-[0.98] text-sm">
            <i class="fa-solid fa-paper-plane text-xs"></i>
            Publish
        </button>
    </div>
</form>

@push('scripts')
<script>
(function () {
    const fileInput   = document.getElementById('thumbnail');
    const filenameEl  = document.getElementById('thumbnail-filename');
    const excerpt     = document.getElementById('excerpt');
    const excerptCount = document.getElementById('excerpt-count');

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            filenameEl.textContent = fileInput.files.length
                ? fileInput.files[0].name
                : 'PNG or JPG, up to 2MB';
        });
    }

    if (excerpt && excerptCount) {
        const updateCount = function () {
            excerptCount.textContent = excerpt.value.length + ' / 500';
        };
        excerpt.addEventListener('input', updateCount);
        updateCount();
    }
})();
</script>
@endpush

@endsection
