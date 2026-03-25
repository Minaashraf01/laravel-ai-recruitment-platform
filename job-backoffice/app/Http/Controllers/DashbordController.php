<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;

class DashbordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role === 'admin') {
            $analytics = $this->AdminDashboard();
        } else {
            $analytics = $this->CompanyOwnerDashboard();
        }
       
        return view('dashboard.index', compact('analytics'));
    }

    private function AdminDashboard()
    {
         // Last 30 days ACTIVE users (Job seeker Only)
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))->where('role', 'job-seeker')->count();

        // Total Jobs
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        // Total Applications
        $totalApplications = JobApplication::whereNull('deleted_at')->count();

        

        // Most Applied Jobs
        $mostappliedJobs = JobVacancy::withCount('jobApplications as TotalApplications')->orderBy('TotalApplications', 'desc')
        ->limit(6)
        ->whereNull('deleted_at')
        ->get();

        // Conversion Rate

        $conversionRate = JobVacancy::withCount('jobApplications as TotalApplications')
        ->having('TotalApplications', '>', 0)
        ->orderBy('TotalApplications', 'desc')
        ->limit(8)
        ->whereNull('deleted_at')
        ->get()
        ->map(function ($job) {
            return [
                'job_title' => $job->title,
                'viewCount' => $job->viewCount,
                'TotalApplications' => $job->TotalApplications,
                'conversion_rate' => $job->viewCount > 0 ? round(($job->TotalApplications / $job->viewCount) * 100, 2) : 0,


            ];

        });
        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostappliedJobs' => $mostappliedJobs,
            'conversionRate' => $conversionRate,
        ];
        return $analytics;
    }

    private function CompanyOwnerDashboard()
{
    $user = auth()->user();



    $company = auth()->user()->companies;

    $activeUsers = User::where('role', 'job-seeker')
        ->where('last_login_at', '>=', now()->subDays(30))
        ->whereHas('jobApplications', function ($q) use ($company) {
            $q->whereIn('job_vacancy_id',$company->jobVacancies()->pluck('id'));
        })
        ->count();

        // Total Jobs of th company
        $totaljobs = $company->jobVacancies()->count();
        // Total Applications for the company
        $totalapplications= $company->jobApplications()->count();

        // Most Applied Jobs for the company
        $mostappliedJobs = $company->jobVacancies()
        ->withCount('jobApplications as TotalApplications')
        ->orderBy('TotalApplications', 'desc')
        ->limit(5)
        ->whereNull('deleted_at')
        ->get();

        // Conversion Rate for the company
            $conversionRate = $company->jobVacancies()
        ->withCount('jobApplications as TotalApplications')
        ->having('TotalApplications', '>', 0)
        ->orderBy('TotalApplications', 'desc')
        ->limit(8)
        ->whereNull('deleted_at')
        ->get()
        ->map(function ($job) {
            return [
                'job_title' => $job->title,
                'viewCount' => $job->viewCount,
                'TotalApplications' => $job->TotalApplications,
                'conversion_rate' => $job->viewCount > 0 ? round(($job->TotalApplications / $job->viewCount) * 100, 2) : 0,
            ];
        });
    $analytics = [
        'activeUsers' => $activeUsers,
        'totalJobs' => $totaljobs,
        'totalApplications' => $totalapplications,
        'mostappliedJobs' => $mostappliedJobs,
        'conversionRate' => $conversionRate,
    ];

    return $analytics;
}
}
