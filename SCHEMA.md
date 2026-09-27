# Planet Job Portal — Database Schema

**Planet Job Private Limited** | Tagline: *Talent with Opportunity*
Laravel 12 · PHP 8.3 · MySQL

## Overview

21 migrations, 19 Eloquent models. Single `users` table with a `role` enum
(`admin`, `employer`, `jobseeker`) drives role-based access control — each
role gets its own dashboard/panel via middleware + route groups, not separate
tables.

## Tables & Relationships

### Identity
- **users** — core auth table + `role`, `status`, `avatar`
- **companies** — 1:1 with `users` (employer's company profile)
- **jobseeker_profiles** — 1:1 with `users` (CV, bio, salary expectation, etc.)

### Job Catalog
- **categories** — job categories (IT, Marketing, Finance, ...)
- **job_types** — Full-time / Part-time / Contract / Internship / Remote
- **skills** — master skill list
- **jobs** — the core listing. Belongs to `company`, `category`, `job_type`;
  posted by a `user` (posted_by). Soft-deletes enabled.
- **job_skill** — pivot (jobs ↔ skills, many-to-many)

### Applications & Engagement
- **job_applications** — a jobseeker applies to a job (unique per job+user).
  Status pipeline: pending → reviewed → shortlisted → interview → rejected/hired
- **saved_jobs** — bookmarks (unique per user+job)
- **job_alerts** — saved search criteria + frequency (instant/daily/weekly)
  for email alert jobs (via scheduled command + queued mail)

### Monetization
- **subscription_plans** — pricing tiers (job post limit, featured job limit,
  CV database access, etc.) — role-scoped (employer/jobseeker)
- **subscriptions** — a user's active/past plan instance, tracks usage
  (jobs_posted, featured_jobs_used) against the plan limits
- **payments** — transaction log (eSewa/Khalti/Stripe/bank), linked to a
  subscription

### Content & CMS
- **blog_categories**, **blogs** — blog module with draft/published workflow
- **faqs** — categorized FAQ entries with manual ordering
- **pages** — flat CMS pages for About / Privacy Policy / Terms & Conditions
  (slug-driven, so no hardcoded routes needed per page)
- **contact_messages** — Contact Us form submissions
- **company_reviews** — optional employer rating/review from jobseekers
- **notifications** — Laravel's built-in notifications table (used for
  application status updates, job alert emails, etc.)

## Key Design Decisions

1. **Single users table + role enum** rather than separate admin/employer/
   jobseeker tables — simpler auth, one `Auth::user()`, RBAC via middleware
   (`role:admin`, `role:employer`, `role:jobseeker`) and Laravel Policies.
2. **Slugs everywhere** (jobs, companies, categories, blogs, pages) for
   SEO-friendly URLs and route-model binding via `getRouteKeyName()`.
3. **Soft deletes on jobs** so closed/removed listings don't break existing
   application/analytics history.
4. **Subscriptions decoupled from Payments** — a subscription can exist
   (e.g. free plan) without a payment row; paid plans link a payment to the
   subscription that triggered it.
5. **job_applications has a unique(job_id, user_id)** constraint — prevents
   duplicate applications at the DB level, not just in application logic.

## Seeders & Factories (done)

Run `php artisan migrate --seed` (or `php artisan db:seed` after migrating)
to populate:

- **3 fixed demo accounts** (same password: `password`)
  - `admin@planetjob.com` — Admin
  - `employer@planetjob.com` — Employer (owns "Planet Job Private Limited" company)
  - `jobseeker@planetjob.com` — Jobseeker
- 15 job categories, 6 job types, 20 skills
- 5 subscription plans (Free → Enterprise)
- 20 companies (incl. the branded one above), 60 jobs with attached skills
- 40 jobseekers with profiles, applications, saved jobs, job alerts
- 6 blog categories + 15 blog posts, 8 FAQs, 3 CMS pages (About/Privacy/Terms)

Seeder order matters — `DatabaseSeeder` calls them in the correct dependency
sequence (lookups → companies → jobs → jobseekers → content).

## Auth & Role-Based Access Control (done)

- **`role` middleware** (`app/Http/Middleware/EnsureUserHasRole.php`) — guards
  route groups by role: `Route::middleware('role:employer')`. Also blocks
  inactive/banned accounts.
- **`RouteServiceProvider::homeFor($user)`** — single source of truth for
  where each role lands after login (`/admin/dashboard`,
  `/employer/dashboard`, `/jobseeker/dashboard`). Used by both the login
  controller and the guest-redirect middleware, so it never drifts.
