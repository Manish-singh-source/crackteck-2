<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        $productId = $this->route('id');

        return [
            // Vendor & Purchase Info
            'vendor_name' => 'nullable|string|max:255',
            'po_number' => 'nullable|string|max:100',
            'invoice_number' => 'nullable|string|max:100',
            'invoice_pdf' => 'nullable|mimes:pdf|max:10240',
            'invoice_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'purchase_date' => 'nullable|date',
            'bill_due_date' => 'nullable|date',
            'bill_amount' => 'nullable|numeric|min:0',

            // Basic Product Information
            'product_name' => 'required|string|max:255',
            'hsn_code' => 'nullable|string|max:100',
            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'brand_id' => 'nullable|exists:brands,id',
            'model_no' => 'nullable|string|max:100',
            'serial_no' => 'nullable|string|max:100',
            'parent_category_id' => 'nullable|exists:parent_categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',

            // Product Details
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'technical_specification' => 'nullable|string',
            'brand_warranty' => 'nullable|string|max:255',

            // Pricing
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0|max:100',

            // Inventory Details
            'stock_quantity' => 'nullable|integer|min:0',
            'stock_status' => 'nullable|in:In Stock,Out of Stock',

            // Rack Details
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'warehouse_rack_id' => 'nullable|exists:warehouse_racks,id',
            'rack_zone_area' => 'nullable|string|max:100',
            'rack_no' => 'nullable|string|max:100',
            'level_no' => 'nullable|string|max:50',
            'position_no' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date',
            'rack_status' => 'nullable|in:Available,Blocked,Reserved',

            // Images & Media
            'main_product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'datasheet_manual' => 'nullable|mimes:pdf|max:10240',

            // Product Variations
            'color_options' => 'nullable|string|max:255',
            'size_options' => 'nullable|string|max:255',
            'length_options' => 'nullable|string|max:255',

            // Product Status
            'status' => 'nullable|in:Active,Inactive',
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
