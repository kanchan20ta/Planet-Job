@extends('layouts.panel')
@section('title', 'CV Preview - Planet Job Portal')

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
@endphp

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    .cv-serif { font-family: 'Fraunces', 'Georgia', serif; }
    .cv-sans  { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
</style>
@endpush

@section('panel-content')
<div class="max-w-3xl cv-sans">

    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="cv-serif text-2xl text-[#0A1F38] tracking-tight">Preview your CV</h1>
            <p class="text-sm text-[#5B6B7C] mt-1">This is exactly what employers will see.</p>
        </div>
        <div class="flex gap-3 shrink-0">
            <a href="{{ route('jobseeker.cv.build') }}"
               class="rounded-xl border border-slate-200 text-[#0A1F38] text-sm px-4 py-2.5 hover:border-[#B8863D] transition-colors">
                Back to editing
            </a>
            <a href="{{ route('jobseeker.cv.pdf') }}"
               class="rounded-xl bg-[#0A1F38] text-white text-sm px-4 py-2.5 hover:bg-[#0F2A4A] transition-colors">
                Download PDF
            </a>
        </div>
    </div>

    <div class="rounded-3xl border border-[#0F2A4A]/10 bg-white shadow-sm shadow-[#0F2A4A]/5 p-8 sm:p-10">

        <div class="mb-8">
            <h2 class="cv-serif text-2xl text-[#0A1F38]">{{ ($cv['full_name'] ?? null) ?: 'Your name' }}</h2>
            @if(!empty($cv['professional_title']))
                <p class="text-sm text-[#5B6B7C] mt-0.5">{{ $cv['professional_title'] }}</p>
            @endif
            <p class="text-xs text-[#5B6B7C] mt-3 flex flex-wrap gap-x-3 gap-y-1">
                @foreach (array_filter([$cv['email'] ?? null, $cv['phone'] ?? null, $cv['location'] ?? null, $cv['portfolio_url'] ?? null]) as $item)
                    <span>{{ $item }}</span>
                @endforeach
            </p>
        </div>

        @if(!empty($cv['professional_summary']))
        <div class="mb-8">
            <h3 class="cv-serif text-base text-[#0A1F38] pb-2 mb-3 border-b border-[#B8863D]/40">Professional summary</h3>
            <p class="text-sm text-[#354356] leading-relaxed">{{ $cv['professional_summary'] }}</p>
        </div>
        @endif

        @if(!empty(array_filter($cv['experience'] ?? [])))
        <div class="mb-8">
            <h3 class="cv-serif text-base text-[#0A1F38] pb-2 mb-3 border-b border-[#B8863D]/40">Work experience</h3>
            <div class="space-y-4">
                @foreach ($cv['experience'] as $row)
                    @continue(empty($row['title']) && empty($row['company']))
                    <div>
                        <p class="text-sm font-medium text-[#0A1F38]">
                            {{ $row['title'] ?? '' }}@if(!empty($row['company'])) — {{ $row['company'] }}@endif
                        </p>
                        <p class="text-xs text-[#5B6B7C] mt-0.5">
                            {{ $row['location'] ?? '' }}
                            @if(!empty($row['start_date']))
                                · {{ \Illuminate\Support\Carbon::parse($row['start_date'])->format('M Y') }}
                                – {{ !empty($row['is_current']) ? 'Present' : (!empty($row['end_date']) ? \Illuminate\Support\Carbon::parse($row['end_date'])->format('M Y') : '') }}
                            @endif
                        </p>
                        @if(!empty($row['description']))
                            <p class="text-sm text-[#354356] mt-1.5 leading-relaxed">{{ $row['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(!empty(array_filter($cv['education'] ?? [])))
        <div class="mb-8">
            <h3 class="cv-serif text-base text-[#0A1F38] pb-2 mb-3 border-b border-[#B8863D]/40">Education</h3>
            <div class="space-y-3">
                @foreach ($cv['education'] as $row)
                    @continue(empty($row['degree']) && empty($row['institution']))
                    <div>
                        <p class="text-sm font-medium text-[#0A1F38]">{{ $row['degree'] ?? '' }}</p>
                        <p class="text-xs text-[#5B6B7C] mt-0.5">
                            {{ $row['institution'] ?? '' }}
                            @if(!empty($row['location'])) · {{ $row['location'] }} @endif
                            @if(!empty($row['start_year']) || !empty($row['end_year']))
                                · {{ $row['start_year'] ?? '' }}–{{ $row['end_year'] ?? '' }}
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(!empty(array_filter($cv['skills'] ?? [])))
        <div class="mb-8">
            <h3 class="cv-serif text-base text-[#0A1F38] pb-2 mb-3 border-b border-[#B8863D]/40">Skills</h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($cv['skills'] as $row)
                    @continue(empty($row['name']))
                    <span class="rounded-md border border-[#B8863D]/30 bg-[#FBF6EC] text-[#7A5A20] text-xs px-2.5 py-1">
                        {{ $row['name'] }}@if(!empty($row['level'])) · {{ ucfirst($row['level']) }}@endif
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        @if(!empty(array_filter($cv['certifications'] ?? [])))
        <div class="mb-8">
            <h3 class="cv-serif text-base text-[#0A1F38] pb-2 mb-3 border-b border-[#B8863D]/40">Certifications</h3>
            <div class="space-y-3">
                @foreach ($cv['certifications'] as $row)
                    @continue(empty($row['name']))
                    <div>
                        <p class="text-sm font-medium text-[#0A1F38]">{{ $row['name'] }}</p>
                        <p class="text-xs text-[#5B6B7C] mt-0.5">
                            {{ $row['issuer'] ?? '' }}
                            @if(!empty($row['issue_date'])) · {{ \Illuminate\Support\Carbon::parse($row['issue_date'])->format('M Y') }} @endif
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(!empty(array_filter($cv['languages'] ?? [])))
        <div class="mb-8">
            <h3 class="cv-serif text-base text-[#0A1F38] pb-2 mb-3 border-b border-[#B8863D]/40">Languages</h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($cv['languages'] as $row)
                    @continue(empty($row['name']))
                    <span class="rounded-md border border-[#B8863D]/30 bg-[#FBF6EC] text-[#7A5A20] text-xs px-2.5 py-1">
                        {{ $row['name'] }}@if(!empty($row['level'])) · {{ ucfirst($row['level']) }}@endif
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        @if(!empty(array_filter($cv['projects'] ?? [])))
        <div class="mb-2">
            <h3 class="cv-serif text-base text-[#0A1F38] pb-2 mb-3 border-b border-[#B8863D]/40">Projects</h3>
            <div class="space-y-4">
                @foreach ($cv['projects'] as $row)
                    @continue(empty($row['name']))
                    <div>
                        <p class="text-sm font-medium text-[#0A1F38]">
                            {{ $row['name'] }}@if(!empty($row['role'])) — {{ $row['role'] }}@endif
                        </p>
                        @if(!empty($row['tech']))
                            <p class="text-xs text-[#5B6B7C] mt-0.5">{{ $row['tech'] }}</p>
                        @endif
                        @if(!empty($row['description']))
                            <p class="text-sm text-[#354356] mt-1.5 leading-relaxed">{{ $row['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <p class="text-center text-xs text-slate-300 mt-10 pt-6 border-t border-slate-100">Built by Planet Job</p>
    </div>
</div>
@endsection
