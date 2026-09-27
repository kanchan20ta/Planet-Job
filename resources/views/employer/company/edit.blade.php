@extends('layouts.panel')
@section('title', 'Company Profile - Planet Job Portal')

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
<h1 class="text-xl font-bold text-gray-900 mb-6">Company Profile</h1>

<form method="POST" action="{{ route('employer.company.update') }}" enctype="multipart/form-data"
      class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 sm:p-8 space-y-8">
    @csrf @method('PUT')

    <div>
        <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Company Details</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Company Name</label>
                <input type="text" name="name" value="{{ old('name', $company->name) }}" required
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Industry</label>
                <input type="text" name="industry" value="{{ old('industry', $company->industry) }}"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Company Size</label>
                <select name="company_size"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                    @foreach (['1-10','11-50','51-200','201-500','501-1000','1000+'] as $size)
                        <option value="{{ $size }}" @selected($company->company_size === $size)>{{ $size }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Website</label>
                <input type="url" name="website" value="{{ old('website', $company->website) }}" placeholder="https://"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $company->email) }}"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $company->phone) }}"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">City</label>
                <input type="text" name="city" value="{{ old('city', $company->city) }}"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            </div>
        </div>

        <div class="mt-5">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
            <textarea name="description" rows="4"
                class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 leading-relaxed placeholder-gray-400 shadow-sm transition-colors focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">{{ old('description', $company->description) }}</textarea>
        </div>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Branding</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Logo --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Logo</label>
                <div class="flex items-center gap-4">
                    <div class="shrink-0 h-16 w-16 rounded-lg border border-gray-300 bg-gray-50 overflow-hidden flex items-center justify-center">
                        <img id="logo-preview"
                             src="{{ $company->logo ? asset('storage/' . $company->logo) : '' }}"
                             alt="Logo preview"
                             class="h-full w-full object-cover {{ $company->logo ? '' : 'hidden' }}">
                        <span id="logo-placeholder" class="text-[10px] text-gray-400 text-center px-1 {{ $company->logo ? 'hidden' : '' }}">No logo</span>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="logo" accept="image/*" id="logo-input"
                            class="block w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border file:border-gray-300 file:bg-white file:px-3 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-50 file:cursor-pointer cursor-pointer">
                        <p class="mt-1 text-xs text-gray-400">PNG or JPG, square works best.</p>
                    </div>
                </div>
            </div>

            {{-- Cover Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Cover Image</label>
                <div class="flex items-center gap-4">
                    <div class="shrink-0 h-16 w-28 rounded-lg border border-gray-300 bg-gray-50 overflow-hidden flex items-center justify-center">
                        <img id="cover-preview"
                             src="{{ $company->cover_image ? asset('storage/' . $company->cover_image) : '' }}"
                             alt="Cover image preview"
                             class="h-full w-full object-cover {{ $company->cover_image ? '' : 'hidden' }}">
                        <span id="cover-placeholder" class="text-[10px] text-gray-400 text-center px-1 {{ $company->cover_image ? 'hidden' : '' }}">No cover</span>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="cover_image" accept="image/*" id="cover-input"
                            class="block w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border file:border-gray-300 file:bg-white file:px-3 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-50 file:cursor-pointer cursor-pointer">
                        <p class="mt-1 text-xs text-gray-400">Recommended 1200x300px.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <button type="submit" class="bg-brand-600 text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-brand-700 transition-colors text-sm">
            Save Changes
        </button>
    </div>
</form>

@push('scripts')
<script>
    function wireImagePreview(inputId, previewId, placeholderId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const placeholder = document.getElementById(placeholderId);
        if (!input) return;

        input.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        });
    }

    wireImagePreview('logo-input', 'logo-preview', 'logo-placeholder');
    wireImagePreview('cover-input', 'cover-preview', 'cover-placeholder');
</script>
@endpush
@endsection
