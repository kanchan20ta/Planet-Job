<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CvBuilderController extends Controller
{
    /**
     * Show the CV builder form.
     */
    public function edit(Request $request)
    {
        $profile = $request->user()->jobseekerProfile;

        return view('jobseeker.cv.build', compact('profile'));
    }

    /**
     * Render an on-screen preview of the CV using the submitted form data.
     * Also persists the data, so a preview never loses the user's work.
     */
    public function preview(Request $request)
    {
        $cv = $this->persist($request);

        return view('jobseeker.cv.preview', compact('cv'));
    }

    /**
     * Generate the CV as a PDF and stream it straight to the user's device.
     */
    public function downloadPdf(Request $request)
    {
        $cv = $this->persist($request);

        $fileName = Str::slug($cv['full_name'] ?: 'my-cv') . '-cv.pdf';

        $pdf = Pdf::loadView('jobseeker.cv.pdf', compact('cv'))
            ->setPaper('a4');

        return $pdf->download($fileName);
    }

    /**
     * Download a PDF built from whatever CV data is already saved on the
     * profile — used by the "Download PDF" link on the preview page, which
     * is a plain GET link rather than a resubmission of the whole form.
     */
    public function downloadExisting(Request $request)
    {
        $cv = $request->user()->jobseekerProfile->cv_data ?? [];

        $fileName = Str::slug($cv['full_name'] ?? 'my-cv') . '-cv.pdf';

        $pdf = Pdf::loadView('jobseeker.cv.pdf', compact('cv'))
            ->setPaper('a4');

        return $pdf->download($fileName);
    }

    /**
     * Validate the submitted CV form and save it to the jobseeker's profile.
     * Shared by both the preview and PDF-download actions so neither one
     * can silently diverge from the other.
     */
    protected function persist(Request $request): array
    {
        $validated = $request->validate([
            'full_name' => 'nullable|string|max:255',
            'professional_title' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'professional_summary' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',

            'experience' => 'nullable|array',
            'experience.*.title' => 'nullable|string|max:255',
            'experience.*.company' => 'nullable|string|max:255',
            'experience.*.location' => 'nullable|string|max:255',
            'experience.*.start_date' => 'nullable|date',
            'experience.*.end_date' => 'nullable|date',
            'experience.*.is_current' => 'nullable|boolean',
            'experience.*.description' => 'nullable|string',

            'education' => 'nullable|array',
            'education.*.degree' => 'nullable|string|max:255',
            'education.*.institution' => 'nullable|string|max:255',
            'education.*.location' => 'nullable|string|max:255',
            'education.*.start_year' => 'nullable|integer|min:1950|max:2100',
            'education.*.end_year' => 'nullable|integer|min:1950|max:2100',

            'skills' => 'nullable|array',
            'skills.*.name' => 'nullable|string|max:255',
            'skills.*.level' => 'nullable|in:beginner,intermediate,advanced,expert',

            'certifications' => 'nullable|array',
            'certifications.*.name' => 'nullable|string|max:255',
            'certifications.*.issuer' => 'nullable|string|max:255',
            'certifications.*.issue_date' => 'nullable|date',
            'certifications.*.url' => 'nullable|url|max:255',

            'languages' => 'nullable|array',
            'languages.*.name' => 'nullable|string|max:255',
            'languages.*.level' => 'nullable|in:basic,conversational,fluent,native',

            'projects' => 'nullable|array',
            'projects.*.name' => 'nullable|string|max:255',
            'projects.*.role' => 'nullable|string|max:255',
            'projects.*.url' => 'nullable|url|max:255',
            'projects.*.tech' => 'nullable|string|max:255',
            'projects.*.description' => 'nullable|string',
        ]);

        $profile = $request->user()->jobseekerProfile;

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('jobseeker-photos', 'public');
        } else {
            // Keep whatever photo was already on file — the form doesn't
            // require a re-upload on every save.
            $validated['photo'] = $profile->cv_data['photo'] ?? null;
        }

        // TODO: this assumes jobseeker_profiles has a `cv_data` JSON column.
        // Swap this out for however your schema actually stores CV sections
        // (e.g. separate cv_experiences / cv_education tables) if it doesn't.
        $profile->update([
            'cv_data' => $validated,
        ]);

        return $validated;
    }
}
