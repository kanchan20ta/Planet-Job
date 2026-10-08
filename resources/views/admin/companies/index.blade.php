{{--
    ASSUMPTIONS — adjust to match your app:
    - Company hasOne `latestPayment` (latestOfMany, via user_id) with: status ('success'|'pending'|'failed'),
      payment_proof (nullable storage path on the "public" disk), transaction_id (nullable), amount.
    - Payment belongsTo `subscriptionPlan` (has `name`).
    - Route `admin.companies.approve-payment` (POST, receives {company}) exists.
    - Controller eager loads: Company::with(['latestPayment.subscriptionPlan'])->withCount('jobs')
--}}
@extends('layouts.panel')
@section('title', 'Manage Companies - Planet Job Portal')

@php
$panelTitle = 'Admin Panel';
$panelLinks = [
    ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'active' => 'admin.dashboard'],
    ['label' => 'Jobs', 'url' => route('admin.jobs.index'), 'active' => 'admin.jobs.*'],
    ['label' => 'Users', 'url' => route('admin.users.index'), 'active' => 'admin.users.*'],
    ['label' => 'Companies', 'url' => route('admin.companies.index'), 'active' => 'admin.companies.*'],
    ['label' => 'Subscription Plans', 'url' => route('admin.subscription-plans.index'), 'active' => 'admin.subscription-plans.*'],
    ['label' => 'Blog', 'url' => route('admin.blogs.index'), 'active' => 'admin.blogs.*'],
    ['label' => 'FAQs', 'url' => route('admin.faqs.index'), 'active' => 'admin.faqs.*'],
    ['label' => 'Pages', 'url' => route('admin.pages.index'), 'active' => 'admin.pages.*'],
    ['label' => 'Contact Messages', 'url' => route('admin.contact-messages.index'), 'active' => 'admin.contact-messages.*'],
];

// Maps a payment status to badge label + Tailwind classes.
$statusBadge = fn ($status) => match ($status) {
    'success' => ['Active', 'bg-green-50 text-green-700 ring-green-600/20'],
    'pending' => ['Pending approval', 'bg-amber-50 text-amber-700 ring-amber-600/20'],
    'failed'  => ['Failed', 'bg-red-50 text-red-700 ring-red-600/20'],
    default   => ['No payment', 'bg-gray-50 text-gray-600 ring-gray-500/20'],
};
@endphp

@section('panel-content')
<div class="mb-6 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Manage Companies</h1>
        <p class="text-sm text-gray-500">Review company subscriptions and approve pending payments.</p>
    </div>
    <p class="text-xs text-gray-400">{{ $companies->total() }} {{ \Illuminate\Support\Str::plural('company', $companies->total()) }} total</p>
</div>

@if (session('success'))
    <div class="mb-4 flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif

@if ($companies->isEmpty())
    <div class="rounded-xl border border-dashed border-gray-300 bg-white p-12 text-center">
        <p class="text-sm text-gray-400">No companies yet.</p>
    </div>
