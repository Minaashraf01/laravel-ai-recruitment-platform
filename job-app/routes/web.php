<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationsController;
use App\Http\Controllers\JobVacanciesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth','role:job-seeker'])->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    Route::get('/job-applications', [JobApplicationsController::class, 'index'])->name('job-applications.index');
    // Job Vacancies Routes
    Route::get('/job-vacancies/{id}', [JobVacanciesController::class, 'show'])->name('job-vacancies.show');
    Route::get('/job-vacancies/apply/{id}', [JobVacanciesController::class, 'apply'])->name('job-vacancies.apply');
    Route::post('/job-vacancies/apply/{id}', [JobVacanciesController::class, 'processApplication'])->name('job-vacancies.processApplication');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


    // Test OpenAI Route
    Route::get('/test-openai', [JobVacanciesController::class, 'testOpenAI'])->name('test-openai');
});

require __DIR__.'/auth.php';
