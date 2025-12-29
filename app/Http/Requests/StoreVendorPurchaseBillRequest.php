<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorPurchaseBillRequest extends FormRequest
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
            'purchase_bill_no' => 'required|string|max:255|unique:vendor_purchase_bills,purchase_bill_no,'.$this->route('id'),
            'vendor_name' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:Pending,Complete,Reject,Partially Paid',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB max
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'purchase_bill_no.required' => 'Purchase Bill No. is required.',
            'purchase_bill_no.unique' => 'This Purchase Bill No. already exists.',
            'vendor_name.required' => 'Vendor Name is required.',
            'purchase_date.required' => 'Purchase Date is required.',
            'purchase_date.date' => 'Purchase Date must be a valid date.',
            'total_amount.required' => 'Total Amount is required.',
            'total_amount.numeric' => 'Total Amount must be a number.',
            'total_amount.min' => 'Total Amount must be greater than or equal to 0.',
            'payment_status.required' => 'Payment Status is required.',
            'payment_status.in' => 'Payment Status must be one of: Pending, Complete, Reject, Partially Paid.',
            'attachment.file' => 'Attachment must be a file.',
            'attachment.mimes' => 'Attachment must be a PDF, DOC, DOCX, JPG, JPEG, or PNG file.',
            'attachment.max' => 'Attachment size must not exceed 5MB.',
        ];
    }
}
