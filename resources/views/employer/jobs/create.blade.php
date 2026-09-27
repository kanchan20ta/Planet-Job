@extends('layouts.panel')
@section('title', 'Post a Job - Planet Job Portal')

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
<h1 class="text-xl font-bold text-gray-900 mb-6">Post a New Job</h1>

@if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-6">
        <ul class="list-disc pl-5">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form method="POST" action="{{ route('employer.jobs.store') }}" class="bg-white border border-gray-200 rounded-xl p-6">
    @csrf
    @include('employer.jobs._form')
    <button type="submit" class="mt-6 bg-brand-600 text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-brand-700 text-sm">
        Submit for Approval
    </button>
</form>
@endsection
