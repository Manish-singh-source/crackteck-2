<?php

namespace App\Services\Payments;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Order;
use Razorpay\Api\Api;

class RazorpayGateway implements PaymentGatewayInterface
{
    public function __construct(
        protected Api $api,
    ) {}

    public function createOrder(Order $order, array $notes = []): array
    {
        $payload = [
            'amount' => $order->payable_amount_paise,
            'currency' => config('services.razorpay.currency', 'INR'),
            'receipt' => $order->order_number,
            'payment_capture' => config('services.razorpay.auto_capture', true) ? 1 : 0,
            'notes' => array_filter(array_merge([
                'order_id' => (string) $order->getKey(),
                'order_number' => $order->order_number,
                'source_platform' => $order->source_platform,
            ], $notes), static fn ($value) => $value !== null && $value !== ''),
        ];

        return $this->api->order->create($payload)->toArray();
    }

    public function fetchPayment(string $gatewayPaymentId): array
    {
        return $this->api->payment->fetch($gatewayPaymentId)->toArray();
    }

    public function verifyCheckoutSignature(string $orderId, string $paymentId, string $signature): void
    {
        $this->api->utility->verifyPaymentSignature([
            'razorpay_order_id' => $orderId,
            'razorpay_payment_id' => $paymentId,
            'razorpay_signature' => $signature,
        ]);
    }

    public function refundPayment(string $gatewayPaymentId, ?int $amount = null, array $notes = []): array
    {
        $payload = [];

        if ($amount !== null) {
            $payload['amount'] = $amount;
        }

        if ($notes !== []) {
            $payload['notes'] = $notes;
        }

        return $this->api->payment->fetch($gatewayPaymentId)->refund($payload)->toArray();
    }

    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        $secret = (string) config('services.razorpay.webhook_secret');

        if ($secret === '' || $signature === '') {
            return false;
        }

        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $signature);
    }
}
