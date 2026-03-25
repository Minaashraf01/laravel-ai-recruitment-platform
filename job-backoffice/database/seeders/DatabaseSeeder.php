<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user

        User::firstOrCreate(
            ['email' => 'admin@amin.com'],
            [
            'name' => 'admin',
            'password' => Hash::make('123456123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        //Seed Data to test with 
        $jobData= json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $jobAPP =json_decode(file_get_contents(database_path('data/job_applications.json')), true);
        
        //Create Job Categories
        foreach($jobData['jobCategories'] as $category){
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }
        
        //Create Company
        foreach($jobData['companies'] as $company){
            // Create company owner
            $companyOwner = User::firstOrCreate(
                ['email' => fake()->unique()->safeEmail()],
                [
                    'name' => fake()->name(),
                    'password' => Hash::make('password'),
                    'role' => 'company_owner',
                    'email_verified_at' => now(),
                ]
            );
            Company::firstOrCreate(
                ['name' => $company['name'],
                ],
            [
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website'],
                'ownerid' => $companyOwner->id,
            ]);
        }

        // Create jobVacancies
        foreach($jobData['jobVacancies'] as $jobVacancy){

            $company = Company::where('name', $jobVacancy['company'])->firstOrFail();

            $category = JobCategory::where('name', $jobVacancy['category'])->firstOrFail();

            
                JobVacancy::firstOrCreate(
                    ['title' => $jobVacancy['title']],
                    [
                        'description' => $jobVacancy['description'],
                        'location' => $jobVacancy['location'],
                        'type' => $jobVacancy['type'],
                        'salary' => $jobVacancy['salary'],  
                        'job_category_id' => $category->id,
                        'company_id' => $company->id,
                        'company' => $company->name,
                    ]
                );
    }

    // Create Job Applications
    foreach($jobAPP['jobApplications'] as $application){

            // get random job vacancy
            $jobVacancy = JobVacancy::inRandomOrder()->first();
            // Create applicant user (job seeker)

            $applicant=User::firstOrCreate(
                ['email' => fake()->unique()->safeEmail()],
                [
                    'name' => fake()->name(),
                    'password' => Hash::make('password'),
                    'role' => 'job-seeker',
                    'email_verified_at' => now(),
                ]

            );
            // create Resume 
            $resume= Resume::create([
                'user_id' => $applicant->id,
                'filename' => $application['resume']['filename'],
                'fileUrl' => $application['resume']['fileUri'],
                'contactDetails' => $application['resume']['contactDetails'],
                'summary' => $application['resume']['summary'],
                'experience' => $application['resume']['experience'],
                'education' => $application['resume']['education'],
                'skills' => $application['resume']['skills'],
                

            ]);

            // Create job application
                JobApplication::create([
                'job_vacancy_id' => $jobVacancy->id,
                'user_id' => $applicant->id,
                'resume_id' => $resume->id,
                'aiGeneratedScore' => $application['aiGeneratedScore'],
                'AiGeneratedFeedback' => $application['aiGeneratedFeedback'],
                'status' => $application['status'],
                ]
            );
        }
    } 
}
