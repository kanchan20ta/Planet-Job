@extends('layouts.app')
@section('title', 'Account Settings - Planet Job Portal')

@php
    // Shared input styling: visible border + subtle fill at rest, brighter fill and a
    // colored ring on focus, and a darker border on hover so the field reads as
    // interactive before it's even clicked.
    $inputBase = 'w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 placeholder-gray-400 px-3.5 py-2.5 transition-colors duration-150 hover:border-gray-400 hover:bg-white focus:bg-white focus:border-brand-600 focus:ring-4 focus:ring-brand-600/15 focus:outline-none';
    $inputError = 'border-red-300 bg-red-50 hover:border-red-400 focus:border-red-500 focus:ring-red-500/15';
@endphp

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-14">

    <div class="mb-10">
        <h1 class="text-2xl font-bold text-gray-900">Account settings</h1>
        <p class="text-sm text-gray-500 mt-1">Update your profile details and password.</p>
    </div>

    @if (session('success'))
        <div class="bg-brand-50 border border-brand-200 text-brand-800 text-sm px-4 py-3 rounded-lg mb-8">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-10">

        {{-- Basic information --}}
        <section class="bg-white border border-gray-200 rounded-xl">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="font-semibold text-gray-900">Basic information</h2>
                <p class="text-sm text-gray-500 mt-0.5">Your name and contact details.</p>
            </div>

            <form method="POST" action="{{ route('settings.update') }}" class="px-6 py-6">
                @csrf @method('PUT')

                <div class="space-y-6">
                    <div class="sm:grid sm:grid-cols-3 sm:gap-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 sm:pt-2.5">Full name</label>
                        <div class="mt-1.5 sm:mt-0 sm:col-span-2">
                            <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                   class="{{ $inputBase }} @error('name') {{ $inputError }} @enderror">
                            @error('name')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:gap-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 sm:pt-2.5">Email</label>
                        <div class="mt-1.5 sm:mt-0 sm:col-span-2">
                            <input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                   class="{{ $inputBase }} @error('email') {{ $inputError }} @enderror">
                            @error('email')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:gap-6">
                        <label for="phone" class="block text-sm font-medium text-gray-700 sm:pt-2.5">Phone</label>
                        <div class="mt-1.5 sm:mt-0 sm:col-span-2">
                            <input id="phone" type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                   class="{{ $inputBase }} @error('phone') {{ $inputError }} @enderror">
                            @error('phone')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                    <button class="bg-brand-600 text-white font-semibold px-6 py-2.5 rounded-lg text-sm shadow-sm hover:bg-brand-700 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm transition-all duration-150 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                        Save changes
                    </button>
                </div>
            </form>
        </section>

        {{-- Change password --}}
        <section class="bg-white border border-gray-200 rounded-xl">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="font-semibold text-gray-900">Change password</h2>
                <p class="text-sm text-gray-500 mt-0.5">Choose a new password for your account.</p>
            </div>

            <form method="POST" action="{{ route('settings.password') }}" class="px-6 py-6">
                @csrf @method('PUT')

                <div class="space-y-6">
                    <div class="sm:grid sm:grid-cols-3 sm:gap-6">
                        <label for="current_password" class="block text-sm font-medium text-gray-700 sm:pt-2.5">Current password</label>
                        <div class="mt-1.5 sm:mt-0 sm:col-span-2">
                            <div class="relative" x-data="{ show: false }">
                                <input :type="show ? 'text' : 'password'" id="current_password" name="current_password" required
                                       class="{{ $inputBase }} pr-10 @error('current_password') {{ $inputError }} @enderror">
                                <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 rounded-r-lg"
                                        :aria-label="show ? 'Hide password' : 'Show password'">
                                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:gap-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 sm:pt-2.5">New password</label>
                        <div class="mt-1.5 sm:mt-0 sm:col-span-2">
                            <div class="relative" x-data="{ show: false }">
                                <input :type="show ? 'text' : 'password'" id="password" name="password" required
                                       class="{{ $inputBase }} pr-10 @error('password') {{ $inputError }} @enderror">
                                <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 rounded-r-lg"
                                        :aria-label="show ? 'Hide password' : 'Show password'">
                                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            <p class="mt-1.5 text-xs text-gray-400">At least 8 characters.</p>
                            @error('password')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:gap-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 sm:pt-2.5">Confirm password</label>
                        <div class="mt-1.5 sm:mt-0 sm:col-span-2">
                            <div class="relative" x-data="{ show: false }">
                                <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                                       class="{{ $inputBase }} pr-10">
                                <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 rounded-r-lg"
                                        :aria-label="show ? 'Hide password' : 'Show password'">
                                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                    <button class="bg-gray-800 text-white font-semibold px-6 py-2.5 rounded-lg text-sm shadow-sm hover:bg-gray-900 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm transition-all duration-150 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800">
                        Update password
                    </button>
                </div>
            </form>
        </section>

    </div>
</div>
@endsection
