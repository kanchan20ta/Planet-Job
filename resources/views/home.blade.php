@extends('layouts.app')
@section('title', 'Planet Job Portal - Connect Talent with Opportunity')

@section('content')

{{-- ============ HERO ============ --}}
<section class="relative h-[70vh] min-h-[420px] max-h-[640px] flex items-center justify-center" style="background-image: url('{{ asset('images/cover.png') }}'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black/25 z-10"></div>

    {{-- Soft glow blobs --}}
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -left-16 w-80 h-80 bg-brand-400/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">

        <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight text-white">
            Find Your Dream Jobs <br class="hidden sm:block"> with Planet Job
        </h1>

        <p class="mt-5 text-brand-100 max-w-2xl mx-auto text-lg">
            @if($stats['jobs'] > 0)
                {{ number_format($stats['jobs']) }}+ active jobs from {{ number_format($stats['companies']) }}+ companies. Talent with Opportunity.
            @else
                Connecting talent with opportunity — new jobs added daily.
            @endif
        </p>

        <form action="{{ route('jobs.index') }}" method="GET"
              class="mt-10 bg-white rounded-2xl p-2 flex flex-col sm:flex-row gap-2 max-w-2xl mx-auto shadow-2xl shadow-black/20">
            <div class="flex items-center flex-1 px-2">
                <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
                <input type="text" name="keyword" placeholder="Job title, skill, or company"
                       class="w-full border-0 focus:ring-0 text-gray-800 rounded-lg px-3 py-3">
            </div>
            <div class="hidden sm:block w-px bg-gray-200 my-2"></div>
            <div class="flex items-center sm:w-44 px-2">
                <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <input type="text" name="city" placeholder="City"
                       class="w-full border-0 focus:ring-0 text-gray-800 rounded-lg px-2 py-3">
            </div>
            <button type="submit"
                    class="bg-brand-600 hover:bg-brand-700 active:scale-95 transition-all text-white font-semibold px-6 py-3 rounded-lg shadow-md">
                Search Jobs
            </button>
        </form>

        @if($stats['jobs'] > 0 || $stats['companies'] > 0 || $stats['jobseekers'] > 0)
            <div class="mt-14 grid grid-cols-3 max-w-lg mx-auto gap-4 text-center">
                <div>
                    <div class="text-3xl font-bold">{{ number_format($stats['jobs']) }}</div>
                    <div class="text-xs text-brand-100 mt-1 uppercase tracking-wide">Active Jobs</div>
                </div>
                <div>
                    <div class="text-3xl font-bold">{{ number_format($stats['companies']) }}</div>
                    <div class="text-xs text-brand-100 mt-1 uppercase tracking-wide">Companies</div>
                </div>
                <div>
                    <div class="text-3xl font-bold">{{ number_format($stats['jobseekers']) }}</div>
                    <div class="text-xs text-brand-100 mt-1 uppercase tracking-wide">Job Seekers</div>
                </div>
            </div>
        @else
            <div class="mt-14">
                <span class="inline-block bg-white/10 text-brand-50 text-sm font-medium px-5 py-2 rounded-full backdrop-blur">
                    🚀 Newly launched — be one of the first to join
                </span>
            </div>
        @endif
    </div>
</section>

