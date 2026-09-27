@extends('layouts.panel')
@section('title', 'Edit Job - Planet Job Portal')

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
<h1 class="text-xl font-bold text-gray-900 mb-6">Edit Job</h1>

<form method="POST" action="{{ route('employer.jobs.update', $job) }}" class="bg-white border border-gray-200 rounded-xl p-6">
    @csrf @method('PUT')
    @include('employer.jobs._form')
    <button type="submit" class="mt-6 bg-brand-600 text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-brand-700 text-sm">
        Save Changes
    </button>
</form>
@endsection
