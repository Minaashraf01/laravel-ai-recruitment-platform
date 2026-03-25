<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $query = JobVacancy::query();

    // 1) Search
    if ($request->filled('search')) {
        $search = trim($request->search);

        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%")
              ->orWhereHas('company', function ($cq) use ($search) {
                  $cq->where('name', 'like', "%{$search}%");
              });
        });
    }

    // 2) Filter (Category / type)
    if ($request->filled('filter')) {
        $query->where('type', $request->filter);
    }

    $jobs = $query->latest()->paginate(10)->withQueryString();

    return view('dashboard', compact('jobs'));
}
}
