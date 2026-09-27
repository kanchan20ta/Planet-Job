<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        return view('admin.companies.index', [
            'companies' => Company::withCount('jobs')->latest()->paginate(20),
        ]);
    }

    public function verify(Company $company)
    {
        $this->authorize('verify', $company);

        $company->update(['is_verified' => true]);

        return back()->with('success', 'Company verified.');
    }
}
