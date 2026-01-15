<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVendorRequest extends FormRequest
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
        $vendorId = $this->route('id'); // assuming your route has {id}

        return [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => [
                'required',
                'email',
                Rule::unique('vendors', 'email')->ignore($vendorId),
            ],
            'address1' => 'required|min:3',
            'address2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required|digits:6',
            'pan_no' => [
                'nullable',
                Rule::unique('vendors', 'pan_no')->ignore($vendorId),
            ],
            'gst_no' => [
                'nullable',
                Rule::unique('vendors', 'gst_no')->ignore($vendorId),
            ],
            'status' => 'required|in:inactive,active',
        ];
    }
}
