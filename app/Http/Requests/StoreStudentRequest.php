<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|string|max:255',
            'current_credits' => 'nullable|integer|min:0',
            'admission_year' => 'required|date',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            // 'status' => 'nullable|in:active,inactive,graduated,dropped_out',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone_number' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:3',
            'tuition_fee' => 'nullable|integer|min:50000',
            'major_id' => 'required',
        ];
    }
}
