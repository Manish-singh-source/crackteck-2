<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust if you use policies
    }

    public function rules(): array
    {
        $couponId = $this->route('id'); // matches controller parameter

        return [
            'code' => 'required|string|max:50|unique:coupons,code,' . $couponId,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',

            'type' => 'required|in:percentage,fixed,buy_x_get_y',
            'discount_value' => 'required|numeric|min:0.01',

            'max_discount' => 'nullable|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',

            'start_date' => 'required|date',
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

    /**
     * Additional conditional validation
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->type === 'percentage' && $this->discount_value > 100) {
                $validator->errors()->add(
                    'discount_value',
                    'Percentage discount cannot exceed 100%.'
                );
            }
        });
    }

    /**
     * Optional: normalize input before validation
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('code')) {
            $this->merge([
                'code' => strtoupper($this->code),
            ]);
        }
    }
}
