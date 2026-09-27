@extends('layouts.app')
@section('title', 'FAQ - Planet Job Portal')

@section('content')

@php
    // Friendly labels + icons per category, with sensible fallbacks so this
    // still works cleanly if new categories are added in the database later.
    $categoryLabels = [
        'jobseeker' => 'Job Seekers',
        'job_seeker' => 'Job Seekers',
        'employer' => 'Employers',
        'general' => 'General',
        'account' => 'Account & Settings',
        'payment' => 'Payments & Subscriptions',
    ];
    $categoryIcons = [
        'jobseeker' => 'fa-user',
        'job_seeker' => 'fa-user',
        'employer' => 'fa-briefcase',
        'general' => 'fa-circle-info',
        'account' => 'fa-user-gear',
        'payment' => 'fa-credit-card',
    ];
    $extraCategories = collect($faqs)->keys()->reject(fn ($c) => in_array($c, ['jobseeker', 'job_seeker', 'employer']));
@endphp

{{-- Everything below shares one deep gradient backdrop so the frosted-glass
     panels have something rich to float over. --}}
<div class="relative isolate overflow-hidden bg-gradient-to-b from-slate-950 via-brand-900 to-slate-900">

    {{-- Decorative light: a blue glow and a gold glow, the two accent colors used throughout --}}
    <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
        <div class="absolute -top-40 -left-32 w-[32rem] h-[32rem] rounded-full bg-brand-500/25 blur-3xl"></div>
        <div class="absolute top-1/3 -right-32 w-[28rem] h-[28rem] rounded-full bg-amber-400/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/4 w-[24rem] h-[24rem] rounded-full bg-brand-400/10 blur-3xl"></div>
    </div>

    {{-- ============ PAGE HEADER ============ --}}
    <section class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 sm:pt-24 pb-10 text-center">
        <p class="text-sm font-semibold tracking-wide text-amber-300">Help center</p>
        <h1 class="mt-3 text-4xl sm:text-5xl font-bold tracking-tight text-white">
            How can we help?
        </h1>
        <p class="mt-4 text-lg text-slate-300 max-w-xl mx-auto leading-relaxed">
            Straight answers for job seekers and employers using Planet Job.
        </p>
    </section>

    <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 sm:pb-20">

        {{-- Audience switch: glass pill group with a distinct glow per audience --}}
        <div id="faq-tabs" role="tablist" aria-label="Filter by audience"
             class="flex items-center gap-1.5 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-1.5 mb-3 shadow-lg shadow-black/10">
            <button type="button" role="tab" aria-selected="true" data-category="all"
                    data-active="bg-white/95 text-slate-900 shadow-md"
                    data-inactive="text-slate-300 hover:text-white hover:bg-white/10"
                    class="faq-tab is-active bg-white/95 text-slate-900 shadow-md flex-1 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-200">
                All questions
            </button>
            <button type="button" role="tab" aria-selected="false" data-category="jobseeker,job_seeker"
                    data-active="bg-brand-500 text-white shadow-md shadow-brand-500/30"
                    data-inactive="text-slate-300 hover:text-white hover:bg-white/10"
                    class="faq-tab text-slate-300 hover:text-white hover:bg-white/10 flex-1 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-200">
                <i class="fa-solid fa-user text-xs mr-1.5"></i>Job Seekers
            </button>
            <button type="button" role="tab" aria-selected="false" data-category="employer"
                    data-active="bg-amber-500 text-white shadow-md shadow-amber-500/30"
                    data-inactive="text-slate-300 hover:text-white hover:bg-white/10"
                    class="faq-tab text-slate-300 hover:text-white hover:bg-white/10 flex-1 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-200">
                <i class="fa-solid fa-briefcase text-xs mr-1.5"></i>Employers
            </button>
        </div>

        {{-- Secondary topic chips, only rendered if the database has categories beyond the two audiences above --}}
        @if ($extraCategories->isNotEmpty())
            <div id="faq-chip-row" class="flex flex-wrap items-center justify-center gap-2 mb-10">
                @foreach ($extraCategories as $category)
                    <button type="button" data-category="{{ $category }}"
                            data-active="bg-white/95 border-white/95 text-slate-900 shadow-md"
                            data-inactive="bg-white/5 border-white/10 text-slate-300"
                            class="faq-tab inline-flex items-center gap-1.5 rounded-full border backdrop-blur-md bg-white/5 border-white/10 px-3.5 py-1.5 text-xs font-medium text-slate-300 transition-all duration-200 hover:border-white/30 hover:text-white">
                        <i class="fa-solid {{ $categoryIcons[$category] ?? 'fa-circle-question' }} text-[11px]"></i>
                        {{ $categoryLabels[$category] ?? ucfirst(str_replace('_', ' ', $category)) }}
                    </button>
                @endforeach
            </div>
        @else
            <div class="mb-10"></div>
        @endif

        {{-- No results state (category filter can still empty out a group) --}}
        <div id="faq-empty" class="hidden text-center py-16">
            <div class="mx-auto w-12 h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/10 flex items-center justify-center mb-4">
                <i class="fa-solid fa-circle-question text-slate-300"></i>
            </div>
            <p class="text-slate-200 font-medium">No questions in this category yet.</p>
        </div>

        {{-- FAQ Categories --}}
        <div id="faq-list" class="space-y-10">
            @forelse ($faqs as $category => $items)
                <div class="faq-category" data-category="{{ $category }}">
                    <h2 class="flex items-center gap-2 text-sm font-semibold text-slate-300 tracking-wide mb-3 px-1">
                        <i class="fa-solid {{ $categoryIcons[$category] ?? 'fa-circle-question' }} text-[13px] text-amber-300"></i>
                        {{ $categoryLabels[$category] ?? ucfirst(str_replace('_', ' ', $category)) }}
                    </h2>

                    <div class="space-y-3">
                        @foreach ($items as $faq)
                            <div class="faq-item bg-white/90 backdrop-blur-xl border border-white/60 rounded-2xl shadow-xl shadow-black/10 transition-colors duration-200">
                                <h3>
                                    <button type="button"
                                            class="faq-trigger w-full flex items-center justify-between gap-4 text-left px-5 py-4 sm:px-6 sm:py-4.5 rounded-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2"
                                            aria-expanded="false">
                                        <span class="faq-question font-semibold text-brand-700 text-[15px] leading-snug">{{ $faq->question }}</span>
                                        <span class="faq-icon relative shrink-0 w-5 h-5 text-brand-600">
                                            <span class="absolute inset-0 flex items-center justify-center">
                                                <span class="block w-2.5 h-px bg-current"></span>
                                            </span>
                                            <span class="faq-icon-v absolute inset-0 flex items-center justify-center transition-transform duration-300 ease-out">
                                                <span class="block w-px h-2.5 bg-current"></span>
                                            </span>
                                        </span>
                                    </button>
                                </h3>
                                <div class="faq-panel grid transition-[grid-template-rows] duration-300 ease-out" style="grid-template-rows: 0fr;">
                                    <div class="overflow-hidden">
                                        <p class="faq-answer text-[15px] text-amber-700 leading-relaxed px-5 sm:px-6 pb-4.5 pr-10">{{ $faq->answer }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-slate-300 text-center py-16">No FAQs have been added yet. Please check back soon.</p>
            @endforelse
        </div>
    </div>

    {{-- ============ CTA ============ --}}
    <section class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 sm:pb-24">
        <div class="flex flex-wrap items-center justify-between gap-6 bg-white/10 backdrop-blur-xl border border-white/10 rounded-2xl px-8 sm:px-12 py-10 shadow-xl shadow-black/10">
            <div>
                <h3 class="text-xl sm:text-2xl font-bold text-white">Still have questions?</h3>
                <p class="text-slate-300 mt-1.5">Can't find the answer you're looking for? Our team is happy to help.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('contact.create') }}"
                   class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                    Contact Us
                </a>
                <a href="{{ route('jobs.index') }}"
                   class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-400 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                    Browse Jobs
                </a>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
    /* Open state: icon rotates from + to -, item gets a quiet highlight */
    .faq-item:has(.faq-trigger[aria-expanded="true"]) {
        border-color: theme('colors.brand.400', #93c5fd);
        box-shadow: 0 0 0 1px theme('colors.brand.200', #bfdbfe) inset;
    }
    .faq-trigger[aria-expanded="true"] .faq-icon-v {
        transform: rotate(90deg);
        opacity: 0;
    }

    @media (prefers-reduced-motion: reduce) {
        .faq-panel,
        .faq-icon-v,
        .faq-tab {
            transition-duration: 0.01ms !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    const filterEls   = document.querySelectorAll('.faq-tab');
    const categories  = document.querySelectorAll('.faq-category');
    const emptyState  = document.getElementById('faq-empty');
    let activeCategory = 'all';

    // Accordion toggle (CSS grid-rows trick = smooth height animation, no JS measuring)
    document.querySelectorAll('.faq-trigger').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            const item   = trigger.closest('.faq-item');
            const panel  = item.querySelector('.faq-panel');
            const isOpen = trigger.getAttribute('aria-expanded') === 'true';

            trigger.setAttribute('aria-expanded', String(!isOpen));
            panel.style.gridTemplateRows = isOpen ? '0fr' : '1fr';
        });
    });

    // Audience tabs + topic chips share one active filter at a time.
    filterEls.forEach(function (el) {
        el.addEventListener('click', function () {
            activeCategory = el.dataset.category;

            filterEls.forEach(function (other) {
                const activeClasses   = (other.dataset.active || '').split(' ').filter(Boolean);
                const inactiveClasses = (other.dataset.inactive || '').split(' ').filter(Boolean);
                const isSelected      = other === el;

                other.classList.remove('is-active', ...activeClasses, ...inactiveClasses);
                other.classList.add(...(isSelected ? activeClasses : inactiveClasses));
                if (isSelected) other.classList.add('is-active');
                if (other.getAttribute('role') === 'tab') {
                    other.setAttribute('aria-selected', String(isSelected));
                }
            });

            applyFilters();
        });
    });

    function applyFilters() {
        let anyVisible = false;

        categories.forEach(function (categoryEl) {
            const matchesCategory = activeCategory === 'all'
                || activeCategory.split(',').includes(categoryEl.dataset.category);

            categoryEl.classList.toggle('hidden', !matchesCategory);
            if (matchesCategory) anyVisible = true;
        });

        emptyState.classList.toggle('hidden', anyVisible);
    }
})();
</script>
@endpush

@endsection
