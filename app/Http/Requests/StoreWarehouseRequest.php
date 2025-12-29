<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRequest extends FormRequest
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
            'warehouse_name' => 'required|min:3',
            'warehouse_type' => 'required',
            'warehouse_addr1' => 'required|min:3',
            'warehouse_addr2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required|digits:6',
            'contact_person_name' => 'required|min:3',
            'phone_number' => 'required|digits:10',
            'alternate_phone_number' => 'nullable',
            'email' => 'required|email',
            'working_hours' => 'nullable',
            'working_days' => 'nullable',
            'max_store_capacity' => 'nullable',
            'supported_operations' => 'nullable',
            'zone_conf' => 'nullable',
            'gst_no' => 'nullable',
            'licence_no' => 'nullable',
            'licence_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'default_warehouse' => 'nullable',
            'status' => 'nullable',
        ];
    }
}
