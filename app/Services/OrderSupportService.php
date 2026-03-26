<?php

namespace App\Services;

use App\Mail\OrderStatusNotificationMail;
use App\Models\Order;
use App\Models\Payment;
use App\Models\RefundBankDetail;
use App\Models\ReturnOrder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class OrderSupportService
{
    public function canCustomerCancel(Order $order): bool
    {
        return in_array($order->status, [
            Order::STATUS_PENDING,
            Order::STATUS_ADMIN_APPROVED,
            Order::STATUS_ASSIGNED_DELIVERY_MAN,
        ], true) && ! $order->shipped_at;
    }

    public function isDelivered(Order $order): bool
    {
        return $order->status === Order::STATUS_DELIVERED;
    }

    public function isCod(Order $order): bool
    {
        if (($order->payment_method ?? null) === 'cod') {
            return true;
        }

        return $order->orderPayments()->where('payment_method', 'cod')->exists();
    }

    public function isPrepaid(Order $order): bool
    {
        return ! $this->isCod($order);
    }

    public function getRefundablePayment(Order $order): ?Payment
    {
        return $order->payments()
            ->where('gateway', 'razorpay')
            ->whereNotNull('gateway_payment_id')
            ->whereIn('status', ['authorized', 'captured'])
            ->latest('id')
            ->first();
    }

    public function getRefundBankDetail(Order $order, ?ReturnOrder $returnOrder = null): ?RefundBankDetail
    {
        return RefundBankDetail::query()
            ->where('order_id', $order->id)
            ->when($returnOrder, fn ($query) => $query->where('return_order_id', $returnOrder->id))
            ->latest('id')
            ->first();
    }

    public function bankDetailsFormUrl(Order $order, string $context, ?ReturnOrder $returnOrder = null): string
    {
        return URL::temporarySignedRoute(
            'order.refund-bank-details.form',
            now()->addDays(7),
            [
                'order' => $order->id,
                'context' => $context,
                'return_order' => $returnOrder?->id,
            ]
        );
    }

    public function notifyCustomer(?string $email, string $subject, string $heading, string $message, ?string $actionText = null, ?string $actionUrl = null): void
    {
        if (! $email) {
            return;
        }

        Mail::to($email)->send(new OrderStatusNotificationMail($subject, $heading, $message, $actionText, $actionUrl));
    }

    public function notifyAdmin(string $subject, string $heading, string $message, ?string $actionText = null, ?string $actionUrl = null): void
    {
        $adminEmail = env('ADMIN_NOTIFICATION_EMAIL', config('mail.from.address'));

        if (! $adminEmail) {
            return;
        }

        Mail::to($adminEmail)->send(new OrderStatusNotificationMail($subject, $heading, $message, $actionText, $actionUrl));
    }
}
