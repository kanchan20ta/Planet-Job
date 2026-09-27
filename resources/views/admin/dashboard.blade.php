{{--
    resources/views/admin/dashboard.blade.php

    ASSUMPTIONS — please adjust to match your app:
    - Extends `layouts.admin`, which itself extends `layouts.app` and loads Chart.js
      once for all admin views — so this file no longer needs its own Chart.js
      <script> include (removed below; see layouts/admin.blade.php).
    - Quick action links below use plain `url(...)` paths, NOT `route()` helpers, so this
      file won't throw a RouteNotFoundException if the route names differ. Once you confirm
      the real route names, feel free to swap `url('/admin/...')` for `route('admin....')`.
    - Job fields assumed: title, location (nullable), status, created_at, company->name.
    - User fields assumed: name, email, role, created_at.
    - `jobsByMonth` items expose `month` ("Y-m") and `total`.
--}}
@extends('layouts.admin')

@push('styles')
{{-- app.blade.php already loads Font Awesome and Inter site-wide; only Fraunces is new here. --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&display=swap" rel="stylesheet">
<style>
    #admin-dashboard { font-family: 'Inter', sans-serif; }
</style>
@endpush

@section('content')

@php
    $monthLabels = $jobsByMonth->map(fn ($row) => \Carbon\Carbon::createFromFormat('Y-m', $row->month)->format('M Y'))->values();
    $monthTotals = $jobsByMonth->pluck('total')->values();

    $otherUsers = max(0, $stats['total_users'] - $stats['total_employers'] - $stats['total_jobseekers']);

    $statusStyles = [
        'active'  => 'bg-[#2F6F4F]/10 text-[#2F6F4F]',
        'pending' => 'bg-[#C1502E]/10 text-[#C1502E]',
    ];
@endphp

<div id="admin-dashboard" class="bg-[#F2F4F1] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
            <div>
                <h1 class="font-[Fraunces,serif] text-3xl sm:text-4xl text-[#14213D]">Dashboard</h1>
                <p class="text-sm text-[#5B6660] mt-1">A live snapshot of Planet Job's marketplace, {{ now()->format('l, j F Y') }}.</p>
            </div>
        </div>

        {{-- KPI strip --}}
        <div class="bg-white border border-[#D8DAD3] rounded-md mb-10">
            <div class="grid grid-cols-2 md:grid-cols-4 divide-y divide-x divide-[#D8DAD3] md:divide-y-0">
                <div class="px-6 py-6">
                    <p class="font-[Fraunces,serif] text-3xl text-[#14213D]">{{ number_format($stats['total_users']) }}</p>
                    <p class="text-sm text-[#5B6660] mt-1">Registered users</p>
                </div>
                <div class="px-6 py-6">
                    <p class="font-[Fraunces,serif] text-3xl text-[#14213D]">{{ number_format($stats['total_jobs']) }}</p>
                    <p class="text-sm text-[#5B6660] mt-1">Jobs posted</p>
                </div>
                <div class="px-6 py-6">
                    <p class="font-[Fraunces,serif] text-3xl text-[#2F6F4F]">{{ number_format($stats['active_jobs']) }}</p>
                    <p class="text-sm text-[#5B6660] mt-1">Active right now</p>
                </div>
                <div class="px-6 py-6">
                    <p class="font-[Fraunces,serif] text-3xl {{ $stats['pending_jobs'] > 0 ? 'text-[#C1502E]' : 'text-[#14213D]' }}">{{ number_format($stats['pending_jobs']) }}</p>
                    <p class="text-sm text-[#5B6660] mt-1">Awaiting review</p>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 divide-y divide-x divide-[#D8DAD3] md:divide-y-0 border-t border-[#D8DAD3]">
                <div class="px-6 py-6">
                    <p class="font-[Fraunces,serif] text-2xl text-[#14213D]">{{ number_format($stats['total_companies']) }}</p>
                    <p class="text-sm text-[#5B6660] mt-1">Companies</p>
                </div>
                <div class="px-6 py-6">
                    <p class="font-[Fraunces,serif] text-2xl text-[#14213D]">{{ number_format($stats['total_applications']) }}</p>
                    <p class="text-sm text-[#5B6660] mt-1">Applications</p>
                </div>
                <div class="px-6 py-6 col-span-2">
                    <p class="font-[Fraunces,serif] text-2xl text-[#2F6F4F]">Rs. {{ number_format($stats['revenue'], 2) }}</p>
                    <p class="text-sm text-[#5B6660] mt-1">Revenue collected</p>
                </div>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="mb-10">
            <h2 class="font-[Fraunces,serif] text-xl text-[#14213D] mb-4">Quick actions</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ url('/admin/jobs?status=pending') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md bg-[#14213D] text-white text-sm hover:bg-[#1c2c4f] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#14213D] transition-colors">
                    <i class="fa-solid fa-clipboard-check"></i>
                    Review pending jobs
                    @if ($stats['pending_jobs'] > 0)
                        <span class="ml-1 inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1 rounded-full bg-[#C1502E] text-white text-xs">{{ $stats['pending_jobs'] }}</span>
                    @endif
                </a>
                <a href="{{ url('/admin/users') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md border border-[#D8DAD3] bg-white text-[#14213D] text-sm hover:border-[#14213D] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#14213D] transition-colors">
                    <i class="fa-solid fa-users"></i>
                    Manage users
                </a>
                <a href="{{ url('/admin/companies') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md border border-[#D8DAD3] bg-white text-[#14213D] text-sm hover:border-[#14213D] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#14213D] transition-colors">
                    <i class="fa-solid fa-building"></i>
                    Manage companies
                </a>
                <a href="{{ url('/admin/payments') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md border border-[#D8DAD3] bg-white text-[#14213D] text-sm hover:border-[#14213D] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#14213D] transition-colors">
                    <i class="fa-solid fa-receipt"></i>
                    View payments
                </a>
                <a href="{{ url('/admin/settings') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md border border-[#D8DAD3] bg-white text-[#14213D] text-sm hover:border-[#14213D] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#14213D] transition-colors">
                    <i class="fa-solid fa-gear"></i>
                    Site settings
                </a>
            </div>
        </div>

        {{-- Analytics overview --}}
        <div class="mb-10">
            <h2 class="font-[Fraunces,serif] text-xl text-[#14213D] mb-4">Analytics overview</h2>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <div class="lg:col-span-5 bg-white border border-[#D8DAD3] rounded-md p-6">
                    <h3 class="text-sm font-semibold text-[#14213D] mb-1">User mix</h3>
                    <p class="text-sm text-[#5B6660] mb-4">Employers vs. jobseekers on the platform.</p>
                    <div class="relative h-64">
                        <canvas id="userTypesChart" role="img" aria-label="Doughnut chart of user types"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-7 bg-white border border-[#D8DAD3] rounded-md p-6">
                    <h3 class="text-sm font-semibold text-[#14213D] mb-1">Jobs posted per month</h3>
                    <p class="text-sm text-[#5B6660] mb-4">Trailing {{ $monthLabels->count() }} months.</p>
                    <div class="relative h-64">
                        <canvas id="monthlyTrendChart" role="img" aria-label="Bar chart of jobs posted per month"></canvas>
                    </div>
                </div>

            </div>
        </div>

        {{-- Recent activity --}}
        <div>
            <h2 class="font-[Fraunces,serif] text-xl text-[#14213D] mb-4">Recent activity</h2>

            <div class="bg-white border border-[#D8DAD3] rounded-md" data-recent-activity>
                <div class="flex border-b border-[#D8DAD3]">
                    <button type="button" data-tab-target="jobs"
                            class="recent-tab-btn px-5 py-3 text-sm font-medium text-[#14213D] border-b-2 border-[#14213D] -mb-px">
                        Recently posted jobs
                    </button>
                    <button type="button" data-tab-target="users"
                            class="recent-tab-btn px-5 py-3 text-sm font-medium text-[#5B6660] border-b-2 border-transparent -mb-px">
                        Newly joined users
                    </button>
                </div>

                <div data-tab-panel="jobs" class="divide-y divide-[#D8DAD3]">
                    @forelse ($recentJobs as $job)
                        <div class="px-6 py-4 flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-[#14213D] truncate">{{ $job->title }}</p>
                                <p class="text-sm text-[#5B6660] truncate">{{ $job->company->name ?? 'Unknown company' }}@if($job->location) &middot; {{ $job->location }} @endif</p>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusStyles[$job->status] ?? 'bg-[#D8DAD3]/50 text-[#5B6660]' }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                                <span class="text-xs text-[#5B6660] w-20 text-right">{{ $job->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="px-6 py-8 text-sm text-[#5B6660] text-center">No jobs posted yet.</p>
                    @endforelse
                </div>

                <div data-tab-panel="users" class="hidden divide-y divide-[#D8DAD3]">
                    @forelse ($recentUsers as $user)
                        <div class="px-6 py-4 flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-[#14213D] truncate">{{ $user->name }}</p>
                                <p class="text-sm text-[#5B6660] truncate">{{ $user->email }}</p>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#14213D]/5 text-[#14213D] capitalize">
                                    {{ $user->role }}
                                </span>
                                <span class="text-xs text-[#5B6660] w-20 text-right">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="px-6 py-8 text-sm text-[#5B6660] text-center">No users have joined yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
{{-- Chart.js is loaded once by layouts.admin — no need to include it here. --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tabs for the recent activity panel (no framework dependency)
    var wrapper = document.querySelector('[data-recent-activity]');
    if (wrapper) {
        var buttons = wrapper.querySelectorAll('.recent-tab-btn');
        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var target = btn.getAttribute('data-tab-target');

                buttons.forEach(function (b) {
                    var active = b === btn;
                    b.classList.toggle('text-[#14213D]', active);
                    b.classList.toggle('border-[#14213D]', active);
                    b.classList.toggle('text-[#5B6660]', !active);
                    b.classList.toggle('border-transparent', !active);
                });

                wrapper.querySelectorAll('[data-tab-panel]').forEach(function (panel) {
                    panel.classList.toggle('hidden', panel.getAttribute('data-tab-panel') !== target);
                });
            });
        });
    }

    var inkColor = '#14213D';
    var mutedColor = '#5B6660';
    var borderColor = '#D8DAD3';

    // Doughnut chart: user mix, with total registered users in the center
    var userTypesEl = document.getElementById('userTypesChart');
    if (userTypesEl) {
        var centerTextPlugin = {
            id: 'centerText',
            afterDraw: function (chart) {
                var ctx = chart.ctx;
                var total = chart.data.datasets[0].data.reduce(function (a, b) { return a + b; }, 0);
                var x = chart.getDatasetMeta(0).data[0] ? chart.getDatasetMeta(0).data[0].x : chart.width / 2;
                var y = chart.getDatasetMeta(0).data[0] ? chart.getDatasetMeta(0).data[0].y : chart.height / 2;

                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = '600 20px Inter, sans-serif';
                ctx.fillStyle = inkColor;
                ctx.fillText(total.toLocaleString(), x, y - 10);
                ctx.font = '500 11px Inter, sans-serif';
                ctx.fillStyle = mutedColor;
                ctx.fillText('total users', x, y + 12);
                ctx.restore();
            }
        };

        new Chart(userTypesEl, {
            type: 'doughnut',
            data: {
                labels: [
                    'Employers',
                    'Jobseekers',
                    @if($otherUsers > 0) 'Other', @endif
                ],
                datasets: [{
                    data: [
                        {{ $stats['total_employers'] }},
                        {{ $stats['total_jobseekers'] }},
                        @if($otherUsers > 0) {{ $otherUsers }}, @endif
                    ],
                    backgroundColor: ['#14213D', '#2F6F4F', '#C1502E'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: inkColor, boxWidth: 12, padding: 16, font: { size: 12 } }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                var total = ctx.dataset.data.reduce(function (a, b) { return a + b; }, 0);
                                var pct = total > 0 ? Math.round((ctx.parsed / total) * 100) : 0;
                                return ' ' + ctx.label + ': ' + ctx.parsed.toLocaleString() + ' (' + pct + '%)';
                            }
                        }
                    }
                }
            },
            plugins: [centerTextPlugin]
        });
    }

    // Bar chart: jobs posted per month
    var monthlyEl = document.getElementById('monthlyTrendChart');
    if (monthlyEl) {
        new Chart(monthlyEl, {
            type: 'bar',
            data: {
                labels: @json($monthLabels),
                datasets: [{
                    label: 'Jobs posted',
                    data: @json($monthTotals),
                    backgroundColor: '#2F6F4F',
                    hoverBackgroundColor: '#14213D',
                    borderRadius: 6,
                    borderSkipped: false,
                    maxBarThickness: 42,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (ctx) { return ' ' + ctx.parsed.y.toLocaleString() + ' jobs posted'; }
                        }
                    }
                },
                scales: {
                    x: { ticks: { color: mutedColor, font: { size: 11 } }, grid: { display: false } },
                    y: { beginAtZero: true, ticks: { color: mutedColor, font: { size: 11 }, precision: 0 }, grid: { color: borderColor } }
                }
            }
        });
    }
});
</script>
@endpush
