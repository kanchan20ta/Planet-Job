<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Employer Panel') · {{ config('app.name', 'JobBoard') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,400;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --ink: #14213D;
            --ink-soft: #1E2E52;
            --paper: #F6F7F9;
            --marigold: #E8A33D;
            --marigold-dark: #C7842A;
            --teal: #1F6F63;
            --slate: #3C4257;
            --slate-soft: #6B7280;
            --border: #E3E6EC;
            --danger: #C24B32;
            --success: #1F7A4D;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            background: var(--paper);
            color: var(--slate);
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            line-height: 1.6;
        }

        h1, h2, h3, h4 {
            font-family: 'Source Serif 4', serif;
            color: var(--ink);
            margin: 0;
        }

        a { color: var(--teal); text-decoration: none; }
        a:hover { text-decoration: underline; }

        :focus-visible {
            outline: 3px solid var(--marigold);
            outline-offset: 2px;
        }

        .skip-link {
            position: absolute;
            left: -9999px;
            top: 0;
            background: var(--ink);
            color: #fff;
            padding: 0.75rem 1.25rem;
            z-index: 1000;
            border-radius: 0 0 6px 0;
        }
        .skip-link:focus { left: 0; }

        /* App shell */
        .app-shell {
            display: grid;
            grid-template-columns: 248px 1fr;
            min-height: 100vh;
        }

        @media (max-width: 900px) {
            .app-shell { grid-template-columns: 1fr; }
            .app-sidebar { display: none; }
            .app-shell.nav-open .app-sidebar {
                display: block;
                position: fixed;
                inset: 0 30% 0 0;
                z-index: 200;
            }
        }

        /* Sidebar */
        .app-sidebar {
            background: var(--ink);
            color: rgba(255,255,255,0.85);
            display: flex;
            flex-direction: column;
            padding: 1.5rem 1rem;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .app-sidebar__brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0 0.5rem 1.5rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.12);
        }

        .app-sidebar__brand-mark {
            width: 32px;
            height: 32px;
            border-radius: 7px;
            background: var(--marigold);
            color: var(--ink);
            font-family: 'Source Serif 4', serif;
            font-weight: 700;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .app-sidebar__brand-name {
            color: #fff;
            font-weight: 600;
            font-size: 1rem;
        }

        .app-sidebar__section-label {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.45);
            padding: 0 0.65rem;
            margin: 1.1rem 0 0.4rem;
        }

        .app-nav {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .app-nav a {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.55rem 0.65rem;
            border-radius: 6px;
            color: rgba(255,255,255,0.78);
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
        }

        .app-nav a:hover {
            background: rgba(255,255,255,0.06);
            color: #fff;
        }

        .app-nav a[aria-current="page"] {
            background: rgba(232, 163, 61, 0.16);
            color: #fff;
            box-shadow: inset 3px 0 0 var(--marigold);
        }

        .app-nav .icon-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.6;
            flex-shrink: 0;
        }

        .app-sidebar__footer {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,0.12);
        }

        .app-sidebar__logout {
            display: block;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            color: rgba(255,255,255,0.7);
            font: inherit;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.55rem 0.65rem;
            border-radius: 6px;
            cursor: pointer;
        }
        .app-sidebar__logout:hover { background: rgba(255,255,255,0.06); color: #fff; }

        /* Main column */
        .app-main {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .app-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.75rem;
            background: #fff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .app-topbar__title {
            font-size: 1.15rem;
            font-weight: 600;
        }

        .app-topbar__actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .app-topbar__icon-link {
            position: relative;
            display: inline-flex;
            width: 36px;
            height: 36px;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: var(--slate);
            text-decoration: none;
        }
        .app-topbar__icon-link:hover { background: var(--paper); }

        .app-topbar__badge {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--marigold-dark);
        }

        .app-topbar__user {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding-left: 0.75rem;
            border-left: 1px solid var(--border);
        }

        .app-topbar__avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--ink);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .app-topbar__user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.2;
        }

        .app-topbar__user-role {
            font-size: 0.75rem;
            color: var(--slate-soft);
        }

        .nav-toggle {
            display: none;
            background: none;
            border: 1px solid var(--border);
            border-radius: 6px;
            width: 36px;
            height: 36px;
            cursor: pointer;
        }

        @media (max-width: 900px) {
            .nav-toggle { display: inline-flex; align-items: center; justify-content: center; }
        }

        /* Flash messages */
        .app-flashes {
            max-width: 1080px;
            margin: 1.25rem auto 0;
            padding: 0 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .flash {
            padding: 0.85rem 1.1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            border: 1px solid transparent;
        }

        .flash--success { background: rgba(31, 122, 77, 0.08); border-color: rgba(31, 122, 77, 0.25); color: var(--success); }
        .flash--error { background: rgba(194, 75, 50, 0.08); border-color: rgba(194, 75, 50, 0.25); color: var(--danger); }

        /* Content area */
        .app-content {
            flex: 1;
        }

        .app-content--padded {
            max-width: 1080px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem 1.75rem 3rem;
        }
    </style>

    @stack('styles')
</head>
<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <div class="app-shell" id="appShell">

        <nav class="app-sidebar" aria-label="Employer navigation">
            <div class="app-sidebar__brand">
                <span class="app-sidebar__brand-mark" aria-hidden="true">{{ Str::substr(config('app.name', 'JB'), 0, 1) }}</span>
                <span class="app-sidebar__brand-name">{{ config('app.name', 'JobBoard') }}</span>
            </div>

            <p class="app-sidebar__section-label">Overview</p>
            <ul class="app-nav">
                <li>
                    <a href="{{ route('employer.dashboard') }}" @if(request()->routeIs('employer.dashboard')) aria-current="page" @endif>
                        <span class="icon-dot" aria-hidden="true"></span> Dashboard
                    </a>
                </li>
            </ul>

            <p class="app-sidebar__section-label">Hiring</p>
            <ul class="app-nav">
                <li>
                    <a href="{{ route('employer.jobs.index') }}" @if(request()->routeIs('employer.jobs.*')) aria-current="page" @endif>
                        <span class="icon-dot" aria-hidden="true"></span> Job posts
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.subscription.index') }}" @if(request()->routeIs('employer.subscription.*')) aria-current="page" @endif>
                        <span class="icon-dot" aria-hidden="true"></span> Subscription
                    </a>
                </li>
            </ul>

            <p class="app-sidebar__section-label">Account</p>
            <ul class="app-nav">
                <li>
                    <a href="{{ route('employer.company.edit') }}" @if(request()->routeIs('employer.company.*')) aria-current="page" @endif>
                        <span class="icon-dot" aria-hidden="true"></span> Company profile
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.edit') }}" @if(request()->routeIs('settings.*')) aria-current="page" @endif>
                        <span class="icon-dot" aria-hidden="true"></span> Settings
                    </a>
                </li>
            </ul>

            <div class="app-sidebar__footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="app-sidebar__logout">Log out</button>
                </form>
            </div>
        </nav>

        <div class="app-main">

            <header class="app-topbar">
                <div style="display:flex; align-items:center; gap:0.85rem;">
                    <button type="button" class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="appShell"
                        onclick="document.getElementById('appShell').classList.toggle('nav-open'); this.setAttribute('aria-expanded', document.getElementById('appShell').classList.contains('nav-open'));">
                        ☰
                    </button>
                    <h1 class="app-topbar__title">@yield('title', 'Employer Panel')</h1>
                </div>

                <div class="app-topbar__actions">
                    <a href="{{ route('notifications.index') }}" class="app-topbar__icon-link" aria-label="Notifications">
                        🔔
                        @if(auth()->check() && method_exists(auth()->user(), 'unreadNotifications') && auth()->user()->unreadNotifications()->count() > 0)
                            <span class="app-topbar__badge" aria-hidden="true"></span>
                        @endif
                    </a>

                    @auth
                        <div class="app-topbar__user">
                            <span class="app-topbar__avatar" aria-hidden="true">
                                {{ Str::substr(auth()->user()->name ?? 'E', 0, 1) }}
                            </span>
                            <span>
                                <span class="app-topbar__user-name" style="display:block;">{{ auth()->user()->name ?? 'Employer' }}</span>
                                <span class="app-topbar__user-role">Employer</span>
                            </span>
                        </div>
                    @endauth
                </div>
            </header>

            @if (session('success') || session('error') || $errors->any())
                <div class="app-flashes">
                    @if (session('success'))
                        <div class="flash flash--success" role="status">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="flash flash--error" role="alert">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="flash flash--error" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif
                </div>
            @endif

            <main id="main-content" class="app-content">
                @hasSection('content-padded')
                    <div class="app-content--padded">
                        @yield('content-padded')
                    </div>
                @else
                    @yield('content')
                @endif
            </main>

        </div>
    </div>

    @stack('scripts')
</body>
</html>
