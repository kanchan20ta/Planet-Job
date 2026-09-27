@extends('layouts.app')
@section('title', 'Terms & Conditions - Planet Job Portal')

@section('content')

{{-- ============ PAGE HEADER ============ --}}
<section class="relative bg-white border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 text-center">
        <span class="inline-flex items-center gap-2 text-sm font-semibold text-brand-700 bg-brand-50 rounded-full px-4 py-1.5">
            <i class="fa-solid fa-file-contract text-xs"></i>
            Last Updated: {{ now()->format('F j, Y') }}
        </span>
        <h1 class="mt-5 text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900">
            Terms &amp; Conditions
        </h1>
        <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">
            Please read these terms carefully before using Planet Job's website and services.
        </p>
    </div>
</section>

{{-- ============ TERMS CONTENT ============ --}}
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
    <div class="prose prose-gray max-w-none space-y-10">

        <div>
            <p class="text-gray-600 leading-relaxed">
                These Terms &amp; Conditions ("Terms") govern your access to and use of the Planet Job website
                and services (the "Platform"), operated by Planet Job Pvt. Ltd. ("Planet Job", "we", "us", or
                "our"). By creating an account, browsing job listings, or otherwise using the Platform, you
                agree to be bound by these Terms. If you do not agree, please do not use the Platform.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                1. Eligibility &amp; Account Registration
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                You must be at least 18 years old or of legal working age in your jurisdiction to register on
                the Platform. When creating an account, you agree to provide accurate, current, and complete
                information and to keep it updated. You are responsible for maintaining the confidentiality of
                your login credentials and for all activity that occurs under your account.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                2. Job Seeker Responsibilities
            </h2>
            <ul class="mt-3 space-y-2 text-gray-600 leading-relaxed list-disc list-inside">
                <li>All information in your profile, resume, and job applications must be truthful and accurate.</li>
                <li>You are solely responsible for your interactions and any agreements made with employers found through the Platform.</li>
                <li>Planet Job does not guarantee that any job application will result in an interview, offer, or employment.</li>
                <li>You may not use the Platform to misrepresent your identity or qualifications.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                3. Employer Responsibilities
            </h2>
            <ul class="mt-3 space-y-2 text-gray-600 leading-relaxed list-disc list-inside">
                <li>Job postings must accurately describe the position, compensation, and requirements, and must comply with applicable labor laws.</li>
                <li>Employers may not post discriminatory, fraudulent, misleading, or unlawful job listings.</li>
                <li>Employers are solely responsible for their hiring decisions and compliance with employment regulations.</li>
                <li>Access to certain features (e.g. posting jobs, viewing applications) may require an active subscription plan.</li>
                <li>Planet Job reserves the right to review, edit, reject, or remove any job posting that violates these Terms.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                4. Subscriptions &amp; Payments
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                Certain employer features are offered through paid subscription plans. By purchasing a
                subscription, you agree to pay all applicable fees as displayed at the time of purchase.
                Fees are non-refundable except where required by law or expressly stated otherwise. Planet Job
                reserves the right to change subscription pricing and features with reasonable prior notice.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                5. Acceptable Use
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">You agree not to:</p>
            <ul class="mt-3 space-y-2 text-gray-600 leading-relaxed list-disc list-inside">
                <li>Use the Platform for any unlawful purpose or in violation of these Terms.</li>
                <li>Upload viruses, malicious code, or attempt to interfere with the Platform's security or functionality.</li>
                <li>Scrape, harvest, or collect data from the Platform without our written permission.</li>
                <li>Impersonate any person or entity, or misrepresent your affiliation with any person or entity.</li>
                <li>Post spam, fraudulent listings, or content that infringes on the rights of others.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                6. Intellectual Property
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                All content on the Platform, including the Planet Job name, logo, design, and software, is the
                property of Planet Job Pvt. Ltd. or its licensors and is protected by applicable intellectual
                property laws. You may not copy, modify, distribute, or create derivative works from any part
                of the Platform without our prior written consent.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                7. Third-Party Links &amp; Content
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                The Platform may contain links to third-party websites or services not owned or controlled by
                Planet Job. We are not responsible for the content, privacy policies, or practices of any
                third-party sites. Your interactions with such third parties are solely between you and them.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                8. Account Suspension &amp; Termination
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                We reserve the right to suspend or terminate your account, without prior notice, if we
                reasonably believe you have violated these Terms, engaged in fraudulent activity, or misused
                the Platform. You may also close your account at any time by contacting us.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                9. Disclaimer &amp; Limitation of Liability
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                The Platform is provided on an "as is" and "as available" basis without warranties of any
                kind. Planet Job does not guarantee the accuracy of job listings or candidate information and
                is not liable for any hiring decisions, employment outcomes, or disputes between job seekers
                and employers. To the fullest extent permitted by law, Planet Job shall not be liable for any
                indirect, incidental, or consequential damages arising from your use of the Platform.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                10. Governing Law
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                These Terms shall be governed by and construed in accordance with the laws of Nepal, without
                regard to its conflict of law provisions. Any disputes arising under these Terms shall be
                subject to the exclusive jurisdiction of the courts of Kathmandu, Nepal.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                11. Changes to These Terms
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                We may update these Terms from time to time to reflect changes in our services or legal
                requirements. Continued use of the Platform after changes take effect constitutes acceptance
                of the revised Terms. We will update the "Last Updated" date above whenever changes are made.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                12. Contact Us
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                If you have any questions about these Terms &amp; Conditions, please reach out to us through
                our <a href="{{ route('contact.create') }}" class="text-brand-700 font-medium hover:underline">contact page</a>.
            </p>
        </div>

    </div>
</section>

{{-- ============ CTA ============ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 sm:pb-20">
    <div class="flex flex-wrap items-center justify-between gap-6 bg-brand-900 text-white rounded-2xl px-8 sm:px-12 py-10">
        <div>
            <h3 class="text-xl sm:text-2xl font-bold">Have more questions?</h3>
            <p class="text-brand-100/80 mt-1.5">Our team is happy to walk you through the details.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('contact.create') }}"
               class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-400 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                Contact Us
            </a>
        </div>
    </div>
</section>

@endsection
