<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // add authorization if needed
    }

    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'image'           => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'description'     => 'nullable|string',
            'status'          => 'required|in:active,inactive',
            'categories'      => 'required|array|min:1',
            'categories.*'    => 'exists:parent_categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'categories.required'   => 'Please select at least one category.',
            'categories.min'        => 'Please select at least one category.',
            'categories.*.exists'   => 'One or more selected categories are invalid.',
        ];
    }
}