@else
    {{-- Desktop / tablet table --}}
    <div class="hidden overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm md:block">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        <th scope="col" class="px-5 py-3">Company</th>
                        <th scope="col" class="px-5 py-3">Subscription Plan</th>
                        <th scope="col" class="px-5 py-3">Payment Proof</th>
                        <th scope="col" class="px-5 py-3">Status</th>
                        <th scope="col" class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($companies as $company)
                        @php
                            $payment = $company->latestPayment;
                            $plan = $payment?->subscriptionPlan;
                            [$badgeLabel, $badgeClasses] = $statusBadge($payment?->status);
                            $proofUrl = $payment?->payment_proof ? asset('storage/' . $payment->payment_proof) : null;
                            $isImage = $proofUrl && \Illuminate\Support\Str::endsWith(strtolower($payment->payment_proof), ['.jpg', '.jpeg', '.png', '.webp', '.gif']);
                        @endphp
                        <tr class="transition hover:bg-gray-50/70">
                            {{-- Company --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 font-bold text-brand-700">
                                        {{ strtoupper(substr($company->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-1.5">
                                            <a href="{{ route('companies.show', $company) }}" class="truncate font-medium text-gray-900 hover:text-brand-600">{{ $company->name }}</a>
                                            @if ($company->is_verified)
                                                <svg class="h-4 w-4 shrink-0 text-green-500" viewBox="0 0 20 20" fill="currentColor" aria-label="Verified"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7 7a1 1 0 01-1.4 0l-3-3a1 1 0 111.4-1.4L9 11.6l6.3-6.3a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-400">{{ $company->jobs_count }} {{ \Illuminate\Support\Str::plural('job', $company->jobs_count) }} &middot; {{ $company->city ?: '—' }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Subscription plan --}}
                            <td class="px-5 py-4">
                                @if ($plan)
                                    <span class="inline-flex items-center rounded-md bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-700 ring-1 ring-inset ring-brand-600/20">{{ $plan->name }}</span>
                                @else
                                    <span class="text-xs text-gray-400">No plan</span>
                                @endif
                            </td>

                            {{-- Payment proof --}}
                            <td class="px-5 py-4">
                                @if ($proofUrl)
                                    <a href="{{ $proofUrl }}" target="_blank" rel="noopener" class="group inline-flex items-center gap-2">
                                        @if ($isImage)
                                            <img src="{{ $proofUrl }}" alt="Payment proof for {{ $company->name }}" class="h-10 w-10 rounded-md border border-gray-200 object-cover">
                                        @else
                                            <span class="flex h-10 w-10 items-center justify-center rounded-md border border-gray-200 bg-gray-50 text-gray-500">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.63a3.38 3.38 0 00-3.38-3.37h-1.5A1.13 1.13 0 0113.5 7.13v-1.5a3.38 3.38 0 00-3.38-3.38H8.25m2.25 0H5.63c-.62 0-1.13.5-1.13 1.13v17.25c0 .62.5 1.12 1.13 1.12h12.75c.62 0 1.12-.5 1.12-1.12V11.25a9 9 0 00-9-9z"/></svg>
                                            </span>
                                        @endif
                                        <span class="text-xs font-medium text-brand-600 group-hover:underline">View proof</span>
                                    </a>
                                    @if ($payment->transaction_id)
                                        <p class="mt-1 text-[11px] text-gray-400">Txn: {{ $payment->transaction_id }}</p>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400">Not uploaded</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $badgeClasses }}">{{ $badgeLabel }}</span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($payment?->status === 'pending')
                                        <form method="POST" action="{{ route('admin.companies.approve-payment', $company) }}"
                                              onsubmit="return confirm('Approve this payment and activate the subscription for {{ e($company->name) }}?');">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-1">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                Approve
                                            </button>
                                        </form>
                                    @endif

                                    @unless ($company->is_verified)
                                        <form method="POST" action="{{ route('admin.companies.verify', $company) }}">
                                            @csrf
                                            <button type="submit" class="rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">Verify</button>
                                        </form>
                                    @endunless

                                    @if ($payment?->status !== 'pending' && $company->is_verified)
                                        <span class="text-xs text-gray-300">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Mobile cards --}}
    <div class="space-y-3 md:hidden">
        @foreach ($companies as $company)
            @php
                $payment = $company->latestPayment;
                $plan = $payment?->subscriptionPlan;
                [$badgeLabel, $badgeClasses] = $statusBadge($payment?->status);
                $proofUrl = $payment?->payment_proof ? asset('storage/' . $payment->payment_proof) : null;
            @endphp
            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex min-w-0 items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 font-bold text-brand-700">
                            {{ strtoupper(substr($company->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <a href="{{ route('companies.show', $company) }}" class="block truncate font-medium text-gray-900 hover:text-brand-600">{{ $company->name }}</a>
                            <p class="text-xs text-gray-400">{{ $company->jobs_count }} {{ \Illuminate\Support\Str::plural('job', $company->jobs_count) }} &middot; {{ $company->city ?: '—' }}</p>
                        </div>
                    </div>
                    <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $badgeClasses }}">{{ $badgeLabel }}</span>
                </div>

                <dl class="mt-4 grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Plan</dt>
                        <dd class="mt-1 text-gray-800">{{ $plan?->name ?? 'No plan' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Payment proof</dt>
                        <dd class="mt-1">
                            @if ($proofUrl)
                                <a href="{{ $proofUrl }}" target="_blank" rel="noopener" class="font-medium text-brand-600 hover:underline">View proof</a>
                            @else
                                <span class="text-gray-400">Not uploaded</span>
                            @endif
                        </dd>
                    </div>
                </dl>

                @if ($payment?->status === 'pending' || ! $company->is_verified)
                    <div class="mt-4 flex gap-2 border-t border-gray-100 pt-4">
                        @if ($payment?->status === 'pending')
                            <form method="POST" action="{{ route('admin.companies.approve-payment', $company) }}" class="flex-1"
                                  onsubmit="return confirm('Approve this payment and activate the subscription for {{ e($company->name) }}?');">
                                @csrf
                                <button type="submit" class="w-full rounded-lg bg-brand-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">Approve</button>
                            </form>
                        @endif
                        @unless ($company->is_verified)
                            <form method="POST" action="{{ route('admin.companies.verify', $company) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">Verify</button>
                            </form>
                        @endunless
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif

<div class="mt-6">{{ $companies->links() }}</div>
@endsection