- **Policies** (`app/Policies/`) for `Job`, `Company`, `JobApplication`,
  `Blog`, `SubscriptionPlan`, `JobseekerProfile` — ownership-based checks
  (e.g. only the employer who owns a job can see its applicants). Registered
  in `AppServiceProvider`, which also adds a `Gate::before` so **admin
  bypasses every policy check** automatically.
- **`RegisterRequest`** — one registration form handles both roles;
  `company_name` becomes required only when `role=employer`
  (`required_if:role,employer`). Admin accounts are never self-registered.
- **`RegisteredUserController`** — creates the `User` plus its matching
  `Company` or `JobseekerProfile` row in a single DB transaction, so no
  account is ever left without a profile.
- **`routes/web.php`** — shows the three panels as separate
  `Route::prefix()->middleware('role:...')` groups, matching the "separate
  Admin/Employer/Jobseeker panels" requirement. Controller methods are
  stubbed as comments for the next step.
- `bootstrap/app.php` registers the `role` and `guest` middleware aliases
  (Laravel 12 structure — no `Kernel.php`).

Email verification uses Laravel's built-in `MustVerifyEmail` (already on the
`User` model) — add the standard `verified` middleware to any route that
should require it, e.g. `Route::middleware(['auth', 'verified'])`.

## Controllers, Routes, Services & Views (done)

- **Services** — `JobSearchService` (shared filter/sort logic for web + API),
  `SubscriptionService` (plan limits, activation), `FileUploadService`
  (uuid-named uploads, old-file cleanup), `NotificationService` (wraps the
  two application notifications).
- **Notifications** — `NewJobApplication` (to employer), `ApplicationStatusUpdated`
  (to applicant), `JobAlertDigest` (mail only) — all mail + database channel
  where relevant, so they also power an in-app notification bell if you add one.
- **Public controllers** — Home, Job (search/detail), Company, Blog, Page, FAQ, Contact.
- **Employer controllers** — Dashboard, Job (full CRUD, subscription-limit
  checked before allowing a new post, submits as `pending` for admin review),
  JobApplication (view + status update), Subscription (plan selection —
  wired for a payment gateway callback in production), Company profile.
- **Jobseeker controllers** — Dashboard, Profile (resume/avatar upload),
  JobApplication (apply/withdraw/list), SavedJob, JobAlert.
- **Admin controllers** — Dashboard (stats + monthly jobs chart), Job
  (approve/reject/delete), User (search/filter/ban), Company (verify),
  SubscriptionPlan (CRUD), Blog (full CRUD), Faq, Page, ContactMessage.
- **API (`routes/api.php`, `/api/v1`)** — Sanctum token auth (`POST /login`),
  public `GET /jobs`, `GET /jobs/{job}`, authenticated `GET /applications`,
  `POST /jobs/{job}/apply` — via `JobResource` / `JobApplicationResource`.
- **Blade views** — Tailwind-based (`layouts/app.blade.php` + a shared
  `layouts/panel.blade.php` sidebar shell reused by all three dashboards):
  home (hero/search/categories/featured & latest jobs), job search with
  sidebar filters, job detail with apply/save, login/register, all three
  dashboards, employer job CRUD forms + applicant review, jobseeker
  profile/applications/saved-jobs/alerts, admin job moderation + user
  management + analytics, company profile, blog, FAQ, contact, static pages.

### Still stubbed / recommended before production

- Admin CRUD *views* for Companies list detail, Subscription Plans, FAQs,
  Pages, Contact Messages, and Blog edit forms follow the same pattern as
  the ones built above — same partial/table structure, not yet written out.
- Payment gateway integration (eSewa/Khalti/Stripe) — `SubscriptionController::store`
  currently activates a plan immediately for demo purposes; swap in a
  redirect-to-gateway + webhook-confirms-payment flow.
- `JobAlertDigest` scheduled command (a `daily`/`weekly` Artisan command that
  queries `JobAlert`s and dispatches the notification) — the Notification
  class is ready, the scheduler entry is not wired up yet.
- Form validation error styling, image previews, and JS interactivity
  (mobile nav toggle, skill-picker search) are left minimal/functional
  rather than polished.

## Final Pass — Remaining Modules (done)

- **Job renew/expiry** — `jobs:expire` scheduled command (daily) auto-closes
  jobs past deadline; `Employer\JobController::renew()` lets an employer
  extend an expired/closed job by 30 days (re-enters `pending` for admin
  review, consumes another job-post credit).
