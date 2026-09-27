{{-- Font Awesome CDN: ideally place this once in your main layout's <head> (e.g. layouts/app.blade.php)
     instead of inside this footer partial, so it isn't loaded twice if the footer is ever reused. --}}
@once
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
@endonce

<footer class="relative bg-gradient-to-b from-gray-900 to-gray-950 text-gray-300 mt-10 border-t-2 border-brand-600 shadow-[0_-10px_30px_-15px_rgba(0,0,0,0.5)]">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-6">

        {{-- Brand column: full logo (links to top), tagline, social icons --}}
        <div class="flex flex-col items-center text-center md:items-start md:text-left">
            <a href="#" aria-label="Back to top" class="inline-block mb-3 transition-transform duration-200 hover:scale-105">
                <img src="{{ asset('images/logo2.png') }}" alt="Planet Job" class="h-20 w-auto drop-shadow-lg">
            </a>

            <p class="text-sm text-gray-400 leading-relaxed max-w-xs">
                Connecting talent with opportunity &mdash; new jobs added daily.
            </p>

            <div class="flex flex-nowrap items-center justify-center md:justify-start gap-2 mt-4">
                <a href="https://www.facebook.com/planetjob.com.np" target="_blank" rel="noopener noreferrer" aria-label="Facebook"
                   class="shrink-0 w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 text-sm shadow-sm hover:bg-brand-600 hover:border-brand-600 hover:text-white hover:shadow-lg hover:shadow-brand-600/30 hover:-translate-y-1 hover:scale-110 transition-all duration-200 ease-out">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="https://www.instagram.com/planet_job" target="_blank" rel="noopener noreferrer" aria-label="Instagram"
                   class="shrink-0 w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 text-sm shadow-sm hover:bg-brand-600 hover:border-brand-600 hover:text-white hover:shadow-lg hover:shadow-brand-600/30 hover:-translate-y-1 hover:scale-110 transition-all duration-200 ease-out">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@planetjob_official" target="_blank" rel="noopener noreferrer" aria-label="TikTok"
                   class="shrink-0 w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 text-sm shadow-sm hover:bg-brand-600 hover:border-brand-600 hover:text-white hover:shadow-lg hover:shadow-brand-600/30 hover:-translate-y-1 hover:scale-110 transition-all duration-200 ease-out">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
                <a href="https://www.youtube.com/@planetjobhr" target="_blank" rel="noopener noreferrer" aria-label="YouTube"
                   class="shrink-0 w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 text-sm shadow-sm hover:bg-brand-600 hover:border-brand-600 hover:text-white hover:shadow-lg hover:shadow-brand-600/30 hover:-translate-y-1 hover:scale-110 transition-all duration-200 ease-out">
                    <i class="fa-brands fa-youtube"></i>
                </a>
                <a href="https://www.linkedin.com/company/planet-job" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"
                   class="shrink-0 w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 text-sm shadow-sm hover:bg-brand-600 hover:border-brand-600 hover:text-white hover:shadow-lg hover:shadow-brand-600/30 hover:-translate-y-1 hover:scale-110 transition-all duration-200 ease-out">
                    <i class="fa-brands fa-linkedin"></i>
                </a>
                <a href="https://wa.me/9849911133" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"
                   class="shrink-0 w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 text-sm shadow-sm hover:bg-brand-600 hover:border-brand-600 hover:text-white hover:shadow-lg hover:shadow-brand-600/30 hover:-translate-y-1 hover:scale-110 transition-all duration-200 ease-out">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a href="mailto:info@planetjob.com.np" aria-label="Email"
                   class="shrink-0 w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 text-sm shadow-sm hover:bg-brand-600 hover:border-brand-600 hover:text-white hover:shadow-lg hover:shadow-brand-600/30 hover:-translate-y-1 hover:scale-110 transition-all duration-200 ease-out">
                    <i class="fa-solid fa-envelope"></i>
                </a>
            </div>
        </div>

        {{-- Nav columns --}}
        <div class="text-center md:text-left">
            <h4 class="inline-block text-white font-extrabold text-sm tracking-widest uppercase pb-2 mb-3 border-b-2 border-brand-600">For Job Seekers</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="{{ route('jobs.index') }}" class="hover:text-white hover:pl-1 transition-all duration-200">Browse Jobs</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-white hover:pl-1 transition-all duration-200">Create Account</a></li>
                <li><a href="{{ route('jobseeker.cv.build') }}" class="hover:text-white hover:pl-1 transition-all duration-200">Build Your CV</a></li>
            </ul>
        </div>
        <div class="text-center md:text-left">
            <h4 class="inline-block text-white font-extrabold text-sm tracking-widest uppercase pb-2 mb-3 border-b-2 border-brand-600">For Employers</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="{{ route('register') }}" class="hover:text-white hover:pl-1 transition-all duration-200">Post a Job</a></li>
            </ul>
        </div>
        <div class="text-center md:text-left">
            <h4 class="inline-block text-white font-extrabold text-sm tracking-widest uppercase pb-2 mb-3 border-b-2 border-brand-600">Company</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="{{ url('/about-us') }}" class="hover:text-white hover:pl-1 transition-all duration-200">About Us</a></li>
                <li><a href="{{ route('privacy-policy') }}" class="hover:text-white hover:pl-1 transition-all duration-200">Privacy Policy</a></li>
                <li><a href="{{ route('terms-and-conditions') }}" class="hover:text-white hover:pl-1 transition-all duration-200">Terms &amp; Conditions</a></li>
                <li><a href="{{ route('contact.create') }}" class="hover:text-white hover:pl-1 transition-all duration-200">Contact</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10 bg-black/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-center text-xs tracking-wide text-gray-500">
            &copy; {{ date('Y') }} Planet Job Private Limited. All rights reserved.
        </div>
    </div>
</footer>
