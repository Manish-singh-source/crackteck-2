<?php

namespace App\Jobs;

use App\Models\OrderPayment;
use App\Models\Payment;
use App\Models\WebhookEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class ProcessRazorpayWebhookJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $webhookEventId,
    ) {}

    public function handle(): void
    {
        $event = WebhookEvent::find($this->webhookEventId);

        if (! $event) {
            return;
        }

        $payload = json_decode($event->payload, true) ?: [];
        $entity = $payload['payload']['payment']['entity'] ?? [];

        DB::transaction(function () use ($event, $payload, $entity): void {
            $payment = Payment::query()
                ->when(
                    ! empty($entity['id']),
                    fn ($query) => $query->where('gateway_payment_id', $entity['id'])
                )
                ->when(
                    ! empty($entity['order_id']),
                    fn ($query) => $query->orWhere('gateway_order_id', $entity['order_id'])
                )
                ->first();

            if (! $payment) {
                $event->update([
                    'status' => 'ignored',
                    'processed_at' => now(),
                ]);

                return;
            }

            $status = $entity['status'] ?? $payment->status;

            $payment->forceFill([
                'gateway_payment_id' => $entity['id'] ?? $payment->gateway_payment_id,
                'gateway_order_id' => $entity['order_id'] ?? $payment->gateway_order_id,
                'status' => $event->event_type === 'refund.processed' ? 'refunded' : $status,
                'method' => $entity['method'] ?? $payment->method,
                'gateway_payload' => $payload,
                'authorized_at' => in_array($status, ['authorized', 'captured'], true) ? ($payment->authorized_at ?? now()) : $payment->authorized_at,
                'captured_at' => $status === 'captured' ? ($payment->captured_at ?? now()) : $payment->captured_at,
                'failed_at' => $status === 'failed' ? ($payment->failed_at ?? now()) : $payment->failed_at,
                'refunded_at' => $event->event_type === 'refund.processed' ? ($payment->refunded_at ?? now()) : $payment->refunded_at,
            ])->save();

            if ($payment->order) {
                $payment->order->update([
                    'payment_status' => match (true) {
                        $event->event_type === 'refund.processed' => 'refunded',
                        $status === 'captured' => 'completed',
                        $status === 'failed' => 'failed',
                        default => $payment->order->payment_status,
                    },
                ]);
            }

            OrderPayment::where('payment_id', $payment->gateway_order_id)
                ->orWhere('transaction_id', $payment->gateway_payment_id)
                ->update([
                    'transaction_id' => $payment->gateway_payment_id,
                    'payment_gateway' => 'razorpay',
                    'status' => match (true) {
                        $event->event_type === 'refund.processed' => 'refunded',
                        $status === 'captured' => 'completed',
                        $status === 'failed' => 'failed',
                        default => 'processing',
                    },
                    'processed_at' => now(),
                    'response_data' => $payload,
                ]);

            $event->update([
                'status' => 'processed',
                'processed_at' => now(),
            ]);
        });
    }
}
