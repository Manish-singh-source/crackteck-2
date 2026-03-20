<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreatePaymentOrderAction;
use App\Actions\VerifyCheckoutSignatureAction;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function createRazorpayOrder(Request $request, Order $order, CreatePaymentOrderAction $action)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:customers,id',
            'role_id' => 'required|in:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ((int) $order->customer_id !== (int) $request->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found for the authenticated customer.',
            ], 404);
        }

        try {
            $result = $action->execute($order);

            return response()->json([
                'success' => true,
                'message' => 'Razorpay order created successfully.',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'amount_paise' => $order->payable_amount_paise,
                    'currency' => $result['payment']->currency,
                    'razorpay' => [
                        'key_id' => config('services.razorpay.key_id'),
                        'order_id' => $result['gateway_order']['id'],
                        'amount' => $result['gateway_order']['amount'],
                        'currency' => $result['gateway_order']['currency'],
                    ],
                    'payment' => $result['payment'],
                    'attempt' => $result['attempt'],
                ],
            ]);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to create Razorpay order.',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    public function verifyRazorpayPayment(Request $request, VerifyCheckoutSignatureAction $action)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:customers,id',
            'role_id' => 'required|in:4',
            'order_id' => 'required|integer|exists:orders,id',
            'razorpay_order_id' => 'required|string|exists:payments,gateway_order_id',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $order = Order::findOrFail($request->integer('order_id'));

        if ((int) $order->customer_id !== (int) $request->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found for the authenticated customer.',
            ], 404);
        }

        $payment = Payment::where('order_id', $order->id)
            ->where('gateway_order_id', $request->string('razorpay_order_id')->toString())
            ->firstOrFail();

        try {
            $verifiedPayment = $action->execute(
                $order,
                $payment,
                $request->string('razorpay_payment_id')->toString(),
                $request->string('razorpay_signature')->toString(),
            );

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully.',
                'data' => [
                    'payment' => $verifiedPayment,
                    'order' => $order->fresh(),
                ],
            ]);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to verify the Razorpay payment.',
                'error' => $exception->getMessage(),
            ], 422);
        }
    }
}
