<?php

namespace App\Actions;

use App\Contracts\PaymentGatewayInterface;
use App\Models\OrderPayment;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RefundPaymentAction
{
    public function __construct(
        protected PaymentGatewayInterface $gateway,
    ) {}

    public function execute(Payment $payment, ?int $amount = null): array
    {
        if (! $payment->gateway_payment_id) {
            throw ValidationException::withMessages([
                'payment' => ['The payment cannot be refunded before a Razorpay payment id is stored.'],
            ]);
        }

        return DB::transaction(function () use ($payment, $amount) {
            $refund = $this->gateway->refundPayment($payment->gateway_payment_id, $amount, [
                'payment_id' => (string) $payment->getKey(),
                'order_id' => (string) $payment->order_id,
            ]);

            $payment->forceFill([
                'status' => 'refunded',
                'refunded_at' => now(),
                'gateway_payload' => array_merge($payment->gateway_payload ?? [], [
                    'refund' => $refund,
                ]),
            ])->save();

            if ($payment->order) {
                $payment->order->forceFill([
                    'payment_status' => 'refunded',
                ])->save();
            }

            $orderPayment = OrderPayment::where('payment_id', $payment->gateway_order_id)
                ->orWhere('transaction_id', $payment->gateway_payment_id)
                ->first();

            if ($orderPayment) {
                $orderPayment->update([
                    'status' => 'refunded',
                    'processed_at' => now(),
                    'response_data' => array_merge($orderPayment->response_data ?? [], ['refund' => $refund]),
                ]);
            }

            return $refund;
        });
    }
}
