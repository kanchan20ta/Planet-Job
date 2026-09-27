@extends('layouts.panel')
@section('title', 'Subscription Plans - Planet Job Portal')

@php
$panelTitle = 'Employer Panel';
$panelLinks = [
    ['label' => 'Dashboard', 'url' => route('employer.dashboard'), 'active' => 'employer.dashboard'],
    ['label' => 'My Jobs', 'url' => route('employer.jobs.index'), 'active' => 'employer.jobs.*'],
    ['label' => 'Subscription', 'url' => route('employer.subscription.index'), 'active' => 'employer.subscription.*'],
    ['label' => 'Company Profile', 'url' => route('employer.company.edit'), 'active' => 'employer.company.*'],
];
@endphp

@section('panel-content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Subscription Plans</h1>
    <p class="text-sm text-gray-500 mt-1">Choose the plan that fits how you hire.</p>
</div>

@if ($current)
    <div class="flex items-center gap-3 bg-brand-50 border border-brand-100 rounded-xl p-4 mb-8 text-sm text-brand-800">
        <svg class="w-5 h-5 text-brand-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>
            You're currently on the <strong class="font-semibold">{{ $current->plan->name }}</strong> plan,
            expiring {{ $current->ends_at->format('M d, Y') }}.
        </span>
    </div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-start">
    @foreach ($plans as $plan)
        @php
            $isCurrent = $current && $current->plan_id === $plan->id;
            // Falls back to the middle plan if no explicit "is_popular" flag exists on the model.
            $isPopular = $plan->is_popular ?? ($loop->iteration === 2);
        @endphp

        <div class="group relative rounded-2xl transition-all duration-300 ease-out hover:-translate-y-1.5
                    {{ $isPopular
                        ? 'bg-gradient-to-b from-brand-600 to-brand-700 p-[1px] shadow-lg shadow-brand-200/60 hover:shadow-xl hover:shadow-brand-300/60'
                        : 'bg-gray-200 p-[1px] hover:shadow-lg hover:shadow-gray-200/70' }}">

            @if ($isPopular)
                <span class="absolute -top-3 left-1/2 -translate-x-1/2 inline-flex items-center gap-1 bg-brand-600 text-white text-[11px] font-semibold tracking-wide uppercase px-3 py-1 rounded-full shadow-sm z-10">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.363 1.118l1.287 3.957c.3.922-.755 1.688-1.538 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.783.57-1.838-.196-1.539-1.118l1.287-3.957a1 1 0 00-.363-1.118L2.062 9.385c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.958z" />
                    </svg>
                    Most Popular
                </span>
            @endif

            <div class="relative flex h-full flex-col rounded-2xl bg-white p-7
                        {{ $isPopular ? 'pt-8' : '' }}
                        {{ $isCurrent && ! $isPopular ? 'ring-2 ring-brand-500' : '' }}">

                @if ($isCurrent)
                    <span class="absolute top-5 right-5 text-[11px] font-semibold text-brand-700 bg-brand-50 px-2.5 py-1 rounded-full">
                        Current
                    </span>
                @endif

                <h3 class="text-base font-bold text-gray-900 tracking-tight">{{ $plan->name }}</h3>

                <p class="mt-3 flex items-baseline gap-1">
                    <span class="text-3xl font-extrabold text-gray-900 tracking-tight">Rs. {{ number_format($plan->price) }}</span>
                    <span class="text-sm font-medium text-gray-400">/mo</span>
                </p>

                <div class="h-px bg-gray-100 my-5"></div>

                <ul class="text-sm text-gray-600 space-y-3 flex-1">
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        <span>{{ $plan->job_post_limit }} job posts</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        <span>{{ $plan->featured_job_limit }} featured jobs</span>
                    </li>
                    <li class="flex items-center gap-2.5 {{ ! $plan->cv_access ? 'text-gray-400' : '' }}">
                        <svg class="w-4 h-4 shrink-0 {{ $plan->cv_access ? 'text-brand-500' : 'text-gray-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            @if ($plan->cv_access)
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            @endif
                        </svg>
                        <span>{{ $plan->cv_access ? 'CV database access' : 'No CV access' }}</span>
                    </li>
                </ul>

                <form method="POST" action="{{ route('employer.subscription.store', $plan) }}" class="mt-6">
                    @csrf
                    <button class="w-full font-semibold py-2.5 rounded-lg text-sm transition-all duration-200
                                   {{ $isPopular
                                       ? 'bg-brand-600 text-white hover:bg-brand-700 hover:shadow-md hover:shadow-brand-200'
                                       : 'bg-gray-900 text-white hover:bg-gray-800' }}">
                        {{ $isCurrent ? 'Renew' : 'Choose Plan' }}
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
