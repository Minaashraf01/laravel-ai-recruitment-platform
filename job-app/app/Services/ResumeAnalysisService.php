<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Spatie\PdfToText\Pdf;
use OpenAI\Laravel\Facades\OpenAI;

class ResumeAnalysisService
{
    public function extractResumeInformation(string $relativePath)
    {
        try {
            // Extract raw text from PDF
            $RawText = $this->ExtractTextPdf($relativePath);

            // Clean extracted text before sending to AI
            $RawText = $this->cleanExtractedText($RawText);

            Log::debug("Successfully extracted text from resume: " . substr($RawText, 0, 200) . "...");

            // Use OpenAI to organize resume text into structured JSON
            $response = OpenAI::chat()->create([
                'model' => 'gpt-5.2',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are a resume parsing assistant.

Your task:
- Read raw resume text.
- Extract the most relevant structured information.

Return ONLY a valid JSON object.
Do not add any text before or after the JSON.

The JSON object must contain exactly these keys:
- summary
- skills
- experience
- education

Rules:
- Use concise and relevant information only.
- If a field is missing, return an empty string for it.
- Do not add extra keys.
- Do not explain your answer."
                    ],
                    [
                        'role' => 'user',
                        'content' => "Extract structured information from this resume text.

Resume text:
{$RawText}"
                    ]
                ],
                'response_format' => [
                    'type' => 'json_object'
                ],
                'temperature' => 0.2
            ]);

            $result = $response->choices[0]->message->content;
            Log::debug("OpenAI response: " . $result);

            $parsedResult = json_decode($result, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("Failed to parse OpenAI response as JSON: " . json_last_error_msg());
                throw new \Exception("Failed to parse OpenAI response as JSON: " . json_last_error_msg());
            }

            Log::debug('Parsed result:', $parsedResult);

            // Validate required keys
            $requiredKeys = ['skills', 'experience', 'education', 'summary'];
            $missingkeys = array_diff($requiredKeys, array_keys($parsedResult));

            if (count($missingkeys) > 0) {
                Log::error("OpenAI response is missing required keys: " . implode(', ', $missingkeys));
                throw new \Exception("OpenAI response is missing required keys: " . implode(', ', $missingkeys));
            }

            return [
                'skills' => $parsedResult['skills'] ?? '',
                'experience' => $parsedResult['experience'] ?? '',
                'education' => $parsedResult['education'] ?? '',
                'summary' => $parsedResult['summary'] ?? ''
            ];
        } catch (\Exception $e) {
            Log::error("Error in ResumeAnalysisService: " . $e->getMessage());

            return [
                'skills' => '',
                'experience' => '',
                'education' => '',
                'summary' => ''
            ];
        }
    }

    public function analyzeResume($jobVacancy, $resumeData)
    {
        try {
            $JobDetails = json_encode([
                'title' => $jobVacancy->title,
                'description' => $jobVacancy->description,
                'job_location' => $jobVacancy->location,
                'job_type' => $jobVacancy->type,
                'job_salary' => $jobVacancy->salary,
            ]);

            $resemeDetails = json_encode($resumeData);

            $response = OpenAI::chat()->create([
                'model' => 'gpt-5.2',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are an expert HR professional and recruiter analyzing job applications.

Your task:
1. Extract the candidate's name from the resume.
2. Evaluate the resume based on the job requirements.
3. Provide concise hiring feedback.

Return ONLY a valid JSON object.
Do not add any extra text before or after the JSON.

The JSON object must contain exactly these keys:
- candidateName
- aiGeneratedFeedback
- aiGeneratedScore

Rules:
- candidateName must always be a string.
- If the candidate name is not clearly found, use 'The candidate'.
- aiGeneratedScore must be a number from 0 to 100.

aiGeneratedFeedback must follow this structure:

Strengths:
- relevant point(s)

Weak points:
- relevant point(s)

Suggestion:
- short actionable suggestion

Additional rules:
- Do NOT repeat section titles
- Group all strengths under one 'Strengths' section
- Group all weak points under one 'Weak points' section
- Use bullet points (-)
- Use as many bullet points as needed, but keep it concise
- Maximum 6 total bullet points across all sections
- Keep the feedback practical and easy to read
- Do not add extra keys
- Do not explain outside JSON.",
                    ],
                    [
                        'role' => 'user',
                        'content' => "Analyze this job application.

Job vacancy details:
{$JobDetails}

Resume details:
{$resemeDetails}"
                    ],
                ],
                'response_format' => [
                    'type' => 'json_object'
                ],
                'temperature' => 0.1
            ]);

            $result = $response->choices[0]->message->content;
            Log::debug("OpenAI response for resume analysis: " . $result);

            $parsedResult = json_decode($result, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("Failed to parse OpenAI response as JSON: " . json_last_error_msg());
                throw new \Exception("Failed to parse OpenAI response as JSON: " . json_last_error_msg());
            }

            if (
                !isset($parsedResult['candidateName']) ||
                !isset($parsedResult['aiGeneratedScore']) ||
                !isset($parsedResult['aiGeneratedFeedback'])
            ) {
                Log::error("OpenAI response is missing required keys: candidateName, aiGeneratedScore, or aiGeneratedFeedback");
                throw new \Exception("OpenAI response is missing required keys: candidateName, aiGeneratedScore, or aiGeneratedFeedback");
            }

            return [
                'candidateName' => $parsedResult['candidateName'] ?: 'The candidate',
                'aiGeneratedScore' => $parsedResult['aiGeneratedScore'],
                'aiGeneratedFeedback' => $parsedResult['aiGeneratedFeedback']
            ];
        } catch (\Exception $e) {
            Log::error("Error in ResumeAnalysisService while analyzing resume: " . $e->getMessage());

            return [
                'candidateName' => 'The candidate',
                'aiGeneratedScore' => 0,
                'aiGeneratedFeedback' => 'Unable to analyze the resume at this time.'
            ];
        }
    }

    private function ExtractTextPdf(string $fileUrl): string
    {
        $tempfile = tempnam(sys_get_temp_dir(), "resume");

        $filePath = storage_path('app/public/' . $fileUrl);

        if (!file_exists($filePath)) {
            throw new \Exception("File not found: " . $filePath);
        }

        $filename = basename($filePath);
        $storagePath = storage_path('app/public/resumes/' . $filename);

        if (!file_exists($storagePath)) {
            throw new \Exception("File not found in storage: " . $storagePath);
        }

        $pdfContent = file_get_contents($storagePath);

        if ($pdfContent === false) {
            throw new \Exception("Failed to read file content: " . $storagePath);
        }

        file_put_contents($tempfile, $pdfContent);

        // Check pdftotext path
        $pdftotextPath = ['/usr/bin/pdftotext', '/usr/local/bin/pdftotext', '/opt/homebrew/bin/pdftotext'];
        $pdftotextAvailable = false;

        foreach ($pdftotextPath as $path) {
            if (file_exists($path)) {
                $pdftotextAvailable = true;
                $pdftotextPath = $path;
                break;
            }
        }

        if (!$pdftotextAvailable) {
            throw new \Exception("pdftotext is not installed on the server.");
        }

        $instance = new Pdf($pdftotextPath);
        $text = $instance->setPdf($tempfile)->text();

        unlink($tempfile);

        return $text;
    }

    private function cleanExtractedText(string $text): string
    {
        // Remove excessive spaces and line breaks
        $text = preg_replace('/\r\n|\r/', "\n", $text);
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        // Remove non-printable control characters
        $text = preg_replace('/[^\P{C}\n\t]/u', '', $text);

        return trim($text);
    }
}