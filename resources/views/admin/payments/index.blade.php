{{--
    resources/views/admin/payments/index.blade.php

    ASSUMPTIONS — please adjust to match your app:
    - Extends `layouts.app`, same as admin.dashboard (Font Awesome, Inter, Alpine already global).
    - $payments is a paginator of Payment models with a `user` relation (payer name/email).
    - Payment fields assumed: amount, status ('success'|'pending'|'failed'), payment_method
      (nullable), transaction_id (nullable), created_at.
    - $totals is an array: total_revenue, total_count, pending_count, failed_count.
--}}
@extends('layouts.app')

@section('content')

@php
    $statusStyles = [
        'success' => 'bg-[#2F6F4F]/10 text-[#2F6F4F]',
        'pending' => 'bg-[#C1502E]/10 text-[#C1502E]',
        'failed'  => 'bg-[#5B6660]/10 text-[#5B6660]',
    ];
@endphp

<div id="admin-payments" class="bg-[#F2F4F1] min-h-screen font-[Inter,sans-serif]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
            <div>
                <h1 class="font-[Fraunces,serif] text-3xl sm:text-4xl text-[#14213D]">Payments</h1>
                <p class="text-sm text-[#5B6660] mt-1">All payment activity across the platform.</p>
            </div>
            <a href="{{ url('/admin/dashboard') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md border border-[#D8DAD3] bg-white text-[#14213D] text-sm hover:border-[#14213D] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#14213D] transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                Back to dashboard
            </a>
        </div>

        {{-- KPI strip --}}
        <div class="bg-white border border-[#D8DAD3] rounded-md mb-10">
            <div class="grid grid-cols-2 md:grid-cols-4 divide-y divide-x divide-[#D8DAD3] md:divide-y-0">
                <div class="px-6 py-6">
                    <p class="font-[Fraunces,serif] text-2xl text-[#2F6F4F]">Rs. {{ number_format($totals['total_revenue'], 2) }}</p>
                    <p class="text-sm text-[#5B6660] mt-1">Revenue collected</p>
                </div>
                <div class="px-6 py-6">
                    <p class="font-[Fraunces,serif] text-2xl text-[#14213D]">{{ number_format($totals['total_count']) }}</p>
                    <p class="text-sm text-[#5B6660] mt-1">Total payments</p>
                </div>
                <div class="px-6 py-6">
                    <p class="font-[Fraunces,serif] text-2xl {{ $totals['pending_count'] > 0 ? 'text-[#C1502E]' : 'text-[#14213D]' }}">{{ number_format($totals['pending_count']) }}</p>
                    <p class="text-sm text-[#5B6660] mt-1">Pending</p>
                </div>
                <div class="px-6 py-6">
                    <p class="font-[Fraunces,serif] text-2xl text-[#5B6660]">{{ number_format($totals['failed_count']) }}</p>
                    <p class="text-sm text-[#5B6660] mt-1">Failed</p>
                </div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="mb-4">
            <form method="GET" class="flex items-center gap-2">
                <label for="status" class="text-sm text-[#5B6660]">Filter by status</label>
                <select id="status" name="status" onchange="this.form.submit()"
                        class="text-sm border border-[#D8DAD3] rounded-md px-3 py-1.5 text-[#14213D] bg-white">
                    <option value="">All</option>
                    <option value="success" @selected(request('status') === 'success')>Success</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="failed" @selected(request('status') === 'failed')>Failed</option>
                </select>
            </form>
        </div>

        {{-- Payments table --}}
        <div class="bg-white border border-[#D8DAD3] rounded-md overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[#D8DAD3] text-left text-[#5B6660]">
                        <th class="px-6 py-3 font-medium">Date</th>
                        <th class="px-6 py-3 font-medium">User</th>
                        <th class="px-6 py-3 font-medium">Method</th>
                        <th class="px-6 py-3 font-medium">Transaction ID</th>
                        <th class="px-6 py-3 font-medium text-right">Amount</th>
                        <th class="px-6 py-3 font-medium text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#D8DAD3]">
                    @forelse ($payments as $payment)
                        <tr>
                            <td class="px-6 py-4 text-[#5B6660] whitespace-nowrap">{{ $payment->created_at->format('d M Y, g:i A') }}</td>
                            <td class="px-6 py-4 text-[#14213D]">
                                {{ $payment->user->name ?? 'Unknown user' }}
                                <span class="block text-xs text-[#5B6660]">{{ $payment->user->email ?? '' }}</span>
                            </td>
                            <td class="px-6 py-4 text-[#5B6660]">{{ $payment->payment_method ?? '—' }}</td>
                            <td class="px-6 py-4 text-[#5B6660] font-mono text-xs">{{ $payment->transaction_id ?? '—' }}</td>
                            <td class="px-6 py-4 text-right text-[#14213D] font-medium">Rs. {{ number_format($payment->amount, 2) }}</td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusStyles[$payment->status] ?? 'bg-[#D8DAD3]/50 text-[#5B6660]' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-sm text-[#5B6660] text-center">No payments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $payments->links() }}
        </div>

    </div>
</div>

@endsection
