<?php

namespace App\Http\Requests;

use App\Models\CashReceived;
use App\Models\Order;
use App\Models\ServiceRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCashReceivedRequest extends FormRequest
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
            // Either order_id OR service_request_id is required (mutually exclusive)
            'order_id' => ['nullable', 'integer', 'exists:orders,id'],
            'service_request_id' => ['nullable', 'integer', 'exists:service_requests,id'],
            
            // These are optional - will be derived from order/service request if not provided
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
            'staff_id' => ['nullable', 'integer', 'exists:staff,id'],
            'amount' => ['nullable', 'numeric', 'gte:0'],
            'status' => ['nullable', Rule::in([CashReceived::STATUS_CUSTOMER_PAID, CashReceived::STATUS_RECEIVED])],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $orderId = $this->input('order_id');
            $serviceRequestId = $this->input('service_request_id');

            // Check that either order_id or service_request_id is provided, but not both
            if ($orderId && $serviceRequestId) {
                $validator->errors()->add('order_id', 'Cannot provide both order_id and service_request_id. Please provide only one.');
                $validator->errors()->add('service_request_id', 'Cannot provide both order_id and service_request_id. Please provide only one.');
            }

            // Check that at least one of order_id or service_request_id is provided
            if (!$orderId && !$serviceRequestId) {
                $validator->errors()->add('order_id', 'Either order_id or service_request_id is required.');
                $validator->errors()->add('service_request_id', 'Either order_id or service_request_id is required.');
            }

            // If order_id is provided, validate it exists and get related data
            if ($orderId) {
                $order = Order::find($orderId);
                if (!$order) {
                    $validator->errors()->add('order_id', 'Order not found.');
                }
            }

            // If service_request_id is provided, validate it exists
            if ($serviceRequestId) {
                $serviceRequest = ServiceRequest::find($serviceRequestId);
                if (!$serviceRequest) {
                    $validator->errors()->add('service_request_id', 'Service request not found.');
                }
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'order_id.exists' => 'The selected order does not exist.',
            'service_request_id.exists' => 'The selected service request does not exist.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.gte' => 'Amount must be greater than or equal to 0.',
            'status.in' => 'Invalid status value.',
        ];
    }
}