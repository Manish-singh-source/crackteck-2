<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'vendor_id' => 'nullable|exists:vendors,id',
            'vendor_purchase_order_id' => 'nullable|exists:vendor_purchase_orders,id',
            'brand_id' => 'nullable|exists:brands,id',
            'parent_category_id' => 'nullable|exists:parent_categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',

            'product_name' => 'required|string|max:255',
            'hsn_code' => 'nullable|string|max:100',
            'sku' => 'required|string|max:100|unique:products,sku',
            'model_no' => 'nullable|string|max:100',

            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'technical_specification' => 'nullable|string',
            'brand_warranty' => 'nullable|string|max:255',
            'company_warranty' => 'nullable|string|max:255',

            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0|max:100',

            'stock_quantity' => 'nullable|integer|min:0',
            'stock_status' => 'nullable|in:in_stock,out_of_stock,low_stock,scrap',

            'main_product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'datasheet_manual' => 'nullable|mimes:pdf|max:10240',

            'variations' => 'nullable|array',

            'status' => 'nullable|in:active,inactive',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'product_name.required' => 'Product name is required.',
            'sku.required' => 'SKU is required.',
            'sku.unique' => 'This SKU already exists.',
            'main_product_image.image' => 'Main product image must be an image file.',
            'main_product_image.max' => 'Main product image must not be larger than 2MB.',
            'additional_product_images.*.image' => 'Additional images must be image files.',
            'additional_product_images.*.max' => 'Additional images must not be larger than 2MB each.',
            'invoice_pdf.mimes' => 'Invoice must be a PDF file.',
            'datasheet_manual.mimes' => 'Datasheet/Manual must be a PDF file.',
        ];
    }
}
