<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationEditRequest;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;

use Pest\Support\Str;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request )
    {
        $query=JobApplication::latest();
        
        if(auth()->user()->role == 'company_owner'){
            $query->whereHas('jobVacancy', function ($query) {
                $query->where('company_id', auth()->user()->companies->id);
            });
        }

        // Archive
        if(request()->has('archived') && request()->get('archived') == 'true'){
            $query->onlyTrashed();
        }

        $myJobApplications = $query->get();
        

            $jobApplications = $query->paginate(10)->onEachSide(1);
            return view ('JobApplication.index', compact('jobApplications'));            
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view('JobApplication.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view('JobApplication.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationEditRequest $request, string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->update($request->validated());
        return redirect()->route('JobApplication.index')->with('success', 'Job Application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();

        return redirect()->route('JobApplication.index')->with('success', 'Job Application archived successfully.');
    }   
    
        // Restore archived job application
    public function restore(string $id)
    {
        $jobApplication = JobApplication::withTrashed()->findOrFail($id);
        $jobApplication->restore();
        return redirect()->route('JobApplication.index')->with('success', 'Job Application restored successfully.');
    }
}