<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'requested_by' => 'required|exists:users,id',
            'request_date' => 'required|date|before_or_equal:today',
            'reason' => 'required|string|max:1000',
            'urgency_level' => 'required|in:Low,Medium,High,Critical',

            // Products validation
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1|max:10000',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'requested_by.required' => 'The requested by field is required.',
            'requested_by.exists' => 'The selected user does not exist.',
            'request_date.required' => 'The request date is required.',
            'request_date.date' => 'The request date must be a valid date.',
            'request_date.before_or_equal' => 'The request date cannot be in the future.',
            'reason.required' => 'The reason/justification is required.',
            'reason.max' => 'The reason cannot exceed 1000 characters.',
            'urgency_level.required' => 'The urgency level is required.',
            'urgency_level.in' => 'The urgency level must be Low, Medium, High, or Critical.',
            'products.required' => 'At least one product must be added to the request.',
            'products.min' => 'At least one product must be added to the request.',
            'products.*.product_id.required' => 'Product selection is required.',
            'products.*.product_id.exists' => 'The selected product does not exist.',
            'products.*.quantity.required' => 'Product quantity is required.',
            'products.*.quantity.integer' => 'Product quantity must be a number.',
            'products.*.quantity.min' => 'Product quantity must be at least 1.',
            'products.*.quantity.max' => 'Product quantity cannot exceed 10,000.',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'requested_by' => 'requested by',
            'request_date' => 'request date',
            'reason' => 'reason/justification',
            'urgency_level' => 'urgency level',
            'products.*.product_id' => 'product',
            'products.*.quantity' => 'quantity',
        ];
    }
}
