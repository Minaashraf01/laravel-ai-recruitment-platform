<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth','role:admin|company_owner'])->group(function () {

    // Dashboard Routes
    Route::get('/', [DashbordController::class, 'index'])->name('dashboard.index');


    // Application Routes
    Route::resource('/JobApplication', JobApplicationController::class);
    Route::post('/JobApplication/restore/{id}', [JobApplicationController::class, 'restore'])->name('JobApplication.restore');


    // Job Vacancy Routes
    Route::resource('/JobVacancy', JobVacancyController::class);
    Route::post('/JobVacancy/restore/{id}', [JobVacancyController::class, 'restore'])->name('JobVacancy.restore');

    //logout route fix
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');
});

//Company Owner Routes
Route::middleware(['auth','role:company_owner'])->group(function () {
    //my company
    Route::get('/my-company', [CompanyController::class, 'show'])->name('my-company.show');
    Route::get('/my-company/edit', [CompanyController::class, 'edit'])->name('my-company.edit');
    Route::put('/my-company', [CompanyController::class, 'update'])->name('my-company.update');

    //job application
    Route::resource('/my-JobApplication', JobApplicationController::class)->except(['index']);

});

//Admin Routes

Route::middleware(['auth','role:admin'])->group(function () {
        // User Routes
    Route::resource('/User', UserController::class);
    Route::post('/User/restore/{id}', [UserController::class, 'restore'])->name('User.restore');

        // Companines Routes
    Route::resource('/Company', CompanyController::class);
    Route::post('/Company/restore/{id}', [CompanyController::class, 'restore'])->name('Company.restore');

        // Job Category Routes
    Route::resource('/Job-category', JobCategoryController::class);
    Route::post('/Job-category/restore/{id}', [JobCategoryController::class, 'restore'])->name('Job-category.restore');


});

require __DIR__.'/auth.php';
