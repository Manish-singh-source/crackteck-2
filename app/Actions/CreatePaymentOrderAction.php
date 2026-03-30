<?php

namespace App\Actions;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Payment;
use App\Models\PaymentAttempt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreatePaymentOrderAction
{
    public function __construct(
        protected PaymentGatewayInterface $gateway,
    ) {}

    public function execute(Order $order): array
    {
        if ($order->payment_status === 'completed') {
            throw ValidationException::withMessages([
                'order' => ['This order has already been paid.'],
            ]);
        }

        return DB::transaction(function () use ($order) {
            $gatewayOrder = $this->gateway->createOrder($order);

            $payment = Payment::updateOrCreate(
                ['gateway_order_id' => $gatewayOrder['id']],
                [
                    'order_id' => $order->getKey(),
                    'gateway' => 'razorpay',
                    'amount' => $gatewayOrder['amount'],
                    'currency' => $gatewayOrder['currency'] ?? config('services.razorpay.currency', 'INR'),
                    'status' => $gatewayOrder['status'] ?? 'created',
                    'gateway_payload' => $gatewayOrder,
                ]
            );

            $attempt = PaymentAttempt::create([
                'payment_id' => $payment->getKey(),
                'gateway_order_id' => $gatewayOrder['id'],
                'amount' => $gatewayOrder['amount'],
                'currency' => $gatewayOrder['currency'] ?? config('services.razorpay.currency', 'INR'),
                'status' => $gatewayOrder['status'] ?? 'created',
                'receipt' => $gatewayOrder['receipt'] ?? $order->order_number,
                'gateway_payload' => $gatewayOrder,
            ]);

            OrderPayment::updateOrCreate(
                ['payment_id' => $gatewayOrder['id']],
                [
                    'order_id' => $order->getKey(),
                    'transaction_id' => null,
                    'payment_method' => 'online',
                    'payment_gateway' => 'razorpay',
                    'amount' => $order->total_amount,
                    'currency' => $payment->currency,
                    'status' => 'pending',
                    'response_data' => $gatewayOrder,
                ]
            );

            // after this i want invoice for this order and store in db for orders only after payment successfull
            // create table if not already exists for order_invoices 

            return [
                'payment' => $payment->fresh(),
                'attempt' => $attempt,
                'gateway_order' => $gatewayOrder,
            ];
        });
    }
}
