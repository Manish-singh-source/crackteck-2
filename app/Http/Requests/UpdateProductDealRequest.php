<?php

namespace App\Http\Requests;

use App\Models\EcommerceProduct;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductDealRequest extends FormRequest
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
            'deal_title' => [
                'required',
                'string',
                'max:255',
                'min:3',
            ],
            'offer_start_date' => [
                'required',
                'date',
            ],
            'offer_end_date' => [
                'required',
                'date',
                'after:offer_start_date',
            ],
            'status' => [
                'required',
                'in:active,inactive',
            ],
            'products' => [
                'required',
                'array',
                'min:1',
            ],
            'products.*.ecommerce_product_id' => [
                'required',
                'exists:ecommerce_products,id',
                function ($attribute, $value, $fail) {
                    $product = EcommerceProduct::with('warehouseProduct')
                        ->where('id', $value)
                        ->where('status', 'active')
                        ->whereHas('warehouseProduct', function ($query) {
                            $query->where('status', 'active');
                        })
                        ->first();

                    if (! $product) {
                        $fail('One of the selected products is not available for deals.');
                    }
                },
            ],
            'products.*.discount_type' => [
                'required',
                'in:percentage,flat',
            ],
            'products.*.discount_value' => [
                'required',
                'numeric',
                'min:0.01',
            ],
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
            'deal_title.required' => 'Deal title is required.',
            'deal_title.min' => 'Deal title must be at least 3 characters long.',
            'deal_title.max' => 'Deal title cannot exceed 255 characters.',
            'offer_start_date.required' => 'Offer start date is required.',
            'offer_start_date.date' => 'Offer start date must be a valid date.',
            'offer_end_date.required' => 'Offer end date is required.',
            'offer_end_date.date' => 'Offer end date must be a valid date.',
            'offer_end_date.after' => 'Offer end date must be after the start date.',
            'status.required' => 'Please select a status for this deal.',
            'status.in' => 'Status must be either "Active" or "Inactive".',
            'products.required' => 'At least one product must be added to the deal.',
            'products.min' => 'At least one product must be added to the deal.',
            'products.*.ecommerce_product_id.required' => 'Product selection is required.',
            'products.*.ecommerce_product_id.exists' => 'Selected product does not exist.',
            'products.*.discount_type.required' => 'Discount type is required for each product.',
            'products.*.discount_type.in' => 'Discount type must be either "Percentage" or "Flat".',
            'products.*.discount_value.required' => 'Discount value is required for each product.',
            'products.*.discount_value.numeric' => 'Discount value must be a valid number.',
            'products.*.discount_value.min' => 'Discount value must be greater than 0.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'deal_title' => 'deal title',
            'offer_start_date' => 'offer start date',
            'offer_end_date' => 'offer end date',
            'status' => 'status',
            'products' => 'products',
            'products.*.ecommerce_product_id' => 'product',
            'products.*.discount_type' => 'discount type',
            'products.*.discount_value' => 'discount value',
        ];
    }
}
