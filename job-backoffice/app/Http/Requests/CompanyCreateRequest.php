<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:companies,name',
            'address' => 'required|string|max:500',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',

            // Owner Details
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255|unique:users,email',
            'owner_password' => 'required|string|min:8',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The company name is required.',
            'address.required' => 'The company address is required.',
            'industry.required' => 'The industry field is required.',
            'website.url' => 'The website must be a valid URL.',
            'name.unique' => 'The company name has already been taken.',
            'name.max' => 'The company name may not be greater than 255 characters.',
            'address.max' => 'The company address may not be greater than 500 characters.',
            'industry.max' => 'The industry may not be greater than 255 characters.',
            'website.max' => 'The website may not be greater than 255 characters.',
            'website.string' => 'The website must be a string.',
            'owner_name.required' => 'The owner name is required.',
            'owner_email.required' => 'The owner email is required.',
            'owner_email.email' => 'The owner email must be a valid email address.',
            'owner_email.unique' => 'The owner email has already been taken.',
            'owner_password.required' => 'The owner password is required.',
            'owner_password.min' => 'The owner password must be at least 8 characters.',
        ];
    }
}
