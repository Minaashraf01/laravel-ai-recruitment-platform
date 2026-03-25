<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
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
            // Validation rules for creating a job vacancy
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0|max:1000000000',
            'description' => 'required|string',
            // Add other fields and their validation rules as needed 
            'company_id' => 'required|exists:companies,id',
            'job_category_id' => 'required|exists:job_categories,id',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'The job title is required.',
            'title.string' => 'The job title must be a string.',
            'title.max' => 'The job title may not be greater than 255 characters.',
            'company.string' => 'The company name must be a string.',
            'company.max' => 'The company name may not be greater than 255 characters.',
            'location.required' => 'The job location is required.',
            'location.string' => 'The job location must be a string.',
            'location.max' => 'The job location may not be greater than 255 characters.',
            'salary.required' => 'The expected salary is required.',
            'salary.numeric' => 'The expected salary must be a number.',
            'salary.min' => 'The expected salary must be at least 0.',
            'salary.max' => 'The expected salary may not be greater than 1000000000.',
            'description.required' => 'The job description is required.',
            'company_id.required' => 'The company selection is required.',
            'company_id.exists' => 'The selected company does not exist.',
            'job_category_id.required' => 'The job category selection is required.',
            'job_category_id.exists' => 'The selected job category does not exist.',
        ];
    }
}
