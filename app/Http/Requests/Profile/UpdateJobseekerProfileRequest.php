<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobseekerProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isJobseeker();
    }

    public function rules(): array
    {
        return [
            'headline' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:3000'],
            'experience_level' => ['nullable', 'in:entry,mid,senior,lead,executive'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:60'],
            'current_salary' => ['nullable', 'numeric', 'min:0'],
            'expected_salary' => ['nullable', 'numeric', 'min:0'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'is_available' => ['boolean'],
            'profile_public' => ['boolean'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
