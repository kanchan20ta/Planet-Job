@extends('layouts.app')
@section('title', 'Privacy Policy - Planet Job Portal')

@section('content')

{{-- ============ PAGE HEADER ============ --}}
<section class="relative bg-white border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 text-center">
        <span class="inline-flex items-center gap-2 text-sm font-semibold text-brand-700 bg-brand-50 rounded-full px-4 py-1.5">
            <i class="fa-solid fa-shield-halved text-xs"></i>
            Last Updated: {{ now()->format('F j, Y') }}
        </span>
        <h1 class="mt-5 text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900">
            Privacy Policy
        </h1>
        <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">
            Your trust matters to us. Here's how Planet Job collects, uses, and protects your information.
        </p>
    </div>
</section>

{{-- ============ POLICY CONTENT ============ --}}
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
    <div class="prose prose-gray max-w-none space-y-10">

        <div>
            <p class="text-gray-600 leading-relaxed">
                Planet Job Pvt. Ltd. ("Planet Job", "we", "us", or "our") operates this job portal to connect
                job seekers with employers across Nepal. This Privacy Policy explains what information we
                collect, how we use it, and the choices you have regarding your data when you use our website
                and services (collectively, the "Platform").
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                1. Information We Collect
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                We collect information you provide directly to us and information gathered automatically as
                you use the Platform, including:
            </p>
            <ul class="mt-3 space-y-2 text-gray-600 leading-relaxed list-disc list-inside">
                <li><span class="font-medium text-gray-800">Account information</span> — name, email address, phone number, and password when you register as a job seeker or employer.</li>
                <li><span class="font-medium text-gray-800">Profile &amp; application data</span> — resumes/CVs, work history, education, skills, and cover letters submitted with job applications.</li>
                <li><span class="font-medium text-gray-800">Company information</span> — business name, registration details, and job listings submitted by employers.</li>
                <li><span class="font-medium text-gray-800">Communications</span> — messages sent through our contact forms or between job seekers and employers on the Platform.</li>
                <li><span class="font-medium text-gray-800">Usage data</span> — IP address, browser type, device information, and pages visited, collected automatically via cookies and similar technologies.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                2. How We Use Your Information
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">We use the information we collect to:</p>
            <ul class="mt-3 space-y-2 text-gray-600 leading-relaxed list-disc list-inside">
                <li>Create and manage your account and job seeker or employer profile.</li>
                <li>Match job seekers with relevant job postings and notify you of new opportunities.</li>
                <li>Enable employers to review applications and communicate with candidates.</li>
                <li>Process subscriptions and payments for employer plans.</li>
                <li>Send administrative updates, service notifications, and respond to inquiries.</li>
                <li>Maintain the security of the Platform and prevent fraud or misuse.</li>
                <li>Improve our services through analytics and aggregated usage insights.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                3. How We Share Your Information
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                We do not sell your personal information. We may share it in the following circumstances:
            </p>
            <ul class="mt-3 space-y-2 text-gray-600 leading-relaxed list-disc list-inside">
                <li><span class="font-medium text-gray-800">With employers</span> — when you apply to a job, your profile and application materials are shared with that employer.</li>
                <li><span class="font-medium text-gray-800">Service providers</span> — third parties who help us operate the Platform, such as hosting, email delivery, and payment processing providers.</li>
                <li><span class="font-medium text-gray-800">Legal requirements</span> — when required by law, regulation, or valid legal process.</li>
                <li><span class="font-medium text-gray-800">Business transfers</span> — in connection with a merger, acquisition, or sale of assets, subject to confidentiality safeguards.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                4. Cookies &amp; Tracking Technologies
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                We use cookies and similar technologies to keep you signed in, remember your preferences, and
                understand how the Platform is used. You can control cookies through your browser settings;
                disabling them may limit some features of the site.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                5. Data Security
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                We implement reasonable administrative, technical, and physical safeguards designed to protect
                your information from unauthorized access, alteration, or disclosure. However, no method of
                transmission or storage is completely secure, and we cannot guarantee absolute security.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                6. Data Retention
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                We retain your personal information for as long as your account remains active or as needed to
                provide our services, comply with legal obligations, resolve disputes, and enforce our
                agreements. You may request deletion of your account and associated data at any time.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                7. Your Rights &amp; Choices
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">You may, subject to applicable law:</p>
            <ul class="mt-3 space-y-2 text-gray-600 leading-relaxed list-disc list-inside">
                <li>Access, update, or correct your profile information at any time from your account settings.</li>
                <li>Request a copy of the personal data we hold about you.</li>
                <li>Request deletion of your account and personal data.</li>
                <li>Opt out of non-essential email notifications and job alerts.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                8. Children's Privacy
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                The Platform is intended for individuals who are at least 18 years old or of legal working age
                in their jurisdiction. We do not knowingly collect personal information from children.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                9. Changes to This Policy
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                We may update this Privacy Policy from time to time to reflect changes in our practices or for
                legal, operational, or regulatory reasons. We will post the updated policy on this page with a
                revised "Last Updated" date.
            </p>
        </div>

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full inline-block"></span>
                10. Contact Us
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                If you have questions or concerns about this Privacy Policy or how your information is
                handled, please reach out to us through our
                <a href="{{ route('contact.create') }}" class="text-brand-700 font-medium hover:underline">contact page</a>.
            </p>
        </div>

    </div>
</section>

{{-- ============ CTA ============ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 sm:pb-20">
    <div class="flex flex-wrap items-center justify-between gap-6 bg-brand-900 text-white rounded-2xl px-8 sm:px-12 py-10">
        <div>
            <h3 class="text-xl sm:text-2xl font-bold">Have more questions?</h3>
            <p class="text-brand-100/80 mt-1.5">Our team is happy to help clarify anything about your data.</p>
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
