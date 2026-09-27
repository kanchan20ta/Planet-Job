@extends('layouts.panel')
@section('title', 'Build Your CV - Planet Job Portal')

@php
$panelTitle = 'My Account';
$panelLinks = [
    ['label' => 'Dashboard', 'url' => route('jobseeker.dashboard'), 'active' => 'jobseeker.dashboard'],
    ['label' => 'My Profile', 'url' => route('jobseeker.profile.edit'), 'active' => 'jobseeker.profile.*'],
    ['label' => 'Build Your CV', 'url' => route('jobseeker.cv.build'), 'active' => 'jobseeker.cv.*'],
    ['label' => 'My Applications', 'url' => route('jobseeker.applications.index'), 'active' => 'jobseeker.applications.*'],
    ['label' => 'Saved Jobs', 'url' => route('jobseeker.saved-jobs.index'), 'active' => 'jobseeker.saved-jobs.*'],
    ['label' => 'Job Alerts', 'url' => route('jobseeker.job-alerts.index'), 'active' => 'jobseeker.job-alerts.*'],
];

// Ordered list drives both the left rail and the anchor targets below —
// it is a genuine build sequence, so numbering it is meaningful here.
$cvSections = [
    ['id' => 'personal',       'label' => 'Personal information'],
    ['id' => 'summary',        'label' => 'Professional summary'],
    ['id' => 'experience',     'label' => 'Work experience'],
    ['id' => 'education',      'label' => 'Education'],
    ['id' => 'skills',         'label' => 'Skills'],
    ['id' => 'certifications', 'label' => 'Certifications'],
    ['id' => 'languages',      'label' => 'Languages'],
    ['id' => 'projects',       'label' => 'Projects'],
];
@endphp

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    .cv-serif { font-family: 'Fraunces', 'Georgia', serif; font-feature-settings: 'ss01' 1; }
    .cv-sans  { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    .cv-field { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    .cv-field:focus {
        outline: none;
        border-color: #B8863D;
        box-shadow: 0 0 0 3px rgba(184, 134, 61, 0.15);
    }
    .cv-rail a.is-active { color: #0A1F38; }
    .cv-rail a.is-active .cv-rail-dot { background-color: #B8863D; border-color: #B8863D; color: #fff; }
</style>
@endpush

@section('panel-content')
<div class="max-w-6xl cv-sans" x-data="cvBuilder()" x-init="init()">

    <div class="mb-10 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="cv-serif text-[2rem] leading-tight text-[#0A1F38] tracking-tight">Build your CV</h1>
            <p class="text-sm text-[#5B6B7C] mt-2 max-w-md">
                We've carried over what's already on your profile. Work through each
                section below — nothing here is final until you say so.
            </p>
        </div>
        <div class="text-sm text-[#5B6B7C] sm:text-right">
            8 sections to fill in
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-[220px_1fr] lg:gap-10">

        {{-- Left rail: section outline --}}
        <nav class="cv-rail hidden lg:block sticky top-24 self-start">
            <ol class="space-y-1">
                @foreach ($cvSections as $i => $section)
                <li>
                    <a href="#{{ $section['id'] }}"
                       class="group flex items-center gap-3 py-2 text-sm text-[#5B6B7C] hover:text-[#0A1F38] transition-colors {{ $loop->first ? 'is-active' : '' }}">
                        <span class="cv-rail-dot flex h-6 w-6 shrink-0 items-center justify-center rounded-full border border-slate-300 text-[11px] text-[#5B6B7C] group-hover:border-[#B8863D] transition-colors">
                            {{ $i + 1 }}
                        </span>
                        <span>{{ $section['label'] }}</span>
                    </a>
                </li>
                @endforeach
            </ol>
        </nav>

        {{-- Mobile section chips --}}
        <div class="lg:hidden -mx-1 mb-8 flex gap-2 overflow-x-auto pb-2">
            @foreach ($cvSections as $i => $section)
            <a href="#{{ $section['id'] }}"
               class="shrink-0 rounded-full border border-slate-200 bg-white px-3.5 py-1.5 text-xs text-[#0A1F38] whitespace-nowrap">
                {{ $i + 1 }}. {{ $section['label'] }}
            </a>
            @endforeach
        </div>

        <form method="POST" action="{{ route('jobseeker.cv.download') }}" enctype="multipart/form-data" class="space-y-14">
            @csrf

            {{-- ============ PERSONAL INFORMATION (hero panel) ============ --}}
            <section id="personal" class="scroll-mt-24">
                <div class="rounded-3xl border border-[#0F2A4A]/10 bg-white shadow-sm shadow-[#0F2A4A]/5 p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-start gap-6">
                        <label class="group relative flex h-24 w-24 shrink-0 cursor-pointer items-center justify-center rounded-full border-2 border-dashed border-[#B8863D]/40 bg-[#FBF6EC] text-[#B8863D] hover:border-[#B8863D] transition-colors">
                            <input type="file" name="photo" accept="image/*" class="sr-only">
                            <span class="cv-serif text-xs text-center px-2 leading-tight">Add<br>photo</span>
                        </label>
                        <div class="flex-1 min-w-0">
                            <h2 class="cv-serif text-xl text-[#0A1F38] mb-1">Personal information</h2>
                            <p class="text-sm text-[#5B6B7C] mb-6">How employers will identify and reach you.</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="full_name" class="block text-sm text-[#0A1F38] mb-1.5">Full name</label>
                                    <input type="text" id="full_name" name="full_name" placeholder="Aarav Sharma"
                                           class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                                </div>
                                <div>
                                    <label for="professional_title" class="block text-sm text-[#0A1F38] mb-1.5">Professional title</label>
                                    <input type="text" id="professional_title" name="professional_title" placeholder="Product Designer"
                                           class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm text-[#0A1F38] mb-1.5">Email address</label>
                                    <input type="email" id="email" name="email" placeholder="you@example.com"
                                           class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm text-[#0A1F38] mb-1.5">Phone number</label>
                                    <input type="tel" id="phone" name="phone" placeholder="+977 98-XXXXXXXX"
                                           class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                                </div>
                                <div>
                                    <label for="location" class="block text-sm text-[#0A1F38] mb-1.5">Location</label>
                                    <input type="text" id="location" name="location" placeholder="Kathmandu, Nepal"
                                           class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                                </div>
                                <div>
                                    <label for="portfolio_url" class="block text-sm text-[#0A1F38] mb-1.5">Portfolio or LinkedIn</label>
                                    <input type="url" id="portfolio_url" name="portfolio_url" placeholder="https://"
                                           class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ============ PROFESSIONAL SUMMARY ============ --}}
            <section id="summary" class="scroll-mt-24">
                <div class="flex items-baseline justify-between mb-1">
                    <h2 class="cv-serif text-xl text-[#0A1F38]">Professional summary</h2>
                </div>
                <div class="h-px w-full bg-gradient-to-r from-[#B8863D]/50 to-transparent mb-5"></div>
                <p class="text-sm text-[#5B6B7C] mb-4 max-w-xl">
                    Three or four sentences on who you are professionally and what you're
                    looking for next. This appears directly under your name on the finished CV.
                </p>
                <textarea name="professional_summary" rows="4" placeholder="Experienced software engineer with a background in..."
                          class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-3 text-sm text-[#0A1F38] placeholder:text-slate-400"></textarea>
            </section>

            {{-- ============ WORK EXPERIENCE (repeatable) ============ --}}
            <section id="experience" class="scroll-mt-24">
                <div class="flex items-baseline justify-between mb-1">
                    <h2 class="cv-serif text-xl text-[#0A1F38]">Work experience</h2>
                </div>
                <div class="h-px w-full bg-gradient-to-r from-[#B8863D]/50 to-transparent mb-5"></div>

                <template x-for="(row, index) in experience" :key="row.key">
                    <div class="relative mb-4 rounded-2xl border border-slate-200 p-5">
                        <button type="button" @click="experience.length > 1 && experience.splice(index, 1)"
                                x-show="experience.length > 1"
                                class="absolute top-4 right-4 text-xs text-[#5B6B7C] hover:text-[#0A1F38]">
                            Remove
                        </button>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Job title</label>
                                <input type="text" :name="`experience[${index}][title]`" placeholder="Senior Engineer"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Company</label>
                                <input type="text" :name="`experience[${index}][company]`" placeholder="Company name"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Location</label>
                                <input type="text" :name="`experience[${index}][location]`" placeholder="City, Country"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm text-[#0A1F38] mb-1.5">Start date</label>
                                    <input type="month" :name="`experience[${index}][start_date]`"
                                           class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38]">
                                </div>
                                <div>
                                    <label class="block text-sm text-[#0A1F38] mb-1.5">End date</label>
                                    <input type="month" :name="`experience[${index}][end_date]`" x-bind:disabled="row.current"
                                           class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] disabled:bg-slate-50 disabled:text-slate-400">
                                </div>
                            </div>
                        </div>
                        <label class="mt-3 inline-flex items-center gap-2 text-sm text-[#5B6B7C]">
                            <input type="checkbox" x-model="row.current" :name="`experience[${index}][is_current]`" value="1"
                                   class="rounded border-slate-300 text-[#B8863D] focus:ring-[#B8863D]">
                            I currently work here
                        </label>
                        <div class="mt-4">
                            <label class="block text-sm text-[#0A1F38] mb-1.5">What did you do?</label>
                            <textarea :name="`experience[${index}][description]`" rows="3" placeholder="Led the redesign of..."
                                      class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400"></textarea>
                        </div>
                    </div>
                </template>

                <button type="button" @click="experience.push(newRow())"
                        class="inline-flex items-center gap-1.5 text-sm text-[#0A1F38] border border-slate-200 rounded-xl px-4 py-2 hover:border-[#B8863D] hover:text-[#B8863D] transition-colors">
                    Add another role
                </button>
            </section>

            {{-- ============ EDUCATION (repeatable) ============ --}}
            <section id="education" class="scroll-mt-24">
                <div class="flex items-baseline justify-between mb-1">
                    <h2 class="cv-serif text-xl text-[#0A1F38]">Education</h2>
                </div>
                <div class="h-px w-full bg-gradient-to-r from-[#B8863D]/50 to-transparent mb-5"></div>

                <template x-for="(row, index) in education" :key="row.key">
                    <div class="relative mb-4 rounded-2xl border border-slate-200 p-5">
                        <button type="button" @click="education.length > 1 && education.splice(index, 1)"
                                x-show="education.length > 1"
                                class="absolute top-4 right-4 text-xs text-[#5B6B7C] hover:text-[#0A1F38]">
                            Remove
                        </button>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Degree or qualification</label>
                                <input type="text" :name="`education[${index}][degree]`" placeholder="B.Sc. Computer Science"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Institution</label>
                                <input type="text" :name="`education[${index}][institution]`" placeholder="University name"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm text-[#0A1F38] mb-1.5">Start year</label>
                                    <input type="number" :name="`education[${index}][start_year]`" placeholder="2019" min="1950" max="2100"
                                           class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                                </div>
                                <div>
                                    <label class="block text-sm text-[#0A1F38] mb-1.5">End year</label>
                                    <input type="number" :name="`education[${index}][end_year]`" placeholder="2023" min="1950" max="2100"
                                           class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Location</label>
                                <input type="text" :name="`education[${index}][location]`" placeholder="City, Country"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                        </div>
                    </div>
                </template>

                <button type="button" @click="education.push(newRow())"
                        class="inline-flex items-center gap-1.5 text-sm text-[#0A1F38] border border-slate-200 rounded-xl px-4 py-2 hover:border-[#B8863D] hover:text-[#B8863D] transition-colors">
                    Add another qualification
                </button>
            </section>

            {{-- ============ SKILLS (repeatable, with proficiency) ============ --}}
            <section id="skills" class="scroll-mt-24">
                <div class="flex items-baseline justify-between mb-1">
                    <h2 class="cv-serif text-xl text-[#0A1F38]">Skills</h2>
                </div>
                <div class="h-px w-full bg-gradient-to-r from-[#B8863D]/50 to-transparent mb-5"></div>

                <div class="space-y-2.5">
                    <template x-for="(row, index) in skills" :key="row.key">
                        <div class="flex flex-col sm:flex-row gap-2.5">
                            <input type="text" :name="`skills[${index}][name]`" placeholder="e.g. Figma, Laravel, Negotiation"
                                   class="cv-field flex-1 rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            <select :name="`skills[${index}][level]`"
                                    class="cv-field rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] sm:w-44">
                                <option value="">Level</option>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                                <option value="expert">Expert</option>
                            </select>
                            <button type="button" @click="skills.length > 1 && skills.splice(index, 1)"
                                    x-show="skills.length > 1"
                                    class="shrink-0 text-xs text-[#5B6B7C] hover:text-[#0A1F38] sm:px-2">
                                Remove
                            </button>
                        </div>
                    </template>
                </div>

                <button type="button" @click="skills.push(newRow())"
                        class="mt-3 inline-flex items-center gap-1.5 text-sm text-[#0A1F38] border border-slate-200 rounded-xl px-4 py-2 hover:border-[#B8863D] hover:text-[#B8863D] transition-colors">
                    Add another skill
                </button>
            </section>

            {{-- ============ CERTIFICATIONS (repeatable) ============ --}}
            <section id="certifications" class="scroll-mt-24">
                <div class="flex items-baseline justify-between mb-1">
                    <h2 class="cv-serif text-xl text-[#0A1F38]">Certifications</h2>
                </div>
                <div class="h-px w-full bg-gradient-to-r from-[#B8863D]/50 to-transparent mb-5"></div>

                <template x-for="(row, index) in certifications" :key="row.key">
                    <div class="relative mb-4 rounded-2xl border border-slate-200 p-5">
                        <button type="button" @click="certifications.length > 1 && certifications.splice(index, 1)"
                                x-show="certifications.length > 1"
                                class="absolute top-4 right-4 text-xs text-[#5B6B7C] hover:text-[#0A1F38]">
                            Remove
                        </button>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Certification name</label>
                                <input type="text" :name="`certifications[${index}][name]`" placeholder="AWS Certified Solutions Architect"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Issuing organization</label>
                                <input type="text" :name="`certifications[${index}][issuer]`" placeholder="Amazon Web Services"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Issue date</label>
                                <input type="month" :name="`certifications[${index}][issue_date]`"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38]">
                            </div>
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Credential URL</label>
                                <input type="url" :name="`certifications[${index}][url]`" placeholder="https://"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                        </div>
                    </div>
                </template>

                <button type="button" @click="certifications.push(newRow())"
                        class="inline-flex items-center gap-1.5 text-sm text-[#0A1F38] border border-slate-200 rounded-xl px-4 py-2 hover:border-[#B8863D] hover:text-[#B8863D] transition-colors">
                    Add another certification
                </button>
            </section>

            {{-- ============ LANGUAGES (repeatable) ============ --}}
            <section id="languages" class="scroll-mt-24">
                <div class="flex items-baseline justify-between mb-1">
                    <h2 class="cv-serif text-xl text-[#0A1F38]">Languages</h2>
                </div>
                <div class="h-px w-full bg-gradient-to-r from-[#B8863D]/50 to-transparent mb-5"></div>

                <div class="space-y-2.5">
                    <template x-for="(row, index) in languages" :key="row.key">
                        <div class="flex flex-col sm:flex-row gap-2.5">
                            <input type="text" :name="`languages[${index}][name]`" placeholder="e.g. Nepali, English, Hindi"
                                   class="cv-field flex-1 rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            <select :name="`languages[${index}][level]`"
                                    class="cv-field rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] sm:w-44">
                                <option value="">Fluency</option>
                                <option value="basic">Basic</option>
                                <option value="conversational">Conversational</option>
                                <option value="fluent">Fluent</option>
                                <option value="native">Native</option>
                            </select>
                            <button type="button" @click="languages.length > 1 && languages.splice(index, 1)"
                                    x-show="languages.length > 1"
                                    class="shrink-0 text-xs text-[#5B6B7C] hover:text-[#0A1F38] sm:px-2">
                                Remove
                            </button>
                        </div>
                    </template>
                </div>

                <button type="button" @click="languages.push(newRow())"
                        class="mt-3 inline-flex items-center gap-1.5 text-sm text-[#0A1F38] border border-slate-200 rounded-xl px-4 py-2 hover:border-[#B8863D] hover:text-[#B8863D] transition-colors">
                    Add another language
                </button>
            </section>

            {{-- ============ PROJECTS (repeatable) ============ --}}
            <section id="projects" class="scroll-mt-24">
                <div class="flex items-baseline justify-between mb-1">
                    <h2 class="cv-serif text-xl text-[#0A1F38]">Projects</h2>
                </div>
                <div class="h-px w-full bg-gradient-to-r from-[#B8863D]/50 to-transparent mb-5"></div>

                <template x-for="(row, index) in projects" :key="row.key">
                    <div class="relative mb-4 rounded-2xl border border-slate-200 p-5">
                        <button type="button" @click="projects.length > 1 && projects.splice(index, 1)"
                                x-show="projects.length > 1"
                                class="absolute top-4 right-4 text-xs text-[#5B6B7C] hover:text-[#0A1F38]">
                            Remove
                        </button>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Project name</label>
                                <input type="text" :name="`projects[${index}][name]`" placeholder="Portfolio website"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Your role</label>
                                <input type="text" :name="`projects[${index}][role]`" placeholder="Lead developer"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Project link</label>
                                <input type="url" :name="`projects[${index}][url]`" placeholder="https://"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                            <div>
                                <label class="block text-sm text-[#0A1F38] mb-1.5">Technologies used</label>
                                <input type="text" :name="`projects[${index}][tech]`" placeholder="React, Node.js, PostgreSQL"
                                       class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm text-[#0A1F38] mb-1.5">Description</label>
                            <textarea :name="`projects[${index}][description]`" rows="3" placeholder="What the project does and the impact it had..."
                                      class="cv-field w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-[#0A1F38] placeholder:text-slate-400"></textarea>
                        </div>
                    </div>
                </template>

                <button type="button" @click="projects.push(newRow())"
                        class="inline-flex items-center gap-1.5 text-sm text-[#0A1F38] border border-slate-200 rounded-xl px-4 py-2 hover:border-[#B8863D] hover:text-[#B8863D] transition-colors">
                    Add another project
                </button>
            </section>

            {{-- Sticky action bar --}}
            <div class="sticky bottom-4 z-10">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 rounded-2xl border border-[#0F2A4A]/10 bg-white/95 backdrop-blur px-5 py-4 shadow-sm shadow-[#0F2A4A]/10">
                    <p class="text-xs text-[#5B6B7C] text-center sm:text-left">
                        Your finished CV will carry a small "Built by Planet Job" line in its footer.
                    </p>
                    <div class="flex gap-3">
                        <button type="submit" formaction="{{ route('jobseeker.cv.preview') }}"
                                class="rounded-xl border border-[#B8863D] text-[#B8863D] text-sm px-5 py-2.5 hover:bg-[#FBF6EC] transition-colors">
                            Preview CV
                        </button>
                        <button type="submit" formaction="{{ route('jobseeker.cv.download') }}"
                                class="rounded-xl bg-[#0A1F38] text-white text-sm px-5 py-2.5 hover:bg-[#0F2A4A] transition-colors">
                            Save as PDF
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

{{--
    Generated CV output:
    The "Preview CV" and "Save as PDF" buttons render this data through
    resources/views/jobseeker/cv/preview.blade.php and
    resources/views/jobseeker/cv/pdf.blade.php, both of which include the
    "Built by Planet Job" footer.
--}}

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/cdn.min.js" defer></script>
<script>
    function cvBuilder() {
        return {
            experience: [],
            education: [],
            skills: [],
            certifications: [],
            languages: [],
            projects: [],
            _seq: 0,
            newRow() {
                this._seq++;
                return { key: this._seq, current: false };
            },
            init() {
                this.experience = [this.newRow()];
                this.education = [this.newRow()];
                this.skills = [this.newRow()];
                this.certifications = [this.newRow()];
                this.languages = [this.newRow()];
                this.projects = [this.newRow()];
            }
        }
    }
</script>
@endpush
