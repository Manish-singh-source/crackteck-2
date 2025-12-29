<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequestRequest extends FormRequest
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
            // Status updates (editable fields)
            'approval_status' => 'sometimes|string|in:Pending,Approved,Rejected',
            'final_status' => 'sometimes|string|in:Pending,Completed,Cancelled',

            // Products validation (for editing products)
            'products' => 'sometimes|array|min:1',
            'products.*.id' => 'sometimes|exists:stock_request_items,id',
            'products.*.product_id' => 'required_with:products|exists:products,id',
            'products.*.quantity' => 'required_with:products|integer|min:1|max:10000',
            'products.*.action' => 'sometimes|in:update,delete,add',

            // New products to add
            'new_products' => 'sometimes|array',
            'new_products.*.product_id' => 'required_with:new_products|exists:products,id',
            'new_products.*.quantity' => 'required_with:new_products|integer|min:1|max:10000',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'approval_status.in' => 'The approval status must be Pending, Approved, or Rejected.',
            'final_status.in' => 'The final status must be Pending, Completed, or Cancelled.',
            'products.min' => 'At least one product must remain in the request.',
            'products.*.product_id.required_with' => 'Product selection is required.',
            'products.*.product_id.exists' => 'The selected product does not exist.',
            'products.*.quantity.required_with' => 'Product quantity is required.',
            'products.*.quantity.integer' => 'Product quantity must be a number.',
            'products.*.quantity.min' => 'Product quantity must be at least 1.',
            'products.*.quantity.max' => 'Product quantity cannot exceed 10,000.',
            'new_products.*.product_id.required_with' => 'Product selection is required for new products.',
            'new_products.*.product_id.exists' => 'The selected product does not exist.',
            'new_products.*.quantity.required_with' => 'Quantity is required for new products.',
            'new_products.*.quantity.integer' => 'Product quantity must be a number.',
            'new_products.*.quantity.min' => 'Product quantity must be at least 1.',
            'new_products.*.quantity.max' => 'Product quantity cannot exceed 10,000.',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'approval_status' => 'approval status',
            'final_status' => 'final status',
            'products.*.product_id' => 'product',
            'products.*.quantity' => 'quantity',
            'new_products.*.product_id' => 'new product',
            'new_products.*.quantity' => 'new product quantity',
        ];
    }
}
