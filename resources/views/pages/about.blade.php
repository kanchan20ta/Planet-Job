@extends('layouts.app')
@section('title', 'About Us - Planet Job Portal')

@section('content')

{{-- ============ PAGE HEADER ============ --}}
<section class="relative bg-white border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 text-center">
        <span class="inline-flex items-center gap-2 text-sm font-semibold text-brand-700 bg-brand-50 rounded-full px-4 py-1.5">
            <i class="fa-solid fa-building text-xs"></i>
            Est. 2016 &middot; Kathmandu, Nepal
        </span>
        <h1 class="mt-5 text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900">
            About "Planet Job Pvt. Ltd."
        </h1>
        <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">
            &mdash; connecting the right talent with the right opportunities, nationwide.
        </p>
    </div>
</section>

{{-- ============ WHO WE ARE ============ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="relative">
            <div class="absolute -inset-4 bg-brand-50 rounded-3xl -z-10 hidden sm:block"></div>
            <img src="{{ asset('images/team.png') }}" alt="Planet Job Team"
                 class="w-full h-[420px] sm:h-[600px] object-contain bg-white rounded-2xl shadow-xl shadow-gray-200">
        </div>

        <div>
            <span class="w-1.5 h-8 bg-orange-500 rounded-full inline-block mb-4"></span>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Who We Are</h2>
            <p class="mt-4 text-gray-600 leading-relaxed">
                Planet Job Pvt. Ltd. is a national recruitment and employment agency based in Kathmandu, Nepal.
                Established in 2016, we are a trusted recruitment partner connecting right talent with right
                opportunities.
            </p>
            <p class="mt-4 text-gray-600 leading-relaxed">
                Our mission is to support organizations in strategically managing human capital to achieve
                business excellence, while helping job seekers land their dream careers.
            </p>

            <div class="grid grid-cols-3 gap-4 mt-8 pt-6 border-t border-gray-100">
                <div>
                    <p class="text-2xl font-bold text-gray-900">2016</p>
                    <p class="text-xs text-gray-500 mt-1">Founded</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">National</p>
                    <p class="text-xs text-gray-500 mt-1">Coverage</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">Full-Service</p>
                    <p class="text-xs text-gray-500 mt-1">HR Partner</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ OUR SERVICES ============ --}}
<section class="bg-gray-50 border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Our Services</h2>
            <p class="text-gray-500 mt-3">
                End-to-end workforce solutions, from sourcing individual hires to advising on company-wide HR
                strategy.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6">

            <div class="lg:col-span-2 group bg-white border border-gray-200 rounded-2xl p-7 hover:border-brand-300 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center mb-4 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-magnifying-glass-chart text-lg"></i>
                </div>
                <h4 class="font-semibold text-gray-900">Recruitment Services</h4>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                    Identifying and matching qualified candidates for your company's open positions.
                </p>
            </div>

            <div class="lg:col-span-2 group bg-white border border-gray-200 rounded-2xl p-7 hover:border-brand-300 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center mb-4 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-user-tie text-lg"></i>
                </div>
                <h4 class="font-semibold text-gray-900">Executive Search</h4>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                    Specialized headhunting for top-level executives and key management roles.
                </p>
            </div>

            <div class="lg:col-span-2 group bg-white border border-gray-200 rounded-2xl p-7 hover:border-brand-300 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center mb-4 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-people-group text-lg"></i>
                </div>
                <h4 class="font-semibold text-gray-900">Manpower Outsourcing</h4>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                    Providing flexible and reliable workforce solutions tailored to business needs.
                </p>
            </div>

            <div class="lg:col-span-3 group bg-white border border-gray-200 rounded-2xl p-7 hover:border-brand-300 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center mb-4 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-lightbulb text-lg"></i>
                </div>
                <h4 class="font-semibold text-gray-900">HR Consulting</h4>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                    Strategic advisory services to optimize your HR policies and workplace efficiency.
                </p>
            </div>

            <div class="lg:col-span-3 group bg-white border border-gray-200 rounded-2xl p-7 hover:border-brand-300 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center mb-4 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-chalkboard-user text-lg"></i>
                </div>
                <h4 class="font-semibold text-gray-900">Training &amp; Development</h4>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                    Empowering professionals and teams through targeted skill enhancement programs.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ============ CTA ============ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
    <div class="flex flex-wrap items-center justify-between gap-6 bg-brand-900 text-white rounded-2xl px-8 sm:px-12 py-10">
        <div>
            <h3 class="text-xl sm:text-2xl font-bold">Ready to work with us?</h3>
            <p class="text-brand-100/80 mt-1.5">Whether you're hiring or job hunting, we're here to help.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('employer.register') }}"
               class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-400 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                Post a Job
            </a>
            <a href="{{ route('jobs.index') }}"
               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-400 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                Browse Jobs
            </a>
        </div>
    </div>
</section>

@endsection