- **Job alert emails** — `jobs:send-alerts {instant|daily|weekly}` command
  matches each `JobAlert` against jobs posted since its `last_sent_at` and
  sends a `JobAlertDigest` mail. Registered in `routes/console.php`
  (instant every 15 min, daily at 08:00, weekly Monday 08:00) — requires
  a real cron entry running `schedule:run` in production.
- **Remaining admin CRUD views** — Companies (verify), Subscription Plans
  (inline add/edit), FAQs (add/delete), Pages (edit CMS content), Contact
  Messages (inbox + detail), Blog (create/edit forms) — all now built,
  closing out every item from the previous "still stubbed" list except
  payment gateway wiring.
- **Shared account settings** — `SettingsController` (name/email/phone +
  password change with `current_password` re-auth) at `/settings`, usable
  by any role.
- **Notifications UI** — `NotificationController` + `/notifications` page
  reads Laravel's built-in `DatabaseNotification`s (the same ones the
  `NewJobApplication`/`ApplicationStatusUpdated` notifications write to),
  plus an unread-count bell in the navbar.
- **Security hardening** — route-level `throttle:5,1` on login/register,
  plus a per-account+IP `RateLimiter` lockout in
  `AuthenticatedSessionController` (60s cooldown after 5 failed attempts,
  independent of the route throttle).
- **Error pages** — custom 403/404/419/429/500 views matching the site's
  Tailwind styling instead of Laravel's default whitescreen.
- **SEO** — `SitemapController` generates `/sitemap.xml` dynamically from
  active jobs, companies, published blog posts, and CMS pages;
  `/robots.txt` disallows the three private panels. All public entities
  already used slug-based routes (`getRouteKeyName()`), so URLs were
  SEO-friendly from the schema step onward.
- **Performance** — confirmed eager-loading on every list query and
  `paginate()` on every collection endpoint (web + API); see README
  "Performance notes" for specifics.
- **`README.md`** — setup steps, demo accounts, cron/queue requirements,
  full folder tree, and a security/performance summary.
- **`.env.example`** — every config key the app touches, including
  placeholders for eSewa/Khalti/Stripe keys for when payment integration
  is wired in.

## Genuinely Still Open (by design, needs a business decision)

- **Payment gateway integration** — `SubscriptionController::store`
  activates a plan immediately for demo/dev convenience. Swap in a
  redirect-to-gateway + webhook-confirms-payment flow before accepting
  real money; the `Payment` model and `SubscriptionService` are already
  shaped for it.
- **Asset pipeline** — Tailwind currently loads via CDN
  (`layouts/app.blade.php`) for zero-build-step convenience. For
  production, switch to a Vite build (`npm install && npm run build`) so
  Tailwind purges unused classes and views ship a proper compiled
  stylesheet.

## Full Project Skeleton (done)

The download is now a complete, installable Laravel 12 project — not just
the `app/` code. Added in this pass: `composer.json`, `artisan`,
`bootstrap/providers.php`, all of `config/*.php` (app, auth, sanctum,
database, filesystems, cache, session, queue, mail, logging, services),
`public/index.php` + `.htaccess`, the full `storage/` directory tree
(`.gitignore`'d placeholders so the folders exist but stay empty),
`tests/` (`TestCase` + sample `JobListingTest` / `RoleAccessTest` covering
public job visibility and the three-panel RBAC boundary), `phpunit.xml`,
`package.json` + `vite.config.js` + `resources/css/app.css` +
`resources/js/app.js` (Tailwind v4 via Vite, replacing the earlier CDN
`<script>` tag in `layouts/app.blade.php`), and a project-root `.gitignore`.

**`vendor/` is intentionally not included** — it's Composer's downloaded
package cache (the Laravel framework itself, Sanctum, etc.), regenerated
by `composer install` in under a minute from `composer.json`. Shipping it
by hand would mean committing someone else's compiled code instead of
letting Composer manage versions/lockfile properly — run `composer install
&& npm install` per the README to produce it locally.

## Next Steps

- [x] Seeders & Factories for realistic demo data
- [x] Auth + role-based middleware & policies
- [x] Controllers, Services, Routes (web + API)
- [x] Blade + Tailwind views — Hero, Job Search, all three Dashboards, Job CRUD
- [x] Job renew/expiry + job alert scheduled emails
- [x] Remaining admin CRUD views, shared settings, notifications UI
- [x] Security hardening, custom error pages, SEO sitemap/robots
- [x] Full installable project skeleton (composer.json, config/, public/, storage/, tests/, Vite)
- [ ] Payment gateway integration (business decision: eSewa/Khalti/Stripe)
- [ ] `composer install && npm install` locally to generate `vendor/` and `node_modules/`
