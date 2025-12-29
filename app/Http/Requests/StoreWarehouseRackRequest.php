<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRackRequest extends FormRequest
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
            'warehouse_id' => 'required',
            'rack_name' => 'required',
            'zone_area' => 'required',
            'rack_no' => 'required',
            'level_no' => 'nullable',
            'position_no' => 'nullable',
            'floor' => 'nullable',
            'quantity' => 'nullable',
        ];
    }
}
