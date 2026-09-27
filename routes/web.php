<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Jobseeker;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Employer\CompanyController;
use App\Http\Controllers\Employer\SubscriptionController;
use App\Http\Controllers\Employer\JobController as EmployerJobController;
Auth::routes(['verify' => true]);

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', function () {return view('pages.about');});
Route::get('/privacy-policy', function () {return view('companies.privacy');})->name('privacy-policy');
Route::view('/terms-and-conditions', 'companies.terms')->name('terms-and-conditions');

Route::get('auth/redirectToGoogle', [LoginController::class, 'redirectToGoogle'])->name('auth.social.redirect');
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/facebook', [LoginController::class, 'redirectToFacebook'])->name('auth.facebook');

// NOTE: these callback URIs must match the redirect URI configured in config/services.php
// (and in the Google/Facebook developer consoles) for each provider.
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::get('auth/facebook/callback', [LoginController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');

Route::get('jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// Entry point for the "Apply Now" button on the public job page. Guests are
// bounced through login by the 'auth' middleware and returned here after.
Route::get('jobs/{job}/apply', [Jobseeker\JobApplicationController::class, 'create'])
    ->name('jobs.apply')
    ->middleware(['auth', 'role:jobseeker']);

Route::get('companies/{company}', [CompanyController::class, 'show'])->name('companies.show');

Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('blog/{blog}', [BlogController::class, 'show'])->name('blog.show');

Route::get('faq', [PageController::class, 'faq'])->name('faq');
Route::get('contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('pages/{slug}', [PageController::class, 'show'])->name('pages.show'); // about-us, privacy-policy, terms-and-conditions

// SEO
Route::get('sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('robots.txt', [\App\Http\Controllers\SitemapController::class, 'robots'])->name('robots');

// TEMPORARY: verifies MAIL_USERNAME / MAIL_PASSWORD (Zoho SMTP) are configured correctly.
// Only reachable outside production, and safe to delete once mail is confirmed working.
if (! app()->environment('production')) {
    Route::get('test-mail', function () {
        $to = request('to', config('mail.from.address'));

        Mail::raw('This is a test email sent to verify the Zoho SMTP configuration.', function ($message) use ($to) {
            $message->to($to)->subject('Test Email - Zoho SMTP Configuration');
        });

        return "Test email sent to {$to}. Check the inbox (and spam folder) to confirm delivery.";
    })->name('test-mail');
}

/*
|--------------------------------------------------------------------------
| Guest-only auth routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])->middleware('throttle:5,1');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    /*
    |----------------------------------------------------------------------
    | Shared account settings & notifications — any authenticated role
    |----------------------------------------------------------------------
    */
    Route::get('settings', [\App\Http\Controllers\SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [\App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    Route::put('settings/password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.password');

    Route::get('notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');


    /*
    |----------------------------------------------------------------------
    | Admin Panel
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::get('jobs', [Admin\JobController::class, 'index'])->name('jobs.index');
        Route::get('jobs/{job}/edit', [Admin\JobController::class, 'edit'])->name('jobs.edit');
        Route::put('jobs/{job}', [Admin\JobController::class, 'update'])->name('jobs.update');
        Route::post('jobs/{job}/approve', [Admin\JobController::class, 'approve'])->name('jobs.approve');
        Route::post('jobs/{job}/reject', [Admin\JobController::class, 'reject'])->name('jobs.reject');
        Route::delete('jobs/{job}', [Admin\JobController::class, 'destroy'])->name('jobs.destroy');

        Route::get('users', [Admin\UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
        Route::post('users/{user}/toggle-status', [Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');

        Route::get('companies', [Admin\CompanyController::class, 'index'])->name('companies.index');
        Route::post('companies/{company}/verify', [Admin\CompanyController::class, 'verify'])->name('companies.verify');

        Route::get('payments', [Admin\PaymentController::class, 'index'])->name('payments.index');

        Route::get('subscription-plans', [Admin\SubscriptionPlanController::class, 'index'])->name('subscription-plans.index');
        Route::post('subscription-plans', [Admin\SubscriptionPlanController::class, 'store'])->name('subscription-plans.store');
        Route::put('subscription-plans/{subscriptionPlan}', [Admin\SubscriptionPlanController::class, 'update'])->name('subscription-plans.update');
        Route::delete('subscription-plans/{subscriptionPlan}', [Admin\SubscriptionPlanController::class, 'destroy'])->name('subscription-plans.destroy');

        Route::resource('blogs', Admin\BlogController::class)->except(['show']);

        Route::get('faqs', [Admin\FaqController::class, 'index'])->name('faqs.index');
        Route::post('faqs', [Admin\FaqController::class, 'store'])->name('faqs.store');
        Route::put('faqs/{faq}', [Admin\FaqController::class, 'update'])->name('faqs.update');
        Route::delete('faqs/{faq}', [Admin\FaqController::class, 'destroy'])->name('faqs.destroy');

        Route::get('pages', [Admin\PageController::class, 'index'])->name('pages.index');
        Route::get('pages/{page}/edit', [Admin\PageController::class, 'edit'])->name('pages.edit');
        Route::put('pages/{page}', [Admin\PageController::class, 'update'])->name('pages.update');

        Route::get('contact-messages', [Admin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('contact-messages/{contactMessage}', [Admin\ContactMessageController::class, 'show'])->name('contact-messages.show');

        Route::get('settings', [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');
    });

    /*
    |----------------------------------------------------------------------
    | Employer Panel
    |----------------------------------------------------------------------
    */
    Route::prefix('employer')->name('employer.')->middleware('role:employer')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/register', [EmployerController::class, 'create'])->name('register');

        Route::get('/company/create', [App\Http\Controllers\CompanyController::class, 'create'])->name('company.create');
        Route::resource('jobs', EmployerJobController::class)->except(['show']);
        Route::post('jobs/{job}/renew', [EmployerJobController::class, 'renew'])->name('jobs.renew');
        Route::get('jobs/{job}/applications', [Employer\JobApplicationController::class, 'index'])->name('jobs.applications');
        Route::put('applications/{application}/status', [Employer\JobApplicationController::class, 'updateStatus'])->name('applications.update-status');

        Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
        Route::post('subscription/{plan}', [Employer\SubscriptionController::class, 'store'])->name('subscription.store');

        Route::get('company', [CompanyController::class, 'edit'])->name('company.edit');
        Route::put('company', [CompanyController::class, 'update'])->name('company.update');
    });

    /*
    |----------------------------------------------------------------------
    | Jobseeker Panel
    |----------------------------------------------------------------------
    */
    Route::prefix('jobseeker')->name('jobseeker.')->middleware('role:jobseeker')->group(function () {
        Route::get('dashboard', [Jobseeker\DashboardController::class, 'index'])->name('dashboard');

        Route::get('profile', [Jobseeker\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [Jobseeker\ProfileController::class, 'update'])->name('profile.update');

        Route::get('cv/build', [Jobseeker\CvBuilderController::class, 'edit'])->name('cv.build');
        Route::post('cv/preview', [Jobseeker\CvBuilderController::class, 'preview'])->name('cv.preview');
        Route::post('cv/download', [Jobseeker\CvBuilderController::class, 'downloadPdf'])->name('cv.download');
        Route::get('cv/pdf', [Jobseeker\CvBuilderController::class, 'downloadExisting'])->name('cv.pdf');

        Route::get('applications', [Jobseeker\JobApplicationController::class, 'index'])->name('applications.index');
        Route::post('jobs/{job}/apply', [Jobseeker\JobApplicationController::class, 'store'])->name('jobs.apply');
        Route::delete('applications/{application}', [Jobseeker\JobApplicationController::class, 'withdraw'])->name('applications.withdraw');

        Route::get('saved-jobs', [Jobseeker\SavedJobController::class, 'index'])->name('saved-jobs.index');
        Route::post('jobs/{job}/save', [Jobseeker\SavedJobController::class, 'store'])->name('jobs.save');
        Route::delete('jobs/{job}/save', [Jobseeker\SavedJobController::class, 'destroy'])->name('jobs.unsave');

        Route::get('job-alerts', [Jobseeker\JobAlertController::class, 'index'])->name('job-alerts.index');
        Route::post('job-alerts', [Jobseeker\JobAlertController::class, 'store'])->name('job-alerts.store');
        Route::delete('job-alerts/{jobAlert}', [Jobseeker\JobAlertController::class, 'destroy'])->name('job-alerts.destroy');
    });
});
