<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEcommerceProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Warehouse product reference
            'warehouse_product_id' => 'required|exists:products,id',

            // SKU validation - unique within e-commerce products
            'sku' => 'required|string|max:100|unique:ecommerce_products,sku',

            // SEO Fields
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'meta_product_url_slug' => 'nullable|string|max:255|unique:ecommerce_products,meta_product_url_slug',

            // Installation Options
            'installation_options' => 'nullable|array',
            'installation_options.*' => 'string|max:255',

            // Company Warranty
            // 'company_warranty' => 'nullable|string|max:255',

            // E-commerce specific descriptions
            'ecommerce_short_description' => 'nullable|string',
            'ecommerce_full_description' => 'nullable|string',
            'ecommerce_technical_specification' => 'nullable|string',

            // Inventory Management
            'min_order_qty' => 'nullable|integer|min:1',
            'max_order_qty' => 'nullable|integer|min:1|gte:min_order_qty',

            // Shipping Details
            'product_weight' => 'nullable|string|max:100',
            'product_dimensions' => 'nullable|string|max:255',
            'shipping_charges' => 'nullable|numeric|min:0',
            'shipping_class' => 'nullable|in:0,1,2,3,Light,Medium,Heavy,Fragile',

            // E-commerce flags
            'is_featured' => 'nullable|boolean',
            'is_best_seller' => 'nullable|boolean',
            'is_suggested' => 'nullable|boolean',
            'is_todays_deal' => 'nullable|boolean',

            // Product Tags – must be array after prepareForValidation()
            'product_tags' => 'nullable|array',
            'product_tags.*' => 'string|max:100',

            // Status
            'ecommerce_status' => 'nullable|in:active,inactive,draft',
        ];
    }

    public function messages(): array
    {
        return [
            'warehouse_product_id.required' => 'Please select a warehouse product.',
            'warehouse_product_id.exists' => 'Selected warehouse product does not exist.',
            'sku.required' => 'SKU is required.',
            'sku.unique' => 'Product with this SKU already exists.',
            'meta_product_url_slug.unique' => 'This URL slug is already taken.',
            'max_order_qty.gte' => 'Maximum order quantity must be greater than or equal to minimum order quantity.',
            'min_order_qty.min' => 'Minimum order quantity must be at least 1.',
            'shipping_charges.numeric' => 'Shipping charges must be a valid number.',
            'shipping_charges.min' => 'Shipping charges cannot be negative.',
        ];
    }

    protected function prepareForValidation()
    {
        // Convert checkbox values to boolean
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_best_seller' => $this->boolean('is_best_seller'),
            'is_suggested' => $this->boolean('is_suggested'),
            'is_todays_deal' => $this->boolean('is_todays_deal'),
        ]);

        // Default ecommerce_status
        if (! $this->has('ecommerce_status')) {
            $this->merge(['ecommerce_status' => 'active']);
        }

        // Default min_order_qty
        if (! $this->has('min_order_qty')) {
            $this->merge(['min_order_qty' => 1]);
        }

        // Default shipping_class
        if (! $this->has('shipping_class')) {
            $this->merge(['shipping_class' => 'Light']);
        }

        // Normalize shipping_class to DB enum codes (0..3)
        if ($this->has('shipping_class')) {
            $val = $this->input('shipping_class');

            $map = [
                // numeric codes as strings
                '0' => '0',
                '1' => '1',
                '2' => '2',
                '3' => '3',

                // numeric as ints
                0 => '0',
                1 => '1',
                2 => '2',
                3 => '3',

                // labels (case-insensitive)
                'light' => '0',
                'medium' => '1',
                'heavy' => '2',
                'fragile' => '3',
            ];

            $key = is_string($val) ? strtolower($val) : $val;

            if (isset($map[$key])) {
                $this->merge(['shipping_class' => $map[$key]]);
            }
        }

        // Convert product_tags JSON/string to array so it passes array validation
        if ($this->has('product_tags')) {
            $raw = $this->input('product_tags');

            if (is_string($raw)) {
                $decoded = json_decode($raw, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $tags = $decoded;
                } else {
                    // fallback: comma-separated string
                    $tags = array_map('trim', explode(',', $raw));
                }
            } elseif (is_array($raw)) {
                $tags = $raw;
            } else {
                $tags = [];
            }

            $tags = array_values(array_filter($tags));
            $this->merge(['product_tags' => $tags]);
        }
    }
}
