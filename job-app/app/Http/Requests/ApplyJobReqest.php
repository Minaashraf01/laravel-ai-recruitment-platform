<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyJobReqest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'resume' => 'required|file|mimes:pdf|max:2048', // Max size in KB (5MB)
        ];
    }

    public function messages(): array
    {
        return [
            'resume.required' => 'Please upload your resume.',
            'resume.file' => 'The uploaded file must be a valid file.',
            'resume.mimes' => 'Only PDF files are allowed.',
            'resume.max' => 'The resume must not exceed 2MB in size.',
        ];
    }
}
