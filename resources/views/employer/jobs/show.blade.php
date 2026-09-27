@extends('layouts.employer')

@section('title', $job->title)

@section('content')
@php
    $statusStyles = match($job->status) {
        'approved' => 'bg-green-50 text-green-700 border-green-100',
        'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
        default => 'bg-gray-100 text-gray-500 border-gray-200',
    };

    $daysLeft = $job->deadline ? now()->startOfDay()->diffInDays($job->deadline->startOfDay(), false) : null;
    $isClosed = $daysLeft !== null && $daysLeft < 0;
    $isUrgent = $daysLeft !== null && $daysLeft >= 0 && $daysLeft <= 5;

    $formatNpr = fn ($amount) => 'Rs. ' . number_format($amount);
    $isOwner = auth()->check() && auth()->id() === $job->posted_by;

    // Deadline progress, based on the actual posting window rather than a guessed constant.
    $totalWindow = ($job->created_at && $job->deadline) ? $job->created_at->diffInDays($job->deadline) : null;
    $elapsed = $job->created_at ? $job->created_at->diffInDays(now()) : null;
    $percentElapsed = ($totalWindow && $totalWindow > 0) ? min(100, max(0, ($elapsed / $totalWindow) * 100)) : null;
    $progressColor = $isClosed ? 'bg-gray-300' : ($isUrgent ? 'bg-red-500' : 'bg-brand-500');
