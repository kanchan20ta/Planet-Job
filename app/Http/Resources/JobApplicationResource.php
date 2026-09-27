<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'job' => [
                'id' => $this->job->id,
                'title' => $this->job->title,
                'company' => $this->job->company->name,
            ],
            'status' => $this->status,
            'applied_at' => $this->applied_at->toDateTimeString(),
        ];
    }
}
