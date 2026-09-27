@extends('layouts.panel')
@section('title', 'My Profile - Planet Job Portal')

@php
$panelTitle = 'My Account';
$panelLinks = [
    ['label' => 'Dashboard', 'url' => route('jobseeker.dashboard'), 'active' => 'jobseeker.dashboard'],
    ['label' => 'My Profile', 'url' => route('jobseeker.profile.edit'), 'active' => 'jobseeker.profile.*'],
    ['label' => 'My Applications', 'url' => route('jobseeker.applications.index'), 'active' => 'jobseeker.applications.*'],
    ['label' => 'Saved Jobs', 'url' => route('jobseeker.saved-jobs.index'), 'active' => 'jobseeker.saved-jobs.*'],
    ['label' => 'Job Alerts', 'url' => route('jobseeker.job-alerts.index'), 'active' => 'jobseeker.job-alerts.*'],
];
@endphp

@section('panel-content')
<div class="max-w-5xl">

    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-[#0F2A4A] tracking-tight">My Profile</h1>
        <p class="text-sm text-slate-500 mt-1">Employers see this when you apply, or any time your profile is public.</p>
    </div>

    <form method="POST" action="{{ route('jobseeker.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-6 items-start">

            {{-- Main column --}}
            <div class="space-y-6 min-w-0">

                {{-- Basic information --}}
                <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm shadow-[#0F2A4A]/5 p-6">
                    <div class="flex items-baseline gap-3 mb-5">
                        <h2 class="text-base font-semibold text-[#0F2A4A]">Basic information</h2>
                        <span class="h-px flex-1 bg-slate-100"></span>
                    </div>
                    <p class="text-xs text-slate-400 -mt-4 mb-5">The headline and details employers see first.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label class="text-sm font-medium text-slate-700">Headline</label>
                            <input type="text" name="headline" value="{{ old('headline', $profile->headline) }}"
                                   placeholder="e.g. Senior Backend Developer"
                                   class="w-full mt-1.5 rounded-lg border-slate-200 bg-slate-50/50 text-sm text-[#0F2A4A] placeholder:text-slate-400 transition-colors focus:border-[#C9A54B] focus:bg-white focus:ring-4 focus:ring-[#C9A54B]/15">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Experience level</label>
                            <select name="experience_level"
                                    class="w-full mt-1.5 rounded-lg border-slate-200 bg-slate-50/50 text-sm text-[#0F2A4A] transition-colors focus:border-[#C9A54B] focus:bg-white focus:ring-4 focus:ring-[#C9A54B]/15">
                                @foreach (['entry','mid','senior','lead','executive'] as $level)
                                    <option value="{{ $level }}" @selected($profile->experience_level === $level)>{{ ucfirst($level) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Years of experience</label>
                            <input type="number" name="experience_years" value="{{ old('experience_years', $profile->experience_years) }}"
                                   min="0" placeholder="0"
                                   class="w-full mt-1.5 rounded-lg border-slate-200 bg-slate-50/50 text-sm text-[#0F2A4A] placeholder:text-slate-400 transition-colors focus:border-[#C9A54B] focus:bg-white focus:ring-4 focus:ring-[#C9A54B]/15">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="text-sm font-medium text-slate-700">City</label>
                            <input type="text" name="city" value="{{ old('city', $profile->city) }}"
                                   placeholder="e.g. Kathmandu"
                                   class="w-full mt-1.5 rounded-lg border-slate-200 bg-slate-50/50 text-sm text-[#0F2A4A] placeholder:text-slate-400 transition-colors focus:border-[#C9A54B] focus:bg-white focus:ring-4 focus:ring-[#C9A54B]/15">
                        </div>
                    </div>
                </div>

                {{-- Compensation --}}
                <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm shadow-[#0F2A4A]/5 p-6">
                    <div class="flex items-baseline gap-3 mb-1">
                        <h2 class="text-base font-semibold text-[#0F2A4A]">Compensation</h2>
                        <span class="h-px flex-1 bg-slate-100"></span>
                    </div>
                    <p class="text-xs text-slate-400 mb-5">Helps us match you to roles in your range. Not shown on your public profile.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Current salary</label>
                            <div class="relative mt-1.5">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sm font-medium text-slate-400 pointer-events-none">Rs.</span>
                                <input type="number" name="current_salary" value="{{ old('current_salary', $profile->current_salary) }}"
                                       min="0" placeholder="0" inputmode="numeric"
                                       class="w-full pl-11 rounded-lg border-slate-200 bg-slate-50/50 text-sm text-[#0F2A4A] placeholder:text-slate-400 transition-colors focus:border-[#C9A54B] focus:bg-white focus:ring-4 focus:ring-[#C9A54B]/15">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-xs text-slate-400 pointer-events-none">/ month</span>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Expected salary</label>
                            <div class="relative mt-1.5">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sm font-medium text-slate-400 pointer-events-none">Rs.</span>
                                <input type="number" name="expected_salary" value="{{ old('expected_salary', $profile->expected_salary) }}"
                                       min="0" placeholder="0" inputmode="numeric"
                                       class="w-full pl-11 rounded-lg border-slate-200 bg-slate-50/50 text-sm text-[#0F2A4A] placeholder:text-slate-400 transition-colors focus:border-[#C9A54B] focus:bg-white focus:ring-4 focus:ring-[#C9A54B]/15">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-xs text-slate-400 pointer-events-none">/ month</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- About you --}}
                <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm shadow-[#0F2A4A]/5 p-6">
                    <div class="flex items-baseline gap-3 mb-1">
                        <h2 class="text-base font-semibold text-[#0F2A4A]">About you</h2>
                        <span class="h-px flex-1 bg-slate-100"></span>
                    </div>
                    <p class="text-xs text-slate-400 mb-4">A short summary employers see on your profile.</p>

                    <textarea name="bio" rows="6" maxlength="1000" placeholder="Tell employers about your experience, the kind of work you do best, and what you're looking for next."
                              class="w-full rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white text-sm text-slate-700 leading-relaxed p-4 max-w-[65ch] placeholder:text-slate-400 transition-colors focus:border-[#C9A54B] focus:ring-4 focus:ring-[#C9A54B]/15">{{ old('bio', $profile->bio) }}</textarea>
                </div>

                {{-- Resume --}}
                <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm shadow-[#0F2A4A]/5 p-6">
                    <div class="flex items-baseline gap-3 mb-1">
                        <h2 class="text-base font-semibold text-[#0F2A4A]">Resume / CV</h2>
                        <span class="h-px flex-1 bg-slate-100"></span>
                    </div>
                    <p class="text-xs text-slate-400 mb-4">PDF, DOC, or DOCX. Employers can download this when you apply.</p>

                    <label for="resume-upload" id="resume-dropzone"
                           class="relative flex flex-col items-center justify-center gap-2 border-2 border-dashed border-slate-200 rounded-xl px-6 py-9 text-center cursor-pointer bg-slate-50/60 hover:bg-[#C9A54B]/[0.06] hover:border-[#C9A54B]/50 transition-colors">
                        <div class="w-11 h-11 rounded-full bg-[#0F2A4A] text-[#C9A54B] flex items-center justify-center">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>
                        <p class="text-sm font-medium text-slate-700">
                            <span id="resume-filename">
                                @if($profile->resume_path)
                                    Current file on record &mdash; click to replace
                                @else
                                    Click to upload, or drag and drop
                                @endif
                            </span>
                        </p>
                        <p class="text-xs text-slate-400">PDF, DOC or DOCX, up to 5&nbsp;MB</p>
                        <input id="resume-upload" type="file" name="resume" accept=".pdf,.doc,.docx"
                               class="absolute inset-0 h-full w-full opacity-0 cursor-pointer">
                    </label>
                </div>

            </div>

            {{-- Sidebar --}}
            <aside class="flex flex-col gap-4 lg:sticky lg:top-6">

                <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm shadow-[#0F2A4A]/5 p-5">
                    <h2 class="text-sm font-semibold text-[#0F2A4A] mb-4">Visibility</h2>

                    <div class="space-y-4">
                        <label class="flex items-start justify-between gap-3 cursor-pointer">
                            <span class="text-sm text-slate-700 leading-snug">
                                Open to opportunities
                                <span class="block text-xs text-slate-400 mt-0.5">Lets employers know you're actively looking</span>
                            </span>
                            <span class="relative inline-flex shrink-0 w-10 h-6 mt-0.5">
                                <input type="checkbox" name="is_available" value="1" @checked($profile->is_available) class="peer sr-only">
                                <span class="absolute inset-0 rounded-full bg-slate-200 peer-checked:bg-[#0F2A4A] peer-focus-visible:ring-2 peer-focus-visible:ring-[#C9A54B] peer-focus-visible:ring-offset-2 transition-colors pointer-events-none"></span>
                                <span class="absolute left-1 top-1 w-4 h-4 rounded-full bg-white shadow-sm transition-transform peer-checked:translate-x-4 peer-checked:bg-[#C9A54B] pointer-events-none"></span>
                            </span>
                        </label>

                        <label class="flex items-start justify-between gap-3 cursor-pointer">
                            <span class="text-sm text-slate-700 leading-snug">
                                Public profile
                                <span class="block text-xs text-slate-400 mt-0.5">Visible to employers browsing candidates</span>
                            </span>
                            <span class="relative inline-flex shrink-0 w-10 h-6 mt-0.5">
                                <input type="checkbox" name="profile_public" value="1" @checked($profile->profile_public) class="peer sr-only">
                                <span class="absolute inset-0 rounded-full bg-slate-200 peer-checked:bg-[#0F2A4A] peer-focus-visible:ring-2 peer-focus-visible:ring-[#C9A54B] peer-focus-visible:ring-offset-2 transition-colors pointer-events-none"></span>
                                <span class="absolute left-1 top-1 w-4 h-4 rounded-full bg-white shadow-sm transition-transform peer-checked:translate-x-4 peer-checked:bg-[#C9A54B] pointer-events-none"></span>
                            </span>
                        </label>
                    </div>
                </div>

                <button type="submit"
                        class="group relative w-full inline-flex items-center justify-center gap-2 bg-gradient-to-b from-[#18355C] to-[#0B213C] text-white font-semibold text-sm py-3.5 rounded-xl transition-all duration-200
                               shadow-[inset_0_1px_0_0_rgba(255,255,255,0.12),0_10px_24px_-8px_rgba(15,42,74,0.55)]
                               hover:shadow-[inset_0_1px_0_0_rgba(255,255,255,0.16),0_12px_28px_-6px_rgba(201,165,75,0.35)]
                               hover:from-[#1D3D68] hover:to-[#0F2A4A]
                               active:scale-[0.98]
                               focus:outline-none focus:ring-4 focus:ring-[#C9A54B]/25">
                    <span>Save changes</span>
                    <svg class="h-4 w-4 text-[#C9A54B] transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </button>

            </aside>

        </div>
    </form>
</div>

<script>
    (function () {
        var input = document.getElementById('resume-upload');
        var label = document.getElementById('resume-filename');
        var zone = document.getElementById('resume-dropzone');
        if (!input || !label || !zone) return;

        input.addEventListener('change', function () {
            if (input.files && input.files.length > 0) {
                label.textContent = input.files[0].name;
            }
        });

        ['dragover', 'dragenter'].forEach(function (evt) {
            zone.addEventListener(evt, function (e) {
                e.preventDefault();
                zone.classList.add('border-[#C9A54B]', 'bg-[#C9A54B]/[0.08]');
            });
        });
        ['dragleave', 'drop'].forEach(function (evt) {
            zone.addEventListener(evt, function () {
                zone.classList.remove('border-[#C9A54B]', 'bg-[#C9A54B]/[0.08]');
            });
        });
    })();
</script>
@endsection
