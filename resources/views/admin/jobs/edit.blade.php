@extends('layouts.panel')
@section('title', 'Edit Job - Planet Job Portal')

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
    <h1 class="text-xl font-bold text-gray-900">Edit Job</h1>
    <a href="{{ route('admin.jobs.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to jobs</a>
</div>

<form method="POST" action="{{ route('admin.jobs.update', $job) }}" class="bg-white border border-gray-200 rounded-xl p-6 space-y-5 max-w-3xl">
    @csrf
    @method('PUT')

    <div>
        <label class="text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" value="{{ old('title', $job->title) }}"
               class="w-full mt-1 rounded-lg border-gray-300 text-sm">
        @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium text-gray-700">Category</label>
            <select name="category_id" class="w-full mt-1 rounded-lg border-gray-300 text-sm">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $job->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700">Job Type</label>
            <select name="job_type_id" class="w-full mt-1 rounded-lg border-gray-300 text-sm">
                @foreach ($jobTypes as $jobType)
                    <option value="{{ $jobType->id }}" @selected(old('job_type_id', $job->job_type_id) == $jobType->id)>{{ $jobType->name }}</option>
                @endforeach
            </select>
            @error('job_type_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium text-gray-700">City</label>
            <input type="text" name="city" value="{{ old('city', $job->city) }}"
                   class="w-full mt-1 rounded-lg border-gray-300 text-sm">
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700">Experience Level</label>
            <select name="experience_level" class="w-full mt-1 rounded-lg border-gray-300 text-sm">
                <option value="">Any</option>
                @foreach (['entry','mid','senior','lead','executive'] as $level)
                    <option value="{{ $level }}" @selected(old('experience_level', $job->experience_level) === $level)>{{ ucfirst($level) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_remote" value="1" @checked(old('is_remote', $job->is_remote)) class="rounded border-gray-300">
        Remote position
    </label>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="text-sm font-medium text-gray-700">Vacancies</label>
            <input type="number" name="vacancy" min="1" value="{{ old('vacancy', $job->vacancy) }}"
                   class="w-full mt-1 rounded-lg border-gray-300 text-sm">
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700">Salary Min</label>
            <input type="number" name="salary_min" min="0" value="{{ old('salary_min', $job->salary_min) }}"
                   class="w-full mt-1 rounded-lg border-gray-300 text-sm">
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700">Salary Max</label>
            <input type="number" name="salary_max" min="0" value="{{ old('salary_max', $job->salary_max) }}"
                   class="w-full mt-1 rounded-lg border-gray-300 text-sm">
            @error('salary_max') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium text-gray-700">Salary Type</label>
            <input type="text" name="salary_type" placeholder="e.g. month, year" value="{{ old('salary_type', $job->salary_type) }}"
                   class="w-full mt-1 rounded-lg border-gray-300 text-sm">
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700">Application Deadline</label>
            <input type="date" name="deadline" value="{{ old('deadline', $job->deadline?->format('Y-m-d')) }}"
                   class="w-full mt-1 rounded-lg border-gray-300 text-sm">
        </div>
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" rows="5" class="w-full mt-1 rounded-lg border-gray-300 text-sm">{{ old('description', $job->description) }}</textarea>
        @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Responsibilities</label>
        <p class="text-xs text-gray-400 mb-1">One item per line.</p>
        <textarea name="responsibilities" rows="4" class="w-full rounded-lg border-gray-300 text-sm">{{ old('responsibilities', $job->responsibilities) }}</textarea>
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Requirements</label>
        <p class="text-xs text-gray-400 mb-1">One item per line.</p>
        <textarea name="requirements" rows="4" class="w-full rounded-lg border-gray-300 text-sm">{{ old('requirements', $job->requirements) }}</textarea>
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Benefits</label>
        <p class="text-xs text-gray-400 mb-1">One item per line.</p>
        <textarea name="benefits" rows="4" class="w-full rounded-lg border-gray-300 text-sm">{{ old('benefits', $job->benefits) }}</textarea>
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button type="submit" class="bg-brand-600 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-brand-700 text-sm">
            Save Changes
        </button>
        <a href="{{ route('admin.jobs.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
    </div>
</form>
@endsection
