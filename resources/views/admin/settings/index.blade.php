{{--
    IMPORTANT — save this file at exactly:
    resources/views/admin/settings/index.blade.php

    (Create the "settings" folder inside resources/views/admin/ if it doesn't exist yet,
    and make sure the file itself is named index.blade.php.)

    ASSUMPTIONS — please adjust to match your app:
    - Extends `layouts.app`, same as admin.dashboard and admin.payments.index.
    - $settings is a key => value collection (see Admin\SettingController) with keys:
      site_name, contact_email, support_phone, maintenance_mode.
--}}
@extends('layouts.app')

@section('content')

<div id="admin-settings" class="bg-[#F2F4F1] min-h-screen font-[Inter,sans-serif]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
            <div>
                <h1 class="font-[Fraunces,serif] text-3xl sm:text-4xl text-[#14213D]">Site settings</h1>
                <p class="text-sm text-[#5B6660] mt-1">Global configuration for the platform.</p>
            </div>
            <a href="{{ url('/admin/dashboard') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md border border-[#D8DAD3] bg-white text-[#14213D] text-sm hover:border-[#14213D] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#14213D] transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                Back to dashboard
            </a>
        </div>

        @if (session('status'))
            <div class="mb-6 px-4 py-3 rounded-md bg-[#2F6F4F]/10 text-[#2F6F4F] text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}" class="bg-white border border-[#D8DAD3] rounded-md p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="site_name" class="block text-sm font-medium text-[#14213D] mb-1">Site name</label>
                <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}"
                       class="w-full border border-[#D8DAD3] rounded-md px-3 py-2 text-sm text-[#14213D]">
                @error('site_name') <p class="text-xs text-[#C1502E] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="contact_email" class="block text-sm font-medium text-[#14213D] mb-1">Contact email</label>
                <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                       class="w-full border border-[#D8DAD3] rounded-md px-3 py-2 text-sm text-[#14213D]">
                @error('contact_email') <p class="text-xs text-[#C1502E] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="support_phone" class="block text-sm font-medium text-[#14213D] mb-1">Support phone</label>
                <input type="text" name="support_phone" id="support_phone" value="{{ old('support_phone', $settings['support_phone'] ?? '') }}"
                       class="w-full border border-[#D8DAD3] rounded-md px-3 py-2 text-sm text-[#14213D]">
                @error('support_phone') <p class="text-xs text-[#C1502E] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="maintenance_mode" id="maintenance_mode" value="1"
                       @checked(old('maintenance_mode', $settings['maintenance_mode'] ?? false))
                       class="rounded border-[#D8DAD3]">
                <label for="maintenance_mode" class="text-sm text-[#14213D]">Enable maintenance mode</label>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="px-4 py-2.5 rounded-md bg-[#14213D] text-white text-sm hover:bg-[#1c2c4f] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#14213D] transition-colors">
                    Save settings
                </button>
            </div>
        </form>

    </div>
</div>

@endsection
