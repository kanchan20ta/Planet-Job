@extends('layouts.app')

@section('title', 'Apply for ' . $job->title)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10 sm:py-14">

    <a href="{{ route('jobs.show', $job) }}"
       class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-brand-600 transition-colors mb-6">
        <i class="fa-solid fa-arrow-left text-xs"></i>
        Back to job details
    </a>

    {{-- Job summary --}}
    <div class="flex items-center gap-4 bg-white border border-gray-200 rounded-2xl p-5 shadow-sm mb-8">
        <div class="w-14 h-14 shrink-0 rounded-xl border border-gray-100 bg-gray-50 flex items-center justify-center overflow-hidden">
            @if($job->company?->logo)
                <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="w-full h-full object-contain">
            @else
                <span class="text-lg font-bold text-brand-700">
                    {{ substr($job->company->name ?? $job->title, 0, 1) }}
                </span>
            @endif
        </div>
        <div class="min-w-0">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Applying for</p>
            <h2 class="font-semibold text-gray-900 leading-snug truncate">{{ $job->title }}</h2>
            <p class="text-sm text-gray-500 truncate">{{ $job->company->name ?? 'Confidential company' }}</p>
        </div>
    </div>

    {{-- Validation summary --}}
    @if ($errors->any())
        <div class="flex items-start gap-3 bg-red-50 border border-red-100 text-red-700 rounded-xl p-4 mb-6" role="alert">
            <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
            <div>
                <p class="font-semibold text-sm">Please fix the following:</p>
                <ul class="text-sm mt-1 list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Application form --}}
    <form
        method="POST"
        action="{{ route('jobseeker.jobs.apply', $job) }}"
        enctype="multipart/form-data"
        class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8 space-y-8"
        novalidate
    >
        @csrf

        {{-- Cover letter --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="cover_letter" class="block text-sm font-semibold text-gray-900">Cover letter</label>
                <span class="text-xs text-gray-400"><span id="coverLetterCount">{{ strlen(old('cover_letter', '')) }}</span>/2000</span>
            </div>
            <p class="text-sm text-gray-500 mb-3">Tell the employer why you're a great fit for this role.</p>

            <textarea
                id="cover_letter"
                name="cover_letter"
                rows="7"
                maxlength="2000"
                placeholder="I'm excited to apply because..."
                oninput="document.getElementById('coverLetterCount').textContent = this.value.length"
                aria-describedby="@error('cover_letter') cover_letter_error @enderror"
                class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-colors resize-y @error('cover_letter') border-red-300 focus:border-red-400 focus:ring-red-500/20 @enderror"
            >{{ old('cover_letter') }}</textarea>

            @error('cover_letter')
                <p id="cover_letter_error" class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Resume upload --}}
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-1.5">Resume</label>

            @if(auth()->user()->jobseekerProfile?->resume_path ?? false)
                <div class="flex items-center justify-between gap-3 bg-brand-50 border border-brand-100 rounded-xl px-4 py-3 mb-3">
                    <span class="flex items-center gap-2 text-sm font-medium text-brand-700">
                        <i class="fa-solid fa-file-lines"></i>
                        Resume already on file
                    </span>
                    <span class="text-xs text-brand-600/80">Leave this empty to reuse it</span>
                </div>
            @endif

            <label
                for="resume"
                id="resumeDropzone"
                class="group relative flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 rounded-2xl px-6 py-10 text-center cursor-pointer bg-gray-50/50 hover:border-brand-400 hover:bg-brand-50/40 focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-500/20 transition-colors @error('resume') border-red-300 @enderror"
            >
                <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-300 group-hover:text-brand-500 transition-colors"></i>
                <p class="text-sm font-medium text-gray-700">
                    <span id="resumeFileName">Click to upload or drag and drop</span>
                </p>
                <p class="text-xs text-gray-400">PDF, DOC, or DOCX &middot; up to 5MB</p>

                <input
                    type="file"
                    id="resume"
                    name="resume"
                    accept=".pdf,.doc,.docx"
                    aria-describedby="@error('resume') resume_error @enderror"
                    class="sr-only"
                    onchange="document.getElementById('resumeFileName').textContent = this.files.length ? this.files[0].name : 'Click to upload or drag and drop'"
                >
            </label>

            @error('resume')
                <p id="resume_error" class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Actions --}}
        <div class="flex flex-col-reverse sm:flex-row sm:items-center gap-3 pt-2 border-t border-gray-100">
            <a href="{{ route('jobs.show', $job) }}"
               class="text-sm font-medium text-gray-500 hover:text-gray-700 text-center sm:text-left">
                Cancel
            </a>
            <button
                type="submit"
                class="sm:ml-auto inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 active:scale-95 text-white text-sm font-semibold px-6 py-3 rounded-xl shadow-sm hover:shadow-md transition-all"
            >
                <i class="fa-solid fa-paper-plane text-xs"></i>
                Submit application
            </button>
        </div>
    </form>

</div>
@endsection
