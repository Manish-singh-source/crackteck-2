<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            // Personal
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:customers,email',
            'dob' => 'nullable|date|before:' . now()->subYears(18)->format('Y-m-d'),
            'gender' => 'nullable|in:male,female,other',
            'customer_type' => 'nullable|in:ecommerce,amc,both,offline',
            'source_type' => 'required|in:ecommerce,admin_panel,app,call,walk_in,other',
            'status' => 'nullable|in:active,inactive,blocked,suspended',
            'profile' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'is_lead' => 'nullable|in:0,1',

            // Aadhar
            'aadhar_number' => 'nullable|string|max:20',
            'aadhar_front_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'aadhar_back_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // PAN
            'pan_number' => 'nullable|string|max:20',
            'pan_card_front_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'pan_card_back_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // Branches
            'branches' => 'required|array|min:1',
            'branches.*.branch_name' => 'required|string|max:255',
            'branches.*.address1' => 'required|string|max:255',
            'branches.*.address2' => 'nullable|string|max:255',
            'branches.*.city' => 'required|string|max:255',
            'branches.*.state' => 'required|string|max:255',
            'branches.*.country' => 'required|string|max:255',
            'branches.*.pincode' => 'required|string|max:20',
            'is_primary' => 'required|integer',

            // Company
            'company_name' => 'nullable|string|max:255',
            'comp_address1' => 'nullable|string|max:255',
            'comp_address2' => 'nullable|string|max:255',
            'comp_city' => 'nullable|string|max:255',
            'comp_state' => 'nullable|string|max:255',
            'comp_country' => 'nullable|string|max:255',
            'comp_pincode' => 'nullable|string|max:20',
            'gst_no' => 'nullable|string|max:50',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'phone.required' => 'Phone number is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'Email has already been taken.',
            'dob.before' => 'The user must be at least 18 years old.',
            'source_type.required' => 'Source type is required.',

            'branches.required' => 'At least one branch is required.',
            'branches.*.branch_name.required' => 'Branch name is required.',
            'branches.*.address1.required' => 'Branch address is required.',
            'branches.*.city.required' => 'Branch city is required.',
            'branches.*.state.required' => 'Branch state is required.',
            'branches.*.country.required' => 'Branch country is required.',
            'branches.*.pincode.required' => 'Branch pincode is required.',
            'is_primary.required' => 'Primary branch is required.',
        ];
    }
}
