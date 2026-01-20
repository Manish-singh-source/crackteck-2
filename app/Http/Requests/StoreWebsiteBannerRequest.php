<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWebsiteBannerRequest extends FormRequest
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
            'title'           => 'required|string|min:3|max:255',
            'image'           => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'type'            => 'required|in:website,promotional',
            'channel'         => 'required|in:website,mobile',
            'description'     => 'nullable|string|min:3',
            'promotion_type'  => 'nullable|in:discount,coupon,flash_sale,event',
            'discount_value'  => 'nullable|numeric|min:0',
            'discount_type'   => 'nullable|in:percentage,fixed',
            'promo_code'      => 'nullable|string|max:100',
            'link_url'        => 'nullable|url|max:255',
            'link_target'     => 'nullable|in:self,blank',
            'position'        => 'required|in:homepage,category,product,slider,checkout,cart',
            'display_order'   => [
                'required',
                'integer',
                'min:0',
                Rule::unique('website_banners', 'display_order')
                    ->where('type', $this->type)
                    ->whereNull('deleted_at'),
            ],
            'start_at'        => 'required|date',
            'end_at'          => 'required|date|after:start_at',
            'is_active'       => 'required|in:0,1',
            'metadata'        => 'nullable|json',
        ];
    }

    public function messages(): array
    {
        return [
            'display_order.unique' =>
            'This display order is already taken for this banner type. Please choose a different order.',
        ];
    }
}
