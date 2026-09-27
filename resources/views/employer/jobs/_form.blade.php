{{-- Shared fields for create/edit. Expects optional $job and $categories/$jobTypes/$skills. --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Job Title</label>
        <input type="text" name="title" value="{{ old('title', $job->title ?? '') }}" required
            class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
        <select name="category_id" required
            class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $job->category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Job Type</label>
        <select name="job_type_id" required
            class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            @foreach ($jobTypes as $jobType)
                <option value="{{ $jobType->id }}" @selected(old('job_type_id', $job->job_type_id ?? '') == $jobType->id)>{{ $jobType->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Vacancy</label>
        <input type="number" name="vacancy" min="1" value="{{ old('vacancy', $job->vacancy ?? 1) }}" required
            class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Application Deadline</label>
        <input type="date" name="deadline" value="{{ old('deadline', isset($job) ? $job->deadline?->toDateString() : '') }}" required
            class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Salary Min</label>
        <input type="number" name="salary_min" value="{{ old('salary_min', $job->salary_min ?? '') }}"
            class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Salary Max</label>
        <input type="number" name="salary_max" value="{{ old('salary_max', $job->salary_max ?? '') }}"
            class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Salary Type</label>
        <select name="salary_type"
            class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            @foreach (['hourly','monthly','yearly','negotiable'] as $type)
                <option value="{{ $type }}" @selected(old('salary_type', $job->salary_type ?? 'negotiable') === $type)>{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Experience Level</label>
        <select name="experience_level"
            class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            @foreach (['entry','mid','senior','lead','executive'] as $level)
                <option value="{{ $level }}" @selected(old('experience_level', $job->experience_level ?? '') === $level)>{{ ucfirst($level) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">City</label>
        <input type="text" name="city" value="{{ old('city', $job->city ?? '') }}" required
            class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
    </div>
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Location / Address</label>
        <input type="text" name="location" value="{{ old('location', $job->location ?? '') }}" required
            class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
    <textarea name="description" rows="4" required
        class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 leading-relaxed placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">{{ old('description', $job->description ?? '') }}</textarea>
</div>
<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Responsibilities</label>
    <textarea name="responsibilities" rows="3"
        class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 leading-relaxed placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">{{ old('responsibilities', $job->responsibilities ?? '') }}</textarea>
</div>
<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Requirements</label>
    <textarea name="requirements" rows="3"
        class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 leading-relaxed placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">{{ old('requirements', $job->requirements ?? '') }}</textarea>
</div>
<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Benefits</label>
    <textarea name="benefits" rows="3"
        class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 leading-relaxed placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">{{ old('benefits', $job->benefits ?? '') }}</textarea>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Skills</label>
    <div class="flex flex-wrap gap-2 mt-2">
        @php $selectedSkills = old('skills', isset($job) ? $job->skills->pluck('id')->toArray() : []); @endphp
        @foreach ($skills as $skill)
            <label class="text-xs font-medium border border-gray-300 rounded-full px-3.5 py-1.5 cursor-pointer text-gray-700 transition-colors hover:border-gray-400 has-[:checked]:bg-brand-50 has-[:checked]:border-brand-500 has-[:checked]:text-brand-700">
                <input type="checkbox" name="skills[]" value="{{ $skill->id }}" class="sr-only" @checked(in_array($skill->id, $selectedSkills))>
                {{ $skill->name }}
            </label>
        @endforeach
    </div>
</div>

<div class="mt-6 flex flex-wrap gap-6 border-t border-gray-200 pt-5">
    <label class="flex items-center gap-2 text-sm text-gray-700">
        <input type="checkbox" name="is_remote" value="1" @checked(old('is_remote', $job->is_remote ?? false))
            class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500/30">
        Remote position
    </label>
    <label class="flex items-center gap-2 text-sm text-gray-700">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $job->is_featured ?? false))
            class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500/30">
        Feature this job (uses your plan's featured slot)
    </label>
</div>
