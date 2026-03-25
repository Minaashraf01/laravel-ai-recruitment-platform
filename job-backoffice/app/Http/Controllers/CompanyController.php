<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyEditRequest;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;
use PHPUnit\Util\PHP\Job;
use Psy\Util\Str;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Company::latest();

        //     Archive 
        if(request()->has('archived') && request()->get('archived') == 'true'){
            $query->onlyTrashed();
        } 
       
        $companies = $query->paginate(10)->onEachSide(1);
        return view('Company.index', compact('companies'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = [
            'Technology',
            'Healthcare',
            'Finance',
            'Education',
            'Retail',
            'Manufacturing',
            'Hospitality',
            'Transportation',
            'Energy',
            'Entertainment'
        ];
        return view('Company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validatedData = $request->validated();
        // Create Owner User
        $owner = User::create([
            'name' => $validatedData['owner_name'],
            'email' => $validatedData['owner_email'],
            'password' => Hash::make($validatedData['owner_password']),
            'role' => 'company_owner',
        ]);

            //Return error owner creation failed
        if(!$owner){
            return redirect()->route('Company.create')->withErrors('Owner creation failed. Please try again.')->withInput();
        }

        // Create Company
        $company = Company::create([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'industry' => $validatedData['industry'],
            'website' => $validatedData['website'] ?? null,
            'ownerid' => $owner->id,
        ]);
        
        return redirect()->route('Company.index', $company->id)->with('success', 'Company created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        if($id){
                    $company = Company::findOrFail($id);
        } else {
            $company = Company::where('ownerid', auth()->user()->id)->first();
        }

            return view('Company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id = null)
    {
        if($id){
        $company = Company::findOrFail($id);
        $industries = [
            'Technology',
            'Healthcare',
            'Finance',
            'Education',
            'Retail',
            'Manufacturing',
            'Hospitality',
            'Transportation',
            'Energy',
            'Entertainment'
        ];
        }
        else {
            $company = Company::where('ownerid', auth()->user()->id)->first();
            $industries = [
                'Technology',
                'Healthcare',
                'Finance',
                'Education',
                'Retail',
                'Manufacturing',
                'Hospitality',
                'Transportation',
                'Energy',
                'Entertainment'
            ];
        }
        return view('Company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyEditRequest $request, string $id = null)
    {
        if($id){
            $company = Company::findOrFail($id); 
        
        $validatedData = $request->validated();
        // Owner update
        $owner = User::findOrFail($company->ownerid);
        $owner->update([
            'name' => $validatedData['owner_name'],
            'password' => isset($validatedData['owner_password']) && !empty($validatedData['owner_password']) ? Hash::make($validatedData['owner_password']) : $owner->password,
        ]);
  
        
        // Update Company
        $company->update($validatedData);
        return redirect()->route('Company.index')->with('success', 'Company updated successfully.');
        }
        
        else {
            $company = Company::where('ownerid', auth()->user()->id)->first();
            $validatedData = $request->validated();
            // Owner update
            $owner = User::findOrFail($company->ownerid);
            $owner->update([
                'name' => $validatedData['owner_name'],
                'password' => isset($validatedData['owner_password']) && !empty($validatedData['owner_password']) ? Hash::make($validatedData['owner_password']) : $owner->password,
            ]);
      
            
            // Update Company
            $company->update($validatedData);
            return redirect()->route('my-company.show')->with('success', 'Company updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('Company.index')->with('status', 'Company archived successfully.');
    }
    // Restore the archived company
    public function restore(String $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('Company.index')->with('status', 'Company restored successfully.');
    }
}
