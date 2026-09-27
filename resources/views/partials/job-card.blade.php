{{--
    Job card partial.
    Expects a $job model. Adjust the property names below (marked with comments)
    to match your actual Job / Company schema if they differ.
--}}
<div class="group relative flex flex-col bg-white border border-gray-200 rounded-2xl p-5 hover:border-brand-300 hover:shadow-xl hover:shadow-brand-900/5 hover:-translate-y-0.5 transition-all duration-200">

    @if($job->is_featured ?? false)
        <span class="absolute top-4 right-4 text-[11px] font-semibold text-orange-600 bg-orange-50 px-2.5 py-1 rounded-full">
            Featured
        </span>
    @endif

    <a href="{{ route('jobs.show', $job) }}" class="flex items-start gap-3">
        {{-- Company logo --}}
        <div class="w-14 h-14 shrink-0 rounded-xl flex items-center justify-center
            @if($job->company?->logo)
                bg-white border border-gray-200 shadow-sm p-1.5
            @else
                bg-brand-50
            @endif">
            @if($job->company?->logo)
                <img src="{{ Str::startsWith($job->company->logo, ['http://', 'https://']) ? $job->company->logo : asset('storage/' . $job->company->logo) }}"
                     alt="{{ $job->company->name }}"
                     class="w-full h-full object-contain"
                     onerror="this.remove(); this.parentElement.querySelector('.logo-fallback')?.classList.remove('hidden');">
                <span class="logo-fallback hidden text-base font-bold text-brand-700">
                    {{ substr($job->company->name ?? $job->title, 0, 1) }}
                </span>
            @else
                <span class="text-base font-bold text-brand-700">
                    {{ substr($job->company->name ?? $job->title, 0, 1) }}
                </span>
            @endif
        </div>

        <div class="min-w-0">
            <h3 class="font-semibold text-gray-900 leading-snug line-clamp-2 group-hover:text-brand-600 transition-colors">
                {{ $job->title }}
            </h3>
            <p class="text-sm text-gray-500 mt-0.5 truncate">{{ $job->company->name ?? 'Confidential' }}</p>
        </div>
    </a>

    <div class="flex flex-wrap gap-1.5 mt-4">
        @if($job->location)
            <span class="inline-flex items-center gap-1 text-xs text-gray-600 bg-gray-50 border border-gray-100 rounded-full px-2.5 py-1">
                <i class="fa-solid fa-location-dot text-gray-400 text-[10px]"></i>
                {{ $job->location }}
            </span>
        @endif
        @if($job->type)
            <span class="inline-flex items-center gap-1 text-xs text-gray-600 bg-gray-50 border border-gray-100 rounded-full px-2.5 py-1">
                <i class="fa-solid fa-briefcase text-gray-400 text-[10px]"></i>
                {{ $job->type }}
            </span>
        @endif
    </div>

    <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-100">
        <div class="min-w-0">
            @if($job->salary_min || $job->salary_max)
                <p class="text-sm font-semibold text-gray-900 truncate">
                    @if($job->salary_min && $job->salary_max)
                        Rs. {{ number_format($job->salary_min) }}&ndash;{{ number_format($job->salary_max) }}
                    @else
                        Rs. {{ number_format($job->salary_min ?? $job->salary_max) }}+
                    @endif
                </p>
                <p class="text-xs text-gray-400">{{ $job->salary_period ?? 'per month' }}</p>
            @else
                <p class="text-xs text-gray-400">{{ $job->created_at?->diffForHumans() }}</p>
            @endif
        </div>

        <a href="{{ route('jobs.show', $job) }}"
           class="shrink-0 inline-flex items-center gap-1.5 bg-brand-600 hover:bg-brand-700 active:scale-95 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-all">
            Apply Now
        </a>
    </div>
</div>
