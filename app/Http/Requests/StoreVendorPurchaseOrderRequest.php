<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorPurchaseOrderRequest extends FormRequest
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
            'po_number' => 'required|string|max:100',
            'invoice_number' => 'required|string|max:100',
            'invoice_pdf' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'purchase_date' => 'required|date',
            'po_amount_due_date' => 'required|date',
            'po_amount' => 'required|numeric|min:0',
            'po_amount_paid' => 'nullable|numeric|min:0',
            'po_status' => 'required|in:pending,approved,rejected,cancelled',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'po_amount_paid' => $this->po_amount_paid ?? 0,
        ]);
    }
}
