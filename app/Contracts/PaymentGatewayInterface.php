<?php

namespace App\Contracts;

use App\Models\Order;

interface PaymentGatewayInterface
{
    public function createOrder(Order $order, array $notes = []): array;

    public function fetchPayment(string $gatewayPaymentId): array;

    public function verifyCheckoutSignature(string $orderId, string $paymentId, string $signature): void;

    public function refundPayment(string $gatewayPaymentId, ?int $amount = null, array $notes = []): array;

    public function verifyWebhookSignature(string $payload, string $signature): bool;
}
