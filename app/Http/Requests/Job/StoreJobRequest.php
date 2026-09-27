<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Job::class);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'job_type_id' => ['required', 'exists:job_types,id'],
            'description' => ['required', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'vacancy' => ['required', 'integer', 'min:1'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'gte:salary_min'],
            'salary_type' => ['required', 'in:hourly,monthly,yearly,negotiable'],
            'experience_level' => ['nullable', 'in:entry,mid,senior,lead,executive'],
            'education_level' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'is_remote' => ['boolean'],
            'deadline' => ['required', 'date', 'after:today'],
            'is_featured' => ['boolean'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['exists:skills,id'],
        ];
    }
}