{{-- ============ CATEGORIES ============ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-10">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">What field are you in?</h2>
        <p class="text-gray-500 mt-2">Explore opportunities across the industries that interest you</p>
    </div>
    @php
        // Map category names (lowercase) to a specific, unique Font Awesome icon class.
        // Add more entries here as new categories are introduced.
        $categoryIcons = [
            'information technology'      => 'fa-laptop',
            'it'                          => 'fa-laptop',
            'marketing & sales'           => 'fa-chart-line',
            'marketing and sales'         => 'fa-chart-line',
            'accounting & finance'        => 'fa-wallet',
            'accounting and finance'      => 'fa-wallet',
            'human resources'             => 'fa-users',
            'hr'                          => 'fa-users',
            'engineering'                 => 'fa-gears',
            'healthcare & medical'        => 'fa-heart-pulse',
            'healthcare and medical'      => 'fa-heart-pulse',
            'education & training'        => 'fa-graduation-cap',
            'education and training'      => 'fa-graduation-cap',
            'customer service'            => 'fa-headset',
            'design & creative'           => 'fa-paintbrush',
            'design and creative'         => 'fa-paintbrush',
            'legal'                       => 'fa-scale-balanced',
            'hospitality & travel'        => 'fa-plane',
            'hospitality and travel'      => 'fa-plane',
            'construction & real estate'  => 'fa-building',
            'construction and real estate'=> 'fa-building',
        ];

        // Fallback icon used when a category name has no explicit mapping above.
        $defaultCategoryIcon = 'fa-briefcase';
    @endphp

    <style>
        @keyframes categoryCardIn {
            0% {
                opacity: 0;
                transform: translateY(28px) scale(0.94);
            }
            60% {
                opacity: 1;
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .category-card-animate {
            opacity: 0;
            animation: categoryCardIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: var(--card-delay, 0s);
        }
        @keyframes categoryMarquee {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }
        .category-marquee-track {
            animation: categoryMarquee 32s linear infinite;
        }
        .category-marquee-wrapper:hover .category-marquee-track {
            animation-play-state: paused;
        }
        @media (prefers-reduced-motion: reduce) {
            .category-card-animate {
                animation: none;
                opacity: 1;
                transform: none;
            }
            .category-marquee-track {
                animation: none;
            }
        }
    </style>

    @php
        // Duplicate the list so the track can loop seamlessly from -50% back to 0%.
        $marqueeCategories = $categories->concat($categories);
    @endphp

    <div class="category-marquee-wrapper category-card-animate relative overflow-hidden">
        {{-- Edge fades so items scroll in/out smoothly rather than clipping abruptly --}}
        <div class="pointer-events-none absolute inset-y-0 left-0 w-12 sm:w-20 bg-gradient-to-r from-white to-transparent z-10"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 w-12 sm:w-20 bg-gradient-to-l from-white to-transparent z-10"></div>

        <div class="category-marquee-track flex items-start gap-6 w-max">
            @foreach ($marqueeCategories as $category)
                @php
                    $iconClass = $categoryIcons[strtolower($category->name)] ?? $defaultCategoryIcon;
                @endphp
                <a href="{{ route('jobs.index', ['category' => $category->id]) }}"
                   class="group shrink-0 bg-white border border-gray-200 rounded-full w-32 h-32 sm:w-36 sm:h-36 flex flex-col items-center justify-center text-center p-4 transform hover:-translate-y-2 hover:border-brand-400 hover:shadow-2xl transition-all duration-300">
                    <div class="w-11 h-11 mx-auto rounded-full bg-brand-50 text-brand-700 flex items-center justify-center mb-2 transition-all duration-300 group-hover:bg-brand-600 group-hover:text-white group-hover:scale-110">
                        <i class="fa-solid {{ $iconClass }} text-lg"></i>
                    </div>
                    <p class="text-sm font-semibold text-gray-800 leading-tight px-1">{{ $category->name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $category->jobs_count }} jobs</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ FEATURED JOBS ============ --}}
@if ($featuredJobs->count())
<section class="bg-white border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-10">
            <div class="flex items-start gap-4">
                <span class="mt-1 w-1.5 h-10 rounded-full bg-orange-500 shrink-0"></span>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Featured Jobs</h2>
                    <p class="text-gray-500 mt-1">Hand-picked roles from top companies</p>
                </div>
            </div>
            <a href="{{ route('jobs.index', ['sort' => 'featured']) }}"
               class="group inline-flex items-center gap-2 text-sm font-semibold text-brand-700 border border-brand-200 rounded-full px-4 py-2 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-colors whitespace-nowrap">
                View all jobs
                <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-0.5"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($featuredJobs as $job)
                @include('partials.job-card', ['job' => $job])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ LATEST JOBS ============ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex flex-wrap items-end justify-between gap-4 mb-10">
        <div class="flex items-start gap-4">
            <span class="mt-1 w-1.5 h-10 rounded-full bg-brand-600 shrink-0"></span>
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Latest Jobs</h2>
                <p class="text-gray-500 mt-1">Freshly posted opportunities</p>
            </div>
        </div>
        <a href="{{ route('jobs.index') }}"
           class="group inline-flex items-center gap-2 text-sm font-semibold text-brand-700 border border-brand-200 rounded-full px-4 py-2 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-colors whitespace-nowrap">
            View all jobs
            <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-0.5"></i>
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($latestJobs as $job)
            @include('partials.job-card', ['job' => $job])
        @endforeach
    </div>
</section>

{{-- ============ BLOG TEASER ============ --}}
@if ($latestBlogs->count())
<section class="bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">From the Blog</h2>
            <p class="text-gray-500 mt-2">Career tips, hiring insights, and industry news</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach ($latestBlogs as $blog)
                <a href="{{ route('blog.show', $blog) }}" class="block group">
                    <div class="aspect-video bg-gray-100 rounded-xl mb-4 overflow-hidden">
                        @if($blog->image)
                            <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @endif
                    </div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-brand-600 transition-colors">
                        {{ $blog->title }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1.5 line-clamp-2">{{ $blog->excerpt }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ CTA FOR EMPLOYERS ============ --}}
<section class="relative overflow-hidden bg-gradient-to-br from-brand-900 via-brand-800 to-slate-900 text-white">
    {{-- Subtle dot-grid texture for depth, distinct from the blurred blobs used elsewhere --}}
    <div class="absolute inset-0 opacity-[0.07] pointer-events-none"
         style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 22px 22px;"></div>
    <div class="absolute top-0 right-0 w-[36rem] h-[36rem] bg-orange-500/10 rounded-full blur-3xl pointer-events-none -translate-y-1/3 translate-x-1/4"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid lg:grid-cols-2 gap-14 items-center">

        {{-- Left: message + CTA --}}
        <div>
            <h2 class="text-3xl sm:text-4xl font-bold leading-tight">
                Hiring? Reach thousands of<br class="hidden sm:block"> qualified candidates.
            </h2>
            <p class="text-brand-100/90 mt-4 max-w-lg text-lg">
                Post a job in minutes and connect with talent that's ready to work &mdash; no lengthy setup, no recruiter fees.
            </p>

            <div class="flex flex-wrap gap-6 mt-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">
                        <i class="fa-solid fa-bolt text-orange-400"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-sm">Live in minutes</p>
                        <p class="text-xs text-brand-100/70">No approval delays</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">
                        <i class="fa-solid fa-user-check text-orange-400"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-sm">Verified talent</p>
                        <p class="text-xs text-brand-100/70">Screened profiles</p>
                    </div>
                </div>
            </div>

            <a href="{{ route('employer.register') }}"
               class="group inline-flex items-center gap-3 mt-10 bg-orange-500 hover:bg-orange-400 text-white text-lg font-semibold px-9 py-4 rounded-xl shadow-lg shadow-orange-900/30 hover:shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all">
                <i class="fa-solid fa-paper-plane"></i>
                Post a Job
                <i class="fa-solid fa-arrow-right text-sm transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        {{-- Right: floating candidate-pool card --}}
        <div class="relative hidden lg:block">
            <div class="relative bg-white/[0.06] border border-white/10 rounded-2xl p-7 backdrop-blur-sm shadow-2xl">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold text-brand-100/80">Candidate pool</p>
                    <i class="fa-solid fa-briefcase text-brand-100/50"></i>
                </div>

                <div class="flex items-center mt-4">
                    @php $avatarColors = ['bg-orange-400', 'bg-brand-400', 'bg-emerald-400', 'bg-purple-400']; @endphp
                    @foreach($avatarColors as $i => $color)
                        <div class="w-11 h-11 rounded-full {{ $color }} border-2 border-brand-900 flex items-center justify-center text-sm font-bold text-brand-900 {{ $i > 0 ? '-ml-3' : '' }}">
                            {{ ['JD', 'AK', 'MS', 'RT'][$i] }}
                        </div>
                    @endforeach
                    <div class="-ml-3 w-11 h-11 rounded-full bg-white/10 border-2 border-brand-900 flex items-center justify-center text-xs font-semibold">
                        +{{ number_format($stats['jobseekers'] ?? 0) }}
                    </div>
                </div>

                <p class="text-3xl font-bold mt-5">{{ number_format($stats['jobseekers'] ?? 0) }}+</p>
                <p class="text-sm text-brand-100/70 mt-0.5">active job seekers ready to apply</p>

                <div class="flex items-center gap-2 mt-5 pt-5 border-t border-white/10 text-sm text-emerald-300">
                    <i class="fa-solid fa-circle-check"></i>
                    Applications start rolling in within 24 hours
                </div>
            </div>

            {{-- Small accent badge --}}
            <div class="absolute -top-5 -right-5 w-16 h-16 rounded-2xl bg-orange-500 flex items-center justify-center shadow-lg rotate-6">
                <i class="fa-solid fa-rocket text-white text-xl -rotate-6"></i>
            </div>
        </div>
    </div>
</section>

@endsection
