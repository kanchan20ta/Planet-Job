{{--
    Reusable "Apply now" CTA.
    Usage: @include('partials._apply_button', ['job' => $job, 'variant' => 'desktop'])
    $variant controls the responsive visibility classes:
      - 'desktop' -> hidden lg:flex   (sidebar placement)
      - 'mobile'  -> lg:hidden        (sticky bottom bar placement)
      - null      -> no visibility classes (always visible, e.g. for reuse elsewhere)
--}}
@php
    $visibility = match($variant ?? null) {
        'desktop' => 'hidden lg:flex',
        'mobile' => 'lg:hidden',
        default => 'flex',
    };
    // Sidebar gets a full-width, roomy CTA; the mobile sticky bar needs a compact
    // button that sits comfortably next to the salary text.
    $sizing = ($variant ?? null) === 'mobile'
        ? 'px-5 py-2.5 text-sm'
        : 'py-4 text-lg';
@endphp
<a
    href="{{ route('jobs.apply', $job) }}"
    class="{{ $visibility }} {{ $sizing }} group relative items-center justify-center gap-2
           bg-gradient-to-r from-teal-500 to-emerald-600
           hover:from-teal-400 hover:to-emerald-500
           text-white font-bold tracking-wide
           rounded-xl
           ring-1 ring-emerald-400/40
           shadow-lg shadow-emerald-600/30
           hover:shadow-xl hover:shadow-emerald-500/40
           hover:ring-2 hover:ring-emerald-300/60
           hover:-translate-y-0.5 active:translate-y-0 active:scale-95
           transition-all duration-200 ease-out
           overflow-hidden"
    aria-label="Apply now for {{ $job->title }} at {{ $job->company->name ?? 'this company' }}"
>
    <span class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-out bg-gradient-to-r from-transparent via-white/25 to-transparent"></span>
    <i class="fa-solid fa-paper-plane text-xs sm:text-sm transition-transform duration-200 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i>
    <span class="relative">Apply now</span>
</a>
