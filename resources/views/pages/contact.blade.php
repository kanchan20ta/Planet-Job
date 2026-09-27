@extends('layouts.app')
@section('title', 'Contact Us - Planet Job Portal')

@section('content')

{{-- ============ PAGE HEADER ============ --}}
<section class="bg-white border-b border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-14 text-center">
        <span class="inline-flex items-center gap-2 text-sm font-semibold text-brand-700 bg-brand-50 rounded-full px-4 py-1.5">
            <i class="fa-solid fa-comment-dots text-xs"></i>
            We usually reply within a day
        </span>
        <h1 class="mt-5 text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900">
            Get in Touch
        </h1>
        <p class="mt-4 text-lg text-gray-500">
            Questions about hiring, applying, or partnering with us? We'd love to hear from you.
        </p>
    </div>
</section>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 pb-20">

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ============ UNIFIED CONTACT CARD ============ --}}
    <div class="grid lg:grid-cols-5 rounded-3xl overflow-hidden shadow-xl shadow-gray-200/60 border border-gray-100">

        {{-- Contact information panel --}}
        <div class="lg:col-span-2 relative bg-brand-900 text-white p-8 sm:p-10">
            <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl pointer-events-none -translate-y-1/3 translate-x-1/4"></div>

            <div class="relative">
                <h2 class="text-xl font-bold">Contact Information</h2>
                <p class="text-brand-100/70 text-sm mt-2 leading-relaxed">
                    Reach out any way that's convenient &mdash; our team is ready to help.
                </p>

                <div class="space-y-5 mt-9">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 shrink-0 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fa-solid fa-location-dot text-orange-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-brand-100/60 uppercase tracking-wide">Address</p>
                            <p class="font-medium mt-0.5">Dillibazar, Kathmandu, Nepal</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 shrink-0 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fa-solid fa-phone text-orange-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-brand-100/60 uppercase tracking-wide">Phone</p>
                            <a href="tel:+97714516951" class="font-medium mt-0.5 hover:text-orange-300 transition-colors block">
                                +977 1-4516951
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 shrink-0 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fa-solid fa-envelope text-orange-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-brand-100/60 uppercase tracking-wide">Email</p>
                            <a href="mailto:info@planetjob.com.np" class="font-medium mt-0.5 hover:text-orange-300 transition-colors block">
                                info@planetjob.com.np
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 shrink-0 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fa-brands fa-whatsapp text-orange-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-brand-100/60 uppercase tracking-wide">WhatsApp</p>
                            <a href="https://wa.me/9779849911133" target="_blank" rel="noopener" class="font-medium mt-0.5 hover:text-orange-300 transition-colors block">
                                +977 9849911133
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 shrink-0 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fa-solid fa-clock text-orange-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-brand-100/60 uppercase tracking-wide">Hours</p>
                            <p class="font-medium mt-0.5">Sunday &ndash; Friday, 10:00 AM &ndash; 6:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact form panel --}}
        <div class="lg:col-span-3 bg-white p-8 sm:p-10">
            <h2 class="text-xl font-bold text-gray-900">Send Us a Message</h2>
            <p class="text-gray-500 text-sm mt-2">Fill out the form below and we'll get back to you shortly.</p>

            <form method="POST" action="{{ route('contact.store') }}" class="mt-8 space-y-5">
                @csrf

                <div class="grid sm:grid-cols-2 gap-5">
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Your Name" required
                               class="w-full rounded-xl border-gray-200 bg-gray-50 pl-11 pr-4 py-3.5 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-100 transition-all">
                    </div>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required
                               class="w-full rounded-xl border-gray-200 bg-gray-50 pl-11 pr-4 py-3.5 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-100 transition-all">
                    </div>
                </div>

                <div class="relative">
                    <i class="fa-solid fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 pl-11 pr-4 py-3.5 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-100 transition-all">
                </div>

                <div class="relative">
                    <i class="fa-solid fa-message absolute left-4 top-4 text-gray-400 text-sm"></i>
                    <textarea name="message" rows="5" placeholder="Tell us how we can help..." required
                              class="w-full rounded-xl border-gray-200 bg-gray-50 pl-11 pr-4 py-3.5 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-100 transition-all">{{ old('message') }}</textarea>
                </div>

                <button type="submit"
                        class="group w-full sm:w-auto inline-flex items-center justify-center gap-2.5 bg-brand-600 hover:bg-brand-700 active:scale-[0.98] text-white font-semibold text-base px-8 py-4 rounded-xl shadow-lg shadow-brand-900/10 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <i class="fa-solid fa-paper-plane"></i>
                    Send Message
                    <i class="fa-solid fa-arrow-right text-sm transition-transform group-hover:translate-x-1"></i>
                </button>
            </form>
        </div>

        {{-- Embedded map, spans the full width of the card --}}
        <div class="lg:col-span-5 h-80 sm:h-96 bg-gray-100">
            <iframe
                src="https://www.google.com/maps?q=Planet+Job+Pvt+Ltd,+Dillibazar,+Kathmandu,+Nepal&output=embed"
                class="w-full h-full border-0"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Planet Job Pvt. Ltd. location in Dillibazar, Kathmandu">
            </iframe>
        </div>
    </div>
</div>

@endsection
