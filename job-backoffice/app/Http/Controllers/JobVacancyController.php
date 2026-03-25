<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyCreateRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = JobVacancy::latest();

        if (auth()->user()->role == 'company_owner') {
            $query->where('company_id', auth()->user()->companies->id);
        }

        // Archive
        if (request()->has('archived') && request()->get('archived') == 'true') {
            $query->onlyTrashed();
        }

        $jobVacancies = $query->paginate(10)->onEachSide(1);

        return view('JobVacancy.index', compact('jobVacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id = null)
    {
        $companies = Company::all();
        if ($id) {
            $company = Company::findOrFail($id);
        } else {
            $company = Company::where('ownerid', auth()->user()->id)->first();
        }

        $jobCategories = JobCategory::all();
        return view('JobVacancy.create', compact('companies', 'jobCategories', 'company'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(JobVacancyCreateRequest $request)
{
    $validatedData = $request->validated();

    if (auth()->user()->role === 'company-owner') {
        $company = Company::where('ownerid', auth()->id())->firstOrFail();
        $validatedData['company_id'] = $company->id;
        $validatedData['company'] = $company->name;
    } else {
        $company = Company::findOrFail($validatedData['company_id']);
        $validatedData['company'] = $company->name;
    }

    JobVacancy::create($validatedData);

    return redirect()->route('JobVacancy.index')
        ->with('success', 'Job vacancy created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);


        return view('JobVacancy.show', compact('jobVacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $companies = Company::all();
        $jobCategories = JobCategory::all();

        return view('JobVacancy.edit', compact('jobVacancy', 'companies', 'jobCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyCreateRequest $request, string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $validatedData = $request->validated();
        $jobVacancy->update($validatedData);
        return redirect()->route('JobVacancy.index')->with('success', 'Job vacancy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();

        return redirect()->route('JobVacancy.index')->with('success', 'Job vacancy deleted successfully.');
    }

    public function restore(string $id)
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $jobVacancy->restore();

        return redirect()->route('JobVacancy.index')->with('success', 'Job vacancy restored successfully.');
    }
}
