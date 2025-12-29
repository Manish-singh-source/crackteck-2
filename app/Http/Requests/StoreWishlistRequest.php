<?php

namespace App\Http\Requests;

use App\Models\Wishlist;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreWishlistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only authenticated users can add to wishlist
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ecommerce_product_id' => [
                'required',
                'integer',
                'exists:ecommerce_products,id',
                function ($attribute, $value, $fail) {
                    // Check if product is already in user's wishlist
                    if (Wishlist::isInWishlist(Auth::id(), $value)) {
                        $fail('This product is already in your wishlist.');
                    }
                },
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ecommerce_product_id.required' => 'Product ID is required.',
            'ecommerce_product_id.integer' => 'Product ID must be a valid number.',
            'ecommerce_product_id.exists' => 'The selected product does not exist or is not available.',
        ];
    }

    /**
     * Handle a failed authorization attempt.
     */
    protected function failedAuthorization()
    {
        if (request()->expectsJson()) {
            abort(response()->json([
                'success' => false,
                'message' => 'Please login to add products to your wishlist.',
            ], 401));
        }

        abort(401, 'Please login to add products to your wishlist.');
    }
}
