<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // add policy logic if needed
    }

    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'status'          => 'required|in:active,inactive',
            'categories'      => 'required|array|min:1',
            'categories.*'    => 'exists:parent_categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'categories.required' => 'Please select at least one category.',
            'categories.min'      => 'Please select at least one category.',
        ];
    }
}
