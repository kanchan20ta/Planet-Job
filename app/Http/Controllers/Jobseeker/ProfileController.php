<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateJobseekerProfileRequest;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(protected FileUploadService $files)
    {
    }

    public function edit()
    {
        return view('jobseeker.profile.edit', ['profile' => Auth::user()->jobseekerProfile]);
    }

    public function update(UpdateJobseekerProfileRequest $request)
    {
        $profile = Auth::user()->jobseekerProfile;
        $data = $request->safe()->except(['resume', 'avatar']);
        $data['is_available'] = $request->boolean('is_available');
        $data['profile_public'] = $request->boolean('profile_public');

        if ($request->hasFile('resume')) {
            $data['resume_path'] = $this->files->upload($request->file('resume'), 'resumes', $profile->resume_path);
        }

        $profile->update($data);

        if ($request->hasFile('avatar')) {
            $avatarPath = $this->files->upload($request->file('avatar'), 'avatars', Auth::user()->avatar);
            Auth::user()->update(['avatar' => $avatarPath]);
        }

        return back()->with('success', 'Profile updated.');
    }
}