@endphp

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-10">

    <a href="{{ $isOwner ? route('employer.jobs.index') : route('jobs.index') }}"
       class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-brand-600 transition-colors mb-5">
        <i class="fa-solid fa-arrow-left text-xs"></i>
        {{ $isOwner ? 'Your job posts' : 'All jobs' }}
    </a>

    {{-- Header --}}
    <div class="relative bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8 mb-5 overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-brand-500 to-brand-700"></div>

        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6">
            <div class="flex items-start gap-4 min-w-0">
                <div class="w-16 h-16 shrink-0 rounded-2xl border border-gray-100 bg-gray-50 flex items-center justify-center overflow-hidden">
                    @if($job->company?->logo)
                        <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="w-full h-full object-contain">
                    @else
                        <span class="text-xl font-bold text-brand-700">
                            {{ substr($job->company->name ?? $job->title, 0, 1) }}
                        </span>
                    @endif
                </div>

                <div class="min-w-0">
                    <h1 class="text-2xl sm:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                        {{ $job->title }}
                    </h1>
                    <p class="flex items-center gap-1.5 text-gray-500 mt-1.5">
                        <i class="fa-solid fa-building text-gray-400 text-sm"></i>
                        {{ $job->company->name ?? 'Confidential company' }}
                    </p>
                </div>
            </div>

            @if($isOwner)
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('employer.jobs.edit', $job) }}"
                       class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-brand-600 border border-gray-200 hover:border-brand-300 rounded-lg px-3.5 py-2 transition-colors">
                        <i class="fa-solid fa-pen text-xs"></i> Edit
                    </a>
                    <a href="{{ route('employer.jobs.index') }}"
                       class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-brand-600 border border-gray-200 hover:border-brand-300 rounded-lg px-3.5 py-2 transition-colors">
                        <i class="fa-solid fa-list text-xs"></i> All jobs
                    </a>
                </div>
            @endif
        </div>

        <div class="flex flex-wrap gap-2 mt-5">
            <span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-full border {{ $statusStyles }}">
                {{ ucfirst($job->status) }}
            </span>
            @if($job->is_featured)
                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-orange-600 bg-orange-50 border border-orange-100 px-2.5 py-1 rounded-full">
                    <i class="fa-solid fa-star text-[10px]"></i> Featured
                </span>
            @endif
            @if($job->is_remote)
                <span class="inline-flex items-center gap-1 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-full">
                    <i class="fa-solid fa-house-laptop text-[10px]"></i> Remote
                </span>
            @endif
            @if($job->jobType?->name)
                <span class="inline-flex items-center gap-1 text-xs text-gray-600 bg-gray-50 border border-gray-100 rounded-full px-2.5 py-1">
                    <i class="fa-solid fa-briefcase text-gray-400 text-[10px]"></i> {{ $job->jobType->name }}
                </span>
            @endif
            @if($job->category?->name)
                <span class="inline-flex items-center gap-1 text-xs text-gray-600 bg-gray-50 border border-gray-100 rounded-full px-2.5 py-1">
                    <i class="fa-solid fa-tag text-gray-400 text-[10px]"></i> {{ $job->category->name }}
                </span>
            @endif
        </div>
    </div>

    {{-- Quick-facts strip: salary + deadline surfaced immediately, not buried in a sidebar --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 flex items-start gap-3.5">
            <div class="w-10 h-10 shrink-0 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-medium text-gray-400 mb-0.5">Salary</p>
                @if($job->salary_min || $job->salary_max)
                    <p class="text-lg font-bold text-gray-900 leading-tight truncate">
                        @if($job->salary_min && $job->salary_max)
                            {{ $formatNpr($job->salary_min) }}&ndash;{{ $formatNpr($job->salary_max) }}
                        @else
                            {{ $formatNpr($job->salary_min ?? $job->salary_max) }}+
                        @endif
                    </p>
                    <p class="text-xs text-gray-400">per month</p>
                @else
                    <p class="text-lg font-bold text-gray-400">Negotiable</p>
                @endif
            </div>
        </div>

        <div class="bg-white border rounded-2xl shadow-sm p-5 {{ $isUrgent && !$isClosed ? 'border-red-200' : 'border-gray-200' }}">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 shrink-0 rounded-xl flex items-center justify-center {{ $isUrgent && !$isClosed ? 'bg-red-50 text-red-600' : 'bg-brand-50 text-brand-600' }}">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-400 mb-0.5">Application deadline</p>
                    @if($job->deadline)
                        <p class="text-lg font-bold {{ $isUrgent && !$isClosed ? 'text-red-600' : 'text-gray-900' }} leading-tight">
                            {{ $job->deadline->format('j M, Y') }}
                        </p>
                        <p class="text-xs {{ $isUrgent && !$isClosed ? 'text-red-600 font-medium' : 'text-gray-400' }}">
                            @if($isClosed)
                                Closed {{ abs($daysLeft) }} {{ \Illuminate\Support\Str::plural('day', abs($daysLeft)) }} ago
                            @elseif($daysLeft === 0)
                                Closes today
                            @else
                                {{ $daysLeft }} {{ \Illuminate\Support\Str::plural('day', $daysLeft) }} left
                            @endif
                        </p>
                    @else
                        <p class="text-lg font-bold text-gray-400">Open-ended</p>
                    @endif
                </div>
            </div>
            @if($percentElapsed !== null)
                <div class="mt-3 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden" role="progressbar"
                     aria-valuenow="{{ round($percentElapsed) }}" aria-valuemin="0" aria-valuemax="100"
                     aria-label="Proportion of the application window elapsed">
                    <div class="h-full rounded-full {{ $progressColor }}" style="width: {{ $percentElapsed }}%"></div>
                </div>
            @endif
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 flex items-start gap-3.5">
            <div class="w-10 h-10 shrink-0 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="min-w-0">
                @if($isOwner)
                    <p class="text-xs font-medium text-gray-400 mb-0.5">Applications received</p>
                    <p class="text-lg font-bold text-gray-900 leading-tight">{{ $job->applications_count ?? 0 }}</p>
                @else
                    <p class="text-xs font-medium text-gray-400 mb-0.5">Work mode</p>
                    <p class="text-lg font-bold text-gray-900 leading-tight">{{ $job->is_remote ? 'Remote' : 'On-site' }}</p>
                @endif
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-6 items-start">

        {{-- Main content --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8 divide-y divide-gray-100">

            <div class="pb-7">
                <h2 class="flex items-center gap-2 text-lg font-semibold text-gray-900 mb-3">
                    <i class="fa-regular fa-file-lines text-brand-500 text-base"></i> About this role
                </h2>
                <div class="text-gray-700 leading-relaxed whitespace-pre-line max-w-[65ch]">{{ $job->description }}</div>
            </div>

            @if($job->responsibilities)
                <div class="py-7">
                    <h2 class="flex items-center gap-2 text-lg font-semibold text-gray-900 mb-3">
                        <i class="fa-solid fa-list-check text-brand-500 text-base"></i> Responsibilities
                    </h2>
                    <ul class="space-y-2.5 max-w-[65ch]">
                        @foreach(preg_split('/\r\n|\r|\n/', trim($job->responsibilities)) as $line)
                            @continue(trim($line) === '')
                            <li class="flex items-start gap-2.5 text-gray-700 leading-relaxed">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-500 mt-2.5 shrink-0"></span>
                                <span>{{ ltrim(trim($line), '-•* ') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($job->requirements)
                <div class="py-7">
                    <h2 class="flex items-center gap-2 text-lg font-semibold text-gray-900 mb-3">
                        <i class="fa-solid fa-clipboard-check text-brand-500 text-base"></i> Requirements
                    </h2>
                    <ul class="space-y-2.5 max-w-[65ch]">
                        @foreach(preg_split('/\r\n|\r|\n/', trim($job->requirements)) as $line)
                            @continue(trim($line) === '')
                            <li class="flex items-start gap-2.5 text-gray-700 leading-relaxed">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-500 mt-2.5 shrink-0"></span>
                                <span>{{ ltrim(trim($line), '-•* ') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($job->skills && $job->skills->isNotEmpty())
                <div class="pt-7">
                    <h2 class="flex items-center gap-2 text-lg font-semibold text-gray-900 mb-3">
                        <i class="fa-solid fa-layer-group text-brand-500 text-base"></i> Skills
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($job->skills as $skill)
                            <span class="text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5">
                                {{ $skill->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <aside class="flex flex-col gap-4 lg:sticky lg:top-6">

            @if(!$isOwner)
                @if($isClosed)
                    <span
                        class="hidden lg:flex items-center justify-center gap-2 bg-gray-100 text-gray-400 font-semibold text-sm py-3.5 rounded-xl cursor-not-allowed"
                        role="button" tabindex="-1" aria-disabled="true"
                    >
                        Applications closed
                    </span>
                @else
                    @include('partials._apply_button', ['job' => $job, 'variant' => 'desktop'])
                @endif
            @endif

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                <dl class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <dt class="text-gray-400">Job type</dt>
                        <dd class="font-semibold text-gray-900">{{ $job->jobType->name ?? '—' }}</dd>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <dt class="text-gray-400">Category</dt>
                        <dd class="font-semibold text-gray-900">{{ $job->category->name ?? '—' }}</dd>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <dt class="text-gray-400">Work mode</dt>
                        <dd class="font-semibold text-gray-900">{{ $job->is_remote ? 'Remote' : 'On-site' }}</dd>
                    </div>
                </dl>
            </div>

        </aside>

    </div>

</div>

{{-- Mobile sticky apply bar: on a stacked layout the sidebar sits below all content, --}}
{{-- so without this, Apply Now would require scrolling past the entire job description. --}}
@if(!$isOwner && !$isClosed)
    <div class="lg:hidden fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 shadow-[0_-4px_12px_rgba(0,0,0,0.06)] px-4 py-3 flex items-center justify-between gap-3 z-40">
        <div class="min-w-0">
            <p class="text-xs text-gray-400">Salary</p>
            <p class="text-sm font-bold text-gray-900 truncate">
                @if($job->salary_min || $job->salary_max)
                    @if($job->salary_min && $job->salary_max)
                        {{ $formatNpr($job->salary_min) }}&ndash;{{ $formatNpr($job->salary_max) }}
                    @else
                        {{ $formatNpr($job->salary_min ?? $job->salary_max) }}+
                    @endif
                @else
                    Negotiable
                @endif
            </p>
        </div>
        <div class="shrink-0">
            @include('partials._apply_button', ['job' => $job, 'variant' => 'mobile'])
        </div>
    </div>
    <div class="lg:hidden h-20"></div>
@elseif(!$isOwner && $isClosed)
    <div class="lg:hidden fixed bottom-0 inset-x-0 bg-gray-50 border-t border-gray-200 px-4 py-3 text-center text-sm font-medium text-gray-400 z-40">
        Applications closed
    </div>
    <div class="lg:hidden h-14"></div>
@endif
@endsection
