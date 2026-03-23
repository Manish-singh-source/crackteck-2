<?php

namespace App\Http\Controllers\Api;

use App\Actions\RefundPaymentAction;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PaymentRefundController extends Controller
{
    public function __invoke(Request $request, Payment $payment, RefundPaymentAction $action)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:customers,id',
            'role_id' => 'required|in:4',
            'amount_paise' => 'nullable|integer|min:1|max:' . $payment->amount,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        if (! $payment->order || (int) $payment->order->customer_id !== (int) $request->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found for the authenticated customer.',
            ], 404);
        }

        try {
            $refund = $action->execute($payment, $request->integer('amount_paise') ?: null);

            return response()->json([
                'success' => true,
                'message' => 'Refund initiated successfully.',
                'data' => [
                    'payment' => $payment->fresh(),
                    'refund' => $refund,
                ],
            ]);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to initiate the refund.',
                'error' => $exception->getMessage(),
            ], 422);
        }
    }
}
