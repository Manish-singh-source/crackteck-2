<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Set this to true for now; set to false if you want to add authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'customer_id' => 'required|integer',
            'shipping_address_id' => 'required|integer',
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address1' => 'required|string|max:255',
            'shipping_address2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_pincode' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_status' => 'required|in:pending,partial,completed,failed,refunded',
            'payment_method' => 'required|in:online,cod',

            'shipping_charges' => 'nullable|numeric|min:0',
            'packaging_charges' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'coupon_code' => 'nullable|numeric|min:0',

            'assigned_person_type' => 'nullable|in:delivery_man,engineer',
            'assigned_person_id' => 'nullable|integer',

            'order_status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,returned',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.product_name' => 'required|string',
            'items.*.product_sku' => 'required|string',
            'items.*.hsn_code' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_per_unit' => 'nullable|numeric|min:0',
            'items.*.tax_per_unit' => 'nullable|numeric|min:0',
            'items.*.line_total' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Email address is required.',
            'customer_id.required' => 'Customer ID is required.',
            'shipping_address_id.required' => 'Shipping address ID is required.',
            'shipping_first_name.required' => 'Shipping first name is required.',
            'shipping_last_name.required' => 'Shipping last name is required.',
            'shipping_phone.required' => 'Shipping phone number is required.',
            'shipping_address1.required' => 'Shipping address line 1 is required.',
            'shipping_city.required' => 'Shipping city is required.',
            'shipping_state.required' => 'Shipping state is required.',
            'shipping_pincode.required' => 'Shipping pincode is required.',
            'shipping_country.required' => 'Shipping country is required.',
            'payment_status.required' => 'Payment status is required.',
            'payment_method.required' => 'Payment method is required.',
            'items.required' => 'At least one item is required.',
            'items.*.product_id.required' => 'Product ID is required for each item.',
            'items.*.product_name.required' => 'Product name is required for each item.',
            'items.*.product_sku.required' => 'Product SKU is required for each item.',
            'items.*.quantity.required' => 'Quantity is required for each item.',
            'items.*.unit_price.required' => 'Unit price is required for each item.',
            'items.*.line_total.required' => 'Line total is required for each item.',
        ];
    }
}