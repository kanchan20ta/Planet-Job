@extends('layouts.app')
@section('title', $company->name . ' - Planet Job Portal')

@section('content')
<div class="bg-brand-900 h-32"></div>
<div class="max-w-5xl mx-auto px-4 -mt-12 pb-14">
    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-xl bg-brand-50 text-brand-700 font-bold flex items-center justify-center text-2xl">
                {{ substr($company->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    {{ $company->name }}
                    @if ($company->is_verified)
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Verified</span>
                    @endif
                </h1>
                <p class="text-sm text-gray-500">{{ $company->industry }} &middot; {{ $company->city }}, {{ $company->country }}</p>
            </div>
        </div>
        @if ($company->description)
            <p class="text-sm text-gray-600 mt-5">{{ $company->description }}</p>
        @endif
    </div>

    <h2 class="font-semibold text-gray-900 mb-4">Open Positions ({{ $company->activeJobs->count() }})</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        @forelse ($company->activeJobs as $job)
            @include('partials.job-card', ['job' => $job])
        @empty
            <p class="text-gray-400 text-sm">No open positions right now.</p>
        @endforelse
    </div>
</div>
@endsection
