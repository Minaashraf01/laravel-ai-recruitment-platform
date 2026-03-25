<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobReqest;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Services\ResumeAnalysisService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class JobVacanciesController extends Controller
{
    protected $resumeAnalysisService;

    public function __construct(ResumeAnalysisService $resumeAnalysisService)
    {
        $this->resumeAnalysisService = $resumeAnalysisService;
    }

    public function show(string $id)
    {
        $jobVacancies = JobVacancy::findOrFail($id);

        $sessionKey = 'viewed_job_' . $jobVacancies->id;

    if (!session()->has($sessionKey)) {
        $jobVacancies->increment('viewCount');
        session()->put($sessionKey, true);
    }

        return view('Job-vacancies.show', compact('jobVacancies'));
    }

    public function apply(string $id)
    {
        $jobVacancies = JobVacancy::findOrFail($id);

        return view('Job-vacancies.apply', compact('jobVacancies'));
    }

    public function processApplication(ApplyJobReqest $request, string $id)
    {
        $file = $request->file('resume');
        $extension = $file->getClientOriginalExtension();
        $filename = 'resume_' . time() . '_' . uniqid() . '.' . $extension;

        $relativePath = $file->storeAs('resumes', $filename, 'public');
        $fileUrl = Storage::disk('public')->url($relativePath);

        $extractedInfo = $this->resumeAnalysisService->extractResumeInformation($relativePath);

        $education = $extractedInfo['education'] ?? '';
        $summary = $extractedInfo['summary'] ?? '';
        $skills = $extractedInfo['skills'] ?? '';
        $experience = $extractedInfo['experience'] ?? '';

        if (is_array($education)) {
            $education = json_encode($education, JSON_UNESCAPED_UNICODE);
        }

        if (is_array($summary)) {
            $summary = json_encode($summary, JSON_UNESCAPED_UNICODE);
        }

        if (is_array($experience)) {
            $experience = json_encode($experience, JSON_UNESCAPED_UNICODE);
        }

        if (is_array($skills)) {
            $skills = implode(', ', array_map('strval', $skills));
        }

        Log::debug('Final resume data before save', [
            'education' => $education,
            'summary' => $summary,
            'skills' => $skills,
            'experience' => $experience,
        ]);

        DB::beginTransaction();

        try {
            $resume = Resume::create([
                'user_id' => auth()->id(),
                'filename' => $filename,
                'fileUrl' => $fileUrl,
                'contactDetails' => json_encode([
                    'email' => auth()->user()->email,
                    'name' => auth()->user()->name,
                ], JSON_UNESCAPED_UNICODE),
                'education' => (string) $education,
                'summary' => (string) $summary,
                'skills' => (string) $skills,
                'experience' => (string) $experience,
            ]);
            // Analyze the resume against the job vacancy and get the evaluation result
            $evaluationResult = $this->resumeAnalysisService->analyzeResume(JobVacancy::findOrFail($id), [
                'education' => $education,
                'summary' => $summary,
                'skills' => $skills,
                'experience' => $experience,
            ]);

            JobApplication::create([
                'status' => 'pending',
                'job_vacancy_id' => $id,
                'user_id' => auth()->id(),
                'resume_id' => $resume->id,
                'aiGeneratedScore' => $evaluationResult['aiGeneratedScore'] ?? 0,
                'aiGeneratedFeedback' => $evaluationResult['aiGeneratedFeedback'] ?? '',
            ]);

            DB::commit();

            return redirect()
                ->route('job-applications.index', $id)
                ->with('success', 'Your application has been submitted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Error while processing job application: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while submitting your application.');
        }
    }
}
