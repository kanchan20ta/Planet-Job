@extends('layouts.app')
@section('title', 'Browse Jobs - Planet Job Portal')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Find Your Next Job</h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Filters --}}
        <aside class="lg:col-span-1">
            <form method="GET" class="bg-white border border-gray-200 rounded-xl p-5 space-y-4 sticky top-20">
                <div>
                    <label class="text-sm font-medium text-gray-700">Keyword</label>
                    <div class="relative mt-1">
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/></svg>
                        <input type="text" name="keyword" value="{{ $filters['keyword'] ?? '' }}" placeholder="Job title, skill, or company"
                               class="w-full rounded-lg border-gray-300 text-sm pl-9">
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">City</label>
                    <div class="relative mt-1">
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <input type="text" name="city" list="nepal-cities" autocomplete="off" value="{{ $filters['city'] ?? '' }}" placeholder="Any city"
                               class="w-full rounded-lg border-gray-300 text-sm pl-9">
                        <datalist id="nepal-cities">
                            <option value="Kathmandu">
                            <option value="Pokhara">
                            <option value="Lalitpur">
                            <option value="Bhaktapur">
                            <option value="Biratnagar">
                            <option value="Bharatpur">
                            <option value="Birgunj">
                            <option value="Dharan">
                            <option value="Butwal">
                            <option value="Hetauda">
                            <option value="Dhangadhi">
                            <option value="Nepalgunj">
                            <option value="Itahari">
                            <option value="Janakpur">
                            <option value="Ghorahi">
                            <option value="Tulsipur">
                            <option value="Kirtipur">
                            <option value="Damak">
                            <option value="Siddharthanagar">
                            <option value="Birendranagar">
                        </datalist>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Category</label>
                    <select name="category" class="w-full mt-1 rounded-lg border-gray-300 text-sm">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(($filters['category'] ?? null) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-700">Job Type</span>
                    <div class="mt-2 flex flex-wrap gap-1.5">
                        <label class="cursor-pointer">
                            <input type="radio" name="job_type" value="" class="peer sr-only" @checked(empty($filters['job_type'] ?? null))>
                            <span class="inline-flex items-center rounded-full border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-600 transition-colors hover:border-gray-400 hover:bg-gray-50 peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-brand-600">
                                Any type
                            </span>
                        </label>
                        @foreach ($jobTypes as $jobType)
                            <label class="cursor-pointer">
                                <input type="radio" name="job_type" value="{{ $jobType->id }}" class="peer sr-only" @checked(($filters['job_type'] ?? null) == $jobType->id)>
                                <span class="inline-flex items-center rounded-full border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-600 transition-colors hover:border-gray-400 hover:bg-gray-50 peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-brand-600">
                                    {{ $jobType->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-700">Experience</span>
                    <div class="mt-2 flex flex-wrap gap-1.5">
                        <label class="cursor-pointer">
                            <input type="radio" name="experience_level" value="" class="peer sr-only" @checked(empty($filters['experience_level'] ?? null))>
                            <span class="inline-flex items-center rounded-full border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-600 transition-colors hover:border-gray-400 hover:bg-gray-50 peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-brand-600">
                                Any level
                            </span>
                        </label>
                        @foreach (['entry','mid','senior','lead','executive'] as $level)
                            <label class="cursor-pointer">
                                <input type="radio" name="experience_level" value="{{ $level }}" class="peer sr-only" @checked(($filters['experience_level'] ?? null) === $level)>
                                <span class="inline-flex items-center rounded-full border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-600 transition-colors hover:border-gray-400 hover:bg-gray-50 peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-brand-600">
                                    {{ ucfirst($level) }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="remote_only" value="1" @checked($filters['remote_only'] ?? false) class="rounded border-gray-300">
                    Remote only
                </label>
                <div class="flex items-center gap-2 pt-1">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-brand-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4.5h18M6 9.75h12M10 15h4"/></svg>
                        Apply Filters
                    </button>
                    <a href="{{ route('jobs.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm font-medium text-gray-600 transition-colors hover:border-gray-400 hover:bg-gray-50 hover:text-gray-900"
                       title="Clear all filters">
                        Clear
                    </a>
                </div>
            </form>
        </aside>

        {{-- Results --}}
        <div class="lg:col-span-3">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500">{{ $jobs->total() }} jobs found</p>
                <form method="GET">
                    @foreach ($filters as $key => $value)
                        @if ($key !== 'sort')
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <select name="sort" onchange="this.form.submit()" class="text-sm rounded-lg border-gray-300">
                        <option value="latest" @selected(($filters['sort'] ?? 'latest') === 'latest')>Latest</option>
                        <option value="featured" @selected(($filters['sort'] ?? '') === 'featured')>Featured</option>
                        <option value="salary_high" @selected(($filters['sort'] ?? '') === 'salary_high')>Salary: High to Low</option>
                        <option value="salary_low" @selected(($filters['sort'] ?? '') === 'salary_low')>Salary: Low to High</option>
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                @forelse ($jobs as $job)
                    @include('partials.job-card', ['job' => $job])
                @empty
                    <p class="text-gray-500 col-span-2 text-center py-16">No jobs matched your search. Try different filters.</p>
                @endforelse
            </div>

            <div class="mt-8">{{ $jobs->links() }}</div>
        </div>
    </div>
</div>
@endsection
