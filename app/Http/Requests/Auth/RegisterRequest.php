<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // anyone (guest) can register
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            // Only employer/jobseeker are self-selectable at signup — admin
            // accounts are never created through the public registration form.
            'role' => ['required', Rule::in(['employer', 'jobseeker'])],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Required only when registering as an employer, so the
            // Company profile can be created in the same step.
            'company_name' => ['required_if:role,employer', 'nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required_if' => 'Company name is required for employer accounts.',
        ];
    }
}
