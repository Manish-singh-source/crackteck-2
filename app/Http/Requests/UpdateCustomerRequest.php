<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
        $customerId = $this->route('id');
        
        return [
            // Personal
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:customers,email,' . $customerId,
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'customer_type' => 'nullable|in:ecommerce,amc,both,offline',
            'source_type' => 'nullable|in:ecommerce,admin_panel,app,call,walk_in,other',
            'profile' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'status' => 'nullable|in:active,inactive,blocked,suspended',

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
            'branches.*.id' => 'nullable|exists:customer_address_details,id',
            'branches.*.branch_name' => 'required|string|max:255',
            'branches.*.address1' => 'required|string|max:255',
            'branches.*.address2' => 'nullable|string|max:255',
            'branches.*.city' => 'required|string|max:255',
            'branches.*.state' => 'required|string|max:255',
            'branches.*.country' => 'required|string|max:255',
            'branches.*.pincode' => 'required|string|max:20',
            'is_primary' => 'nullable|integer',

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
}
