{{--
    resources/views/layouts/admin.blade.php

    Shared layout for admin-only pages that need Chart.js. Extends the main
    site layout, so it gets the navbar/footer/flash messages for free, and
    additionally loads Chart.js once here so individual admin views (dashboard,
    reports, etc.) don't each need their own <script> include.

    Usage in an admin view:
        @extends('layouts.admin')

        @section('content')
            ... your markup, <canvas> elements, etc. ...
        @endsection

        @push('scripts')
            <script>
                // new Chart(...) calls — Chart.js is already loaded by this layout
            </script>
        @endpush

    No need to redeclare @section('content') here: Blade resolves sections
    across the full extends chain, so whatever the child view puts in
    @section('content') flows through to layouts.app's @yield('content')
    automatically.
--}}
@extends('layouts.app')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
@endpush
