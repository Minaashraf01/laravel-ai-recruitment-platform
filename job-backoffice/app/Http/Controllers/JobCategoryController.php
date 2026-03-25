<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategoryCreateRequest;
use App\Http\Requests\JobCategoryEditRequest;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use PHPUnit\Util\PHP\Job;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        $query = JobCategory::latest();

        // Archive 
        if ($request->query('archived') === 'true') {
            $query->onlyTrashed();
        }
        
        // Active 
        if ($request->query('archived') === 'false') {
            $query->whereNull('deleted_at');
        }

        $jobCategories = $query->paginate(10)->onEachSide(1);


        return view('Job-category.index')->with('jobCategories', $jobCategories);
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function create()
    {

        return view('Job-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
        JobCategory::create($request->validated());
        return redirect()->route('Job-category.index')->with('success', 'Job Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobCategory $jobCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id )
    {
        $jobCategory=JobCategory::findOrFail($id);
        return view('Job-category.edit')->with('jobCategory', $jobCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryEditRequest $request, string $id)
    {
        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->update($request->validated());
        return redirect()->route('Job-category.index')->with('success', 'Job Category Updated Successfully!');}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Archive the job category 
        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->delete();
        return redirect()->route('Job-category.index')->with('success', 'Job Category Archived Successfully!');
    }

    // Restore the archived job category
    public function restore(string $id)
    {
        $jobCategory = JobCategory::withTrashed()->findOrFail($id);
        $jobCategory->restore();
        return redirect()->route('Job-category.index')->with('success', 'Job Category Restored Successfully!');
    }  
}
