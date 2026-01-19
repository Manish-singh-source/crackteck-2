<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Add policy logic if needed
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:50|unique:coupons,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed,buy_x_get_y',
            'discount_value' => 'required|numeric|min:0.01',
            'max_discount' => 'nullable|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'nullable|integer|min:0',
            'usage_per_customer' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive,expired',
            'stackable' => 'nullable|in:0,1',
            'applicable_categories' => 'nullable|array',
            'applicable_categories.*' => 'exists:parent_categories,id',
            'applicable_brands' => 'nullable|array',
            'applicable_brands.*' => 'exists:brands,id',
            'excluded_products' => 'nullable|array',
            'excluded_products.*' => 'exists:ecommerce_products,id',
        ];
    }

    public function messages(): array
    {
        return [
            'discount_value.min' => 'Discount value must be greater than 0.',
            'applicable_categories.*.exists' => 'One or more selected categories are invalid.',
            'applicable_brands.*.exists' => 'One or more selected brands are invalid.',
            'excluded_products.*.exists' => 'One or more excluded products are invalid.',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            // Custom validation: percentage cannot exceed 100
            if ($this->type === 'percentage' && $this->discount_value > 100) {
                $validator->errors()->add('discount_value', 'Percentage discount cannot exceed 100%.');
            }
        });
    }
}
