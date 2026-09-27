{{-- Shared shell for Admin/Employer/Jobseeker panels. Set $panelLinks and $panelTitle before extending. --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <aside class="lg:col-span-1">
            <div class="bg-white border border-gray-200 rounded-xl p-4 sticky top-20">
                <p class="text-xs font-semibold text-gray-400 uppercase px-2 mb-2">{{ $panelTitle ?? 'Dashboard' }}</p>
                <nav class="space-y-1">
                    @foreach ($panelLinks ?? [] as $link)
                        <a href="{{ $link['url'] }}"
                           class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs($link['active']) ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </aside>

        <div class="lg:col-span-4">
            @yield('panel-content')
        </div>
    </div>
</div>
@endsection
