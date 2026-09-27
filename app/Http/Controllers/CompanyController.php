<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
    public function show(Company $company)
    {
        $company->load(['activeJobs.category', 'activeJobs.jobType', 'reviews' => fn ($q) => $q->where('is_approved', true)->with('user')]);

        return view('companies.show', compact('company'));
    }
}
