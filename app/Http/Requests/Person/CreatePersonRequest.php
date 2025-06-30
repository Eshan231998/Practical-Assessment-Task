<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;

class CreatePersonRequest extends FormRequest
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
            'full_name' => ['required', 'regex:/^[A-Za-z .\'-]{2,100}$/'],
            'national_id' => [
                'required',
                'regex:/^[0-9]{9}[vVxX]$|^[0-9]{12}$/',
                'unique:person,national_id'
            ],
            'date_of_birth' => ['required', 'date', 'before:-18 years'],
            'gender_id' => ['required', 'exists:genders,id'],
            'religion_id' => ['required', 'exists:religions,id'],
            'address' => ['required', 'string', 'min:5', 'max:255'],
            'contact_number' => ['required', 'regex:/^\+?\d{10,15}$/'],
            'email_address' => ['required', 'email', 'max:255'],
        ];
    }


    public function messages()
    {
        return [
            'full_name.required' => 'Full Name is required.',
            'full_name.regex' => 'Full Name must be 2-100 alphabetic characters and may include spaces, dots, hyphens, and apostrophes.',
            'national_id.required' => 'National ID Number is required.',
            'national_id.regex' => 'National ID Number must be valid (e.g., 123456789V or 200012345678).',
            'national_id.unique' => 'National ID Number already exists.',
            'date_of_birth.required' => 'Date of Birth is required.',
            'date_of_birth.date' => 'Date of Birth must be a valid date.',
            'date_of_birth.before' => 'Person must be at least 18 years old.',
            'gender_id.required' => 'Gender is required.',
            'gender_id.exists' => 'Selected gender is invalid.',
            'religion_id.required' => 'Religion is required.',
            'religion_id.exists' => 'Selected religion is invalid.',
            'address.required' => 'Address is required.',
            'address.min' => 'Address must be at least 5 characters.',
            'address.max' => 'Address must not exceed 255 characters.',
            'contact_number.required' => 'Contact Number is required.',
            'contact_number.regex' => 'Contact Number must be 10-15 digits and may start with +.',
            'email_address.required' => 'Email Address is required.',
            'email_address.email' => 'Email Address must be a valid email.',
            'email_address.max' => 'Email Address must not exceed 255 characters.',
        ];
    }
}
