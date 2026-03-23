<?php

namespace App\Actions;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class VerifyCheckoutSignatureAction
{
    public function __construct(
        protected PaymentGatewayInterface $gateway,
    ) {}

    public function execute(Order $order, Payment $payment, string $gatewayPaymentId, string $signature): Payment
    {
        return DB::transaction(function () use ($order, $payment, $gatewayPaymentId, $signature) {
            $this->gateway->verifyCheckoutSignature($payment->gateway_order_id, $gatewayPaymentId, $signature);

            $gatewayPayment = $this->gateway->fetchPayment($gatewayPaymentId);
            $status = $gatewayPayment['status'] ?? 'authorized';

            $payment->forceFill([
                'gateway_payment_id' => $gatewayPaymentId,
                'gateway_signature' => $signature,
                'status' => $status,
                'method' => $gatewayPayment['method'] ?? null,
                'gateway_payload' => $gatewayPayment,
                'authorized_at' => in_array($status, ['authorized', 'captured'], true) ? now() : $payment->authorized_at,
                'captured_at' => $status === 'captured' ? now() : $payment->captured_at,
                'failed_at' => $status === 'failed' ? now() : $payment->failed_at,
            ])->save();

            $order->forceFill([
                'payment_status' => match ($status) {
                    'captured' => 'completed',
                    'failed' => 'failed',
                    default => 'pending',
                },
            ])->save();

            OrderPayment::where('payment_id', $payment->gateway_order_id)
                ->orWhere('transaction_id', $gatewayPaymentId)
                ->update([
                    'transaction_id' => $gatewayPaymentId,
                    'payment_gateway' => 'razorpay',
                    'status' => $status === 'captured' ? 'completed' : ($status === 'failed' ? 'failed' : 'processing'),
                    'processed_at' => now(),
                    'response_data' => $gatewayPayment,
                ]);

            return $payment->fresh();
        });
    }
}
