@extends('layouts.app')
@section('title', $company->name . ' - Planet Job Portal')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    .font-display { font-family: 'Space Grotesk', ui-sans-serif, system-ui, sans-serif; }
    .font-body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
</style>
@endpush

@section('content')
<div class="font-body bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-10 sm:py-14">

        {{-- Cover + identity --}}
        <div class="relative rounded-2xl overflow-hidden bg-slate-100">
            <div class="h-44 sm:h-64 w-full">
                @if ($company->cover_image)
                    <img src="{{ asset('storage/' . $company->cover_image) }}"
                         alt="" class="h-full w-full object-cover">
                @else
                    <div class="h-full w-full bg-gradient-to-br from-slate-100 to-slate-200"></div>
                @endif
            </div>

            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent pt-16 pb-5 px-5 sm:px-8">
                <div class="flex items-end gap-4">
                    <div class="shrink-0 h-16 w-16 sm:h-20 sm:w-20 rounded-xl bg-white ring-4 ring-white shadow-sm overflow-hidden flex items-center justify-center">
                        @if ($company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }} logo"
                                 class="h-full w-full object-cover">
                        @else
                            <span class="font-display text-lg text-slate-400">{{ substr($company->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="min-w-0 pb-1">
                        <h1 class="font-display text-2xl sm:text-3xl font-semibold text-white leading-tight truncate">
                            {{ $company->name }}
                        </h1>
                        @if ($company->industry)
                            <p class="text-sm text-white/80 mt-0.5">{{ $company->industry }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick facts row --}}
        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-5 pb-6 border-b border-slate-200 text-sm text-slate-500">
            @if ($company->city)
                <span class="inline-flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    {{ $company->city }}
                </span>
            @endif
            @if ($company->company_size)
                <span class="inline-flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    {{ $company->company_size }} employees
                </span>
            @endif
            @if ($company->website)
                <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-1.5 text-brand-600 hover:text-brand-700 font-medium">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m-15.432 0A8.959 8.959 0 013 12c0-.778.099-1.533.284-2.253" />
                    </svg>
                    Visit website
                </a>
            @endif
        </div>

        {{-- Main content --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 mt-8">
            <div class="sm:col-span-2">
                <h2 class="font-display text-lg font-semibold text-slate-900 mb-3">About {{ $company->name }}</h2>
                @if ($company->description)
                    <p class="text-slate-600 leading-relaxed max-w-[65ch] whitespace-pre-line">{{ $company->description }}</p>
                @else
                    <p class="text-slate-400 italic">This company hasn't added a description yet.</p>
                @endif
            </div>

            <div class="sm:col-span-1">
                <h2 class="font-display text-lg font-semibold text-slate-900 mb-3">Company details</h2>
                <dl class="text-sm divide-y divide-slate-100 border-t border-slate-100">
                    <div class="flex justify-between gap-4 py-3">
                        <dt class="text-slate-500">Industry</dt>
                        <dd class="text-slate-900 text-right">{{ $company->industry ?: '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4 py-3">
                        <dt class="text-slate-500">Company size</dt>
                        <dd class="text-slate-900 text-right">{{ $company->company_size ?: '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4 py-3">
                        <dt class="text-slate-500">City</dt>
                        <dd class="text-slate-900 text-right">{{ $company->city ?: '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4 py-3">
                        <dt class="text-slate-500">Email</dt>
                        <dd class="text-right">
                            @if ($company->email)
                                <a href="mailto:{{ $company->email }}" class="text-brand-600 hover:text-brand-700">{{ $company->email }}</a>
                            @else
                                —
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between gap-4 py-3">
                        <dt class="text-slate-500">Phone</dt>
                        <dd class="text-slate-900 text-right">{{ $company->phone ?: '—' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
