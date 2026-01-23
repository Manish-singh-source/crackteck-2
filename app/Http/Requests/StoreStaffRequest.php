<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Return true if the user is authorized to perform this action, otherwise false.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Role / staff table
            'role' => 'required',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:staff,email',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'marital_status' => 'nullable|in:married,unmarried,divorced',
            'employment_type' => 'nullable|in:full_time,part_time',
            'joining_date' => 'nullable|date',
            'assigned_area' => 'nullable|string|max:255',
            'status' => 'nullable|in:inactive,active,resigned,terminated,blocked,suspended,pending',

            // Address
            'address1' => 'required',
            'address2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required|string|max:20',

            // Bank
            'bank_acc_holder_name' => 'nullable|string|max:255',
            'bank_acc_number' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:20',
            'passbook_pic' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // Work skills
            'primary_skills' => 'nullable|array',
            'primary_skills.*' => 'nullable|string',
            'languages_known' => 'nullable|array',
            'languages_known.*' => 'nullable|string',
            'certifications' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'experience' => 'nullable|integer',

            // Aadhar
            'aadhar_number' => 'nullable|string|max:20',
            'aadhar_front_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'aadhar_back_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // PAN
            'pan_number' => 'nullable|string|max:20',
            'pan_card_front_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'pan_card_back_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // Vehicle
            'vehicle_type' => 'nullable|in:two_wheeler,three_wheeler,four_wheeler,other',
            'vehicle_number' => 'nullable|string|max:50|unique:staff_vehicle_details,vehicle_number',
            'driving_license_no' => 'nullable|string|max:50|unique:staff_vehicle_details,driving_license_no',
            'driving_license_front_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'driving_license_back_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // Police verification
            'police_verification' => 'nullable|in:no,yes',
            'police_verification_status' => 'nullable|in:pending,completed',
            'police_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            // Optional: Define custom attribute names for validation error messages
            'role' => 'staff role',
            'first_name' => 'first name',
            'last_name' => 'last name',
            // Add other attributes as needed
        ];
    }
}
