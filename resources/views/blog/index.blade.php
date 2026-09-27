@extends('layouts.app')
@section('title', 'Blog - Planet Job Portal')

@section('content')

@php
    // The first post on page one is promoted into the featured slot; the
    // rest (and every item on later pages) fill the regular grid.
    $items    = collect($blogs->items());
    $featured = $blogs->onFirstPage() ? $items->first() : null;
    $rest     = $featured ? $items->reject(fn ($b) => $b->id === $featured->id) : $items;
@endphp

{{-- ============ HERO ============ --}}
<section class="bg-gradient-to-b from-brand-50/60 to-white border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-20 pb-12 text-center">
        <p class="text-sm font-semibold text-brand-700">Planet Job Blog</p>
        <h1 class="mt-3 text-4xl sm:text-5xl font-bold tracking-tight text-gray-900">
            Career Advice &amp; Insights
        </h1>
        <p class="mt-4 text-lg text-gray-500 max-w-xl mx-auto leading-relaxed">
            Practical guidance on job hunting, hiring, and everything in between &mdash; from people who do it every day.
        </p>

        <div class="mt-8 max-w-lg mx-auto">
            <div class="relative">
                <svg class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
                <input type="text" id="blog-search" autocomplete="off" placeholder="Search articles&hellip;"
                       class="w-full rounded-xl border border-gray-300 bg-white pl-12 pr-4 py-3.5 text-sm text-gray-800 shadow-sm transition-all duration-200 placeholder:text-gray-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 focus:outline-none">
            </div>
        </div>
    </div>
</section>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

    {{-- ============ FEATURED ARTICLE ============ --}}
    @if ($featured)
        <a href="{{ route('blog.show', $featured) }}"
           data-title="{{ strtolower($featured->title) }}" data-excerpt="{{ strtolower($featured->excerpt) }}"
           class="blog-searchable group grid sm:grid-cols-2 gap-0 mb-16 bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300">
            <div class="relative aspect-video sm:aspect-auto bg-gradient-to-br from-brand-600 to-brand-800 flex items-center justify-center">
                <i class="fa-solid fa-newspaper text-5xl text-white/25"></i>
                <span class="absolute top-4 left-4 inline-flex items-center rounded-full bg-white/15 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1">
                    Featured
                </span>
            </div>
            <div class="p-7 sm:p-8 flex flex-col justify-center">
                @if ($featured->category)
                    <span class="inline-flex w-fit items-center rounded-full bg-brand-50 text-brand-700 text-xs font-semibold px-2.5 py-1 mb-3">
                        {{ $featured->category->name }}
                    </span>
                @endif
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-snug group-hover:text-brand-700 transition-colors duration-200">
                    {{ $featured->title }}
                </h2>
                <p class="mt-3 text-gray-500 leading-relaxed line-clamp-3">{{ $featured->excerpt }}</p>
                <div class="mt-5 flex items-center gap-2 text-xs text-gray-400">
                    @if ($featured->author)
                        <span>{{ $featured->author->name }}</span>
                        <span aria-hidden="true">&middot;</span>
                    @endif
                    @if ($featured->published_at)
                        <span>{{ $featured->published_at->format('M d, Y') }}</span>
                    @endif
                </div>
                <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">
                    Read article
                    <i class="fa-solid fa-arrow-right text-xs transition-transform duration-200 group-hover:translate-x-1"></i>
                </span>
            </div>
        </a>
    @endif

    {{-- ============ RECENT POSTS GRID ============ --}}
    <div id="blog-empty" class="hidden text-center py-16">
        <div class="mx-auto w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-4">
            <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
        </div>
        <p class="text-gray-600 font-medium">No articles match your search.</p>
        <p class="text-sm text-gray-400 mt-1">
            <button type="button" id="blog-clear-search" class="text-brand-700 font-medium hover:underline">Clear search</button>
        </p>
    </div>

    <div id="blog-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10">
        @forelse ($rest as $blog)
            <a href="{{ route('blog.show', $blog) }}"
               data-title="{{ strtolower($blog->title) }}" data-excerpt="{{ strtolower($blog->excerpt) }}"
               class="blog-searchable group block">
                <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-50 rounded-xl mb-3.5 flex items-center justify-center overflow-hidden ring-1 ring-inset ring-gray-900/5 transition-shadow duration-200 group-hover:shadow-md">
                    <i class="fa-solid fa-image text-2xl text-gray-300"></i>
                </div>
                @if ($blog->category)
                    <span class="inline-flex items-center rounded-full bg-brand-50 text-brand-700 text-xs font-semibold px-2.5 py-1">
                        {{ $blog->category->name }}
                    </span>
                @endif
                <h3 class="font-semibold text-gray-900 mt-2.5 leading-snug group-hover:text-brand-700 transition-colors duration-200">
                    {{ $blog->title }}
                </h3>
                <p class="text-sm text-gray-500 mt-1.5 leading-relaxed line-clamp-2">{{ $blog->excerpt }}</p>
            </a>
        @empty
            @unless ($featured)
                <p class="col-span-full text-gray-500 text-center py-16">No articles have been published yet. Please check back soon.</p>
            @endunless
        @endforelse
    </div>

    @if ($blogs->hasPages())
        <div class="mt-12">{{ $blogs->links() }}</div>
    @endif
</div>

{{-- ============ NEWSLETTER ============ --}}
<section class="bg-brand-900">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <h3 class="text-2xl sm:text-3xl font-bold text-white">Get career advice in your inbox</h3>
        <p class="mt-3 text-brand-100/80 max-w-md mx-auto">
            One email a month with our best job-search and hiring articles. No spam, unsubscribe any time.
        </p>
        {{-- Wire this form up to your newsletter subscription route/controller. --}}
        <form action="#" method="POST" class="mt-7 flex flex-col sm:flex-row items-center justify-center gap-3 max-w-md mx-auto">
            @csrf
            <label for="newsletter-email" class="sr-only">Email address</label>
            <input type="email" id="newsletter-email" name="email" required placeholder="you@example.com"
                   class="w-full sm:flex-1 rounded-lg border-0 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-brand-100/60 shadow-sm transition-all duration-200 focus:bg-white focus:text-gray-900 focus:placeholder:text-gray-400 focus:ring-4 focus:ring-white/20 focus:outline-none">
            <button type="submit"
                    class="w-full sm:w-auto shrink-0 inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-400 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                Subscribe
            </button>
        </form>
    </div>
</section>

@push('scripts')
<script>
(function () {
    const searchInput = document.getElementById('blog-search');
    const clearBtn     = document.getElementById('blog-clear-search');
    const cards        = document.querySelectorAll('.blog-searchable');
    const emptyState   = document.getElementById('blog-empty');
    const grid         = document.getElementById('blog-grid');

    if (!searchInput) return;

    searchInput.addEventListener('input', applyFilter);
    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            applyFilter();
            searchInput.focus();
        });
    }

    function applyFilter() {
        const term = searchInput.value.trim().toLowerCase();
        let anyVisible = false;

        cards.forEach(function (card) {
            const matches = term === ''
                || card.dataset.title.includes(term)
                || card.dataset.excerpt.includes(term);
            card.classList.toggle('hidden', !matches);
            if (matches) anyVisible = true;
        });

        // Search only filters posts already loaded on this page; it does not
        // query other pages of results.
        emptyState.classList.toggle('hidden', anyVisible || term === '');
        grid.classList.toggle('hidden', !anyVisible && term !== '');
    }
})();
</script>
@endpush

@endsection
