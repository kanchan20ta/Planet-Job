<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class JobSearchService
{
    /**
     * Builds the filtered, paginated job listing used by the public search
     * page. Kept out of the controller so the same filter logic can be
     * reused by an API endpoint or an admin "all jobs" screen.
     */
    public function search(Request $request): LengthAwarePaginator
    {
        $query = Job::query()
            ->with(['company', 'category', 'jobType'])
            ->active();

        $query->when($request->filled('keyword'), function (Builder $q) use ($request) {
            $keyword = $request->string('keyword');
            $q->where(function (Builder $q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        });

        $query->when($request->filled('category'), fn (Builder $q) => $q->where('category_id', $request->integer('category')));
        $query->when($request->filled('job_type'), fn (Builder $q) => $q->where('job_type_id', $request->integer('job_type')));
        $query->when($request->filled('city'), fn (Builder $q) => $q->where('city', $request->string('city')));
        $query->when($request->filled('experience_level'), fn (Builder $q) => $q->where('experience_level', $request->string('experience_level')));
        $query->when($request->boolean('remote_only'), fn (Builder $q) => $q->where('is_remote', true));

        $query->when($request->filled('salary_min'), fn (Builder $q) => $q->where('salary_max', '>=', $request->integer('salary_min')));

        // Whitelist the sort value and use a plain string (not Stringable) so
        // that match()'s strict comparison actually works. $request->string()
        // returns an Illuminate\Support\Stringable object, which is never
        // === to a plain string literal, so every case was previously
        // falling through to 'default' regardless of the selected option.
        $allowedSorts = ['latest', 'featured', 'salary_high', 'salary_low'];
        $sort = $request->query('sort', 'latest');
        $sort = in_array($sort, $allowedSorts, true) ? $sort : 'latest';

        match ($sort) {
            'salary_high' => $query->orderByDesc('salary_max'),
            'salary_low' => $query->orderBy('salary_min'),
            'featured' => $query->orderByDesc('is_featured')->orderByDesc('created_at'),
            default => $query->orderByDesc('created_at'),
        };

        return $query->paginate(12)->withQueryString();
    }
}
