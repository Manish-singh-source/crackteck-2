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
            'vendor_id' => 'required|exists:vendors,id',
            'vendor_purchase_order_id' => 'required|exists:vendor_purchase_orders,id',
            'brand_id' => 'required|exists:brands,id',
            'parent_category_id' => 'required|exists:parent_categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'warehouse_id' => 'required|exists:warehouses,id',

            'product_name' => 'required|string|max:255',
            'hsn_code' => 'required|string|max:100',
            'sku' => 'required|string|max:100|unique:products,sku',
            'model_no' => 'required|string|max:100',

            'short_description' => 'required|string',
            'full_description' => 'nullable|string',
            'technical_specification' => 'nullable|string',
            'brand_warranty' => 'required|string|max:255',
            'company_warranty' => 'nullable|string|max:255',

            'weight' => 'required|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'shipping_time' => 'nullable|string|max:255',
            'cod' => 'required|in:yes,no',
            'installation' => 'required|in:yes,no',

            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'tax' => 'required|numeric|min:0|max:100',
            'final_price' => 'required|numeric|min:0',

            'stock_quantity' => 'required|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock,low_stock,scrap',

            'main_product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'datasheet_manual' => 'nullable|mimes:pdf|max:10240',

            'variations' => 'nullable|array',

            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'vendor_id.required' => 'Vendor is required.',
            'vendor_id.exists' => 'Selected vendor is invalid.',
            'vendor_purchase_order_id.required' => 'Vendor PO Number is required.',
            'vendor_purchase_order_id.exists' => 'Selected Vendor PO Number is invalid.',
            'brand_id.required' => 'Brand is required.',
            'brand_id.exists' => 'Selected brand is invalid.',
            'parent_category_id.required' => 'Parent category is required.',
            'parent_category_id.exists' => 'Selected parent category is invalid.',
            'sub_category_id.exists' => 'Selected sub category is invalid.',
            'warehouse_id.required' => 'Warehouse is required.',
            'warehouse_id.exists' => 'Selected warehouse is invalid.',
            'product_name.required' => 'Product name is required.',
            'product_name.max' => 'Product name may not be greater than 255 characters.',
            'hsn_code.required' => 'HSN Code is required.',
            'hsn_code.max' => 'HSN Code may not be greater than 100 characters.',
            'sku.required' => 'SKU is required.',
            'sku.unique' => 'This SKU already exists.',
            'sku.max' => 'SKU may not be greater than 100 characters.',
            'model_no.required' => 'Model number is required.',
            'model_no.max' => 'Model number may not be greater than 100 characters.',
            'short_description.required' => 'Short description is required.',
            'full_description.string' => 'Full description must be valid text.',
            'technical_specification.string' => 'Technical specification must be valid text.',
            'brand_warranty.required' => 'Brand warranty is required.',
            'brand_warranty.max' => 'Brand warranty may not be greater than 255 characters.',
            'company_warranty.max' => 'Company warranty may not be greater than 255 characters.',
            'weight.required' => 'Weight is required.',
            'weight.max' => 'Weight may not be greater than 255 characters.',
            'dimensions.max' => 'Dimensions may not be greater than 255 characters.',
            'shipping_time.max' => 'Shipping time may not be greater than 255 characters.',
            'cod.required' => 'Cash on Delivery selection is required.',
            'cod.in' => 'Cash on Delivery must be yes or no.',
            'installation.required' => 'Installation selection is required.',
            'installation.in' => 'Installation must be yes or no.',
            'cost_price.required' => 'Cost price is required.',
            'cost_price.numeric' => 'Cost price must be a number.',
            'cost_price.min' => 'Cost price must be at least 0.',
            'selling_price.required' => 'Selling price is required.',
            'selling_price.numeric' => 'Selling price must be a number.',
            'selling_price.min' => 'Selling price must be at least 0.',
            'discount_price.numeric' => 'Discount price must be a number.',
            'discount_price.min' => 'Discount price must be at least 0.',
            'tax.required' => 'Tax percentage is required.',
            'tax.numeric' => 'Tax must be a number.',
            'tax.min' => 'Tax must be at least 0%.',
            'tax.max' => 'Tax may not be greater than 100%.',
            'final_price.required' => 'Final price is required.',
            'final_price.numeric' => 'Final price must be a number.',
            'final_price.min' => 'Final price must be at least 0.',
            'stock_quantity.required' => 'Stock quantity is required.',
            'stock_quantity.integer' => 'Stock quantity must be an integer.',
            'stock_quantity.min' => 'Stock quantity must be at least 0.',
            'stock_status.required' => 'Stock status is required.',
            'stock_status.in' => 'Stock status must be a valid option.',
            'main_product_image.required' => 'Main product image is required.',
            'main_product_image.image' => 'Main product image must be an image file.',
            'main_product_image.mimes' => 'Main product image must be a JPEG, PNG, JPG, or GIF file.',
            'main_product_image.max' => 'Main product image must not be larger than 2MB.',
            'additional_product_images.*.image' => 'Additional images must be image files.',
            'additional_product_images.*.mimes' => 'Additional images must be JPEG, PNG, JPG, or GIF files.',
            'additional_product_images.*.max' => 'Additional images must not be larger than 2MB each.',
            'datasheet_manual.mimes' => 'Datasheet/Manual must be a PDF file.',
            'datasheet_manual.max' => 'Datasheet/Manual must not be larger than 10MB.',
            'status.required' => 'Product status is required.',
            'status.in' => 'Product status must be active or inactive.',
        ];
    }
}
