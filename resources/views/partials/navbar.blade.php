<header class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                
                <div>
                    <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="w-full h-32">
                    
                </div>
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="{{ route('jobs.index') }}" class="hover:text-brand-600">Find Jobs</a>
                <a href="{{ route('blog.index') }}" class="hover:text-brand-600">Blog</a>
                <a href="{{ route('faq') }}" class="hover:text-brand-600">FAQ</a>
                <a href="{{ route('contact.create') }}" class="hover:text-brand-600">Contact</a>
                @auth
                    @if (auth()->user()->isEmployer())
                        <a href="{{ route('employer.subscription.index') }}" class="hover:text-brand-600">Pricing</a>
                    @endif
                @endauth
            </div>

            <div class="flex items-center gap-3">
                 @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-brand-600">Login</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold bg-brand-600 text-white px-4 py-2 rounded-lg hover:bg-brand-700">Register</a>
                  @endguest
                 @auth
                    @php
                        $dashboardRoute = match(auth()->user()->role) {
                            'admin' => 'admin.dashboard',
                            'employer' => 'employer.dashboard',
                            default => 'jobseeker.dashboard',
                        };
                        $unreadCount = auth()->user()->unreadNotifications()->count();
                    @endphp
                    <a href="{{ route('notifications.index') }}" class="relative text-gray-500 hover:text-brand-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if ($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center">{{ min($unreadCount, 9) }}</span>
                        @endif
                    </a>
                    <a href="{{ route('settings.edit') }}" class="text-sm font-medium text-gray-600 hover:text-brand-600">Settings</a>
                    <a href="{{ route($dashboardRoute) }}" class="text-sm font-medium text-gray-600 hover:text-brand-600">
                        Hi, {{ explode(' ', auth()->user()->name)[0] }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm font-semibold bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>
</header>
