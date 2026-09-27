<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'company' => [
                'name' => $this->company->name,
                'slug' => $this->company->slug,
                'logo' => $this->company->logo ? asset('storage/' . $this->company->logo) : null,
            ],
            'category' => $this->category->name,
            'job_type' => $this->jobType->name,
            'location' => $this->location,
            'city' => $this->city,
            'is_remote' => $this->is_remote,
            'salary_min' => $this->salary_min,
            'salary_max' => $this->salary_max,
            'salary_type' => $this->salary_type,
            'experience_level' => $this->experience_level,
            'deadline' => $this->deadline?->toDateString(),
            'is_featured' => $this->is_featured,
            'skills' => $this->whenLoaded('skills', fn () => $this->skills->pluck('name')),
            'description' => $this->when($request->routeIs('*.show'), $this->description),
            'posted_at' => $this->created_at->diffForHumans(),
        ];
    }
}
