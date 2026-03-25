<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyEditRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'industry' => 'nullable|string|max:255',
            // Owner Details
            'owner_name' => 'required|string|max:255',
            'owner_password' => 'nullable|string|min:8',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The company name is required.',
            'name.max' => 'The company name may not be greater than 255 characters.',
            'address.max' => 'The company address may not be greater than 500 characters.',
            'address.string' => 'The company address must be a string.',
            'address.required' => 'The company address is required.',
            'industry.string' => 'The industry must be a string.',
            'industry.max' => 'The industry may not be greater than 255 characters.',
            'industry.required' => 'The industry is required.',
            'website.url' => 'The website must be a valid URL.',
            'website.max' => 'The website may not be greater than 255 characters.',
            'owner_name.required' => 'The owner name is required.',
            'owner_email.required' => 'The owner email is required.',
            'owner_email.email' => 'The owner email must be a valid email address.',
            'owner_name.unique' => 'The owner name has already been taken.',
           'owner_password.min' => 'The owner password must be at least 8 characters.',
            ];
    }
}
