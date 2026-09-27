<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function __construct(protected FileUploadService $files)
    {
    }

    public function show(Company $company)
    {
        return view('employer.company.show', ['company' => $company]);
    }

    public function edit()
    {
        return view('employer.company.edit', ['company' => Auth::user()->company]);
    }

    public function update(UpdateCompanyRequest $request)
    {
        $company = Auth::user()->company;
        $data = $request->safe()->except(['logo', 'cover_image']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->files->upload($request->file('logo'), 'companies/logos', $company->logo);
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->files->upload($request->file('cover_image'), 'companies/covers', $company->cover_image);
        }

        $company->update($data);

        return back()->with('success', 'Company profile updated.');
    }
}
