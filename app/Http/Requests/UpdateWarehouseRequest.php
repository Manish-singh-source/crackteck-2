<?php

namespace App\Http\Requests;

use App\Models\Warehouse;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $warehouseId = $this->route('id'); // from route parameter

        return [
            'name' => 'required|min:3',
            'type' => 'required',
            'address1' => 'required|min:3',
            'address2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required|digits:6',

            'contact_person_name' => 'required|min:3',
            'phone_number' => 'required|digits:10',
            'alternate_phone_number' => 'nullable|digits:10',

            'email' => [
                'required',
                'email',
                Rule::unique('warehouses', 'email')->ignore($warehouseId),
            ],

            'working_hours' => 'nullable',
            'working_days' => 'nullable',
            'max_store_capacity' => 'nullable|numeric',
            'supported_operations' => 'nullable',
            'zone_conf' => 'nullable',

            'gst_no' => [
                'nullable',
                Rule::unique('warehouses', 'gst_no')->ignore($warehouseId),
            ],

            'licence_no' => [
                'nullable',
                Rule::unique('warehouses', 'licence_no')->ignore($warehouseId),
            ],

            'licence_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png',

            'verification_status' => 'required|in:pending,verified,rejected',
            'default_warehouse' => 'required|in:no,yes',
            'status' => 'required|in:inactive,active',
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (
                $this->default_warehouse === 'yes' &&
                Warehouse::where('default_warehouse', 'yes')
                ->where('id', '!=', $this->route('id'))
                ->exists()
            ) {
                $validator->errors()->add(
                    'default_warehouse',
                    'One warehouse has already default value kindly check.'
                );
            }
        });
    }
}
