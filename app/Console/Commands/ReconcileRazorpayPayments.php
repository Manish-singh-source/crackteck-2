<?php

namespace App\Console\Commands;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Payment;
use Illuminate\Console\Command;

class ReconcileRazorpayPayments extends Command
{
    protected $signature = 'razorpay:reconcile-payments {--limit=50}';

    protected $description = 'Refresh Razorpay payment statuses for recently created or authorized payments.';

    public function handle(PaymentGatewayInterface $gateway): int
    {
        $payments = Payment::query()
            ->where('gateway', 'razorpay')
            ->whereIn('status', ['created', 'authorized'])
            ->whereNotNull('gateway_payment_id')
            ->latest()
            ->limit((int) $this->option('limit'))
            ->get();

        $updated = 0;

        foreach ($payments as $payment) {
            $gatewayPayment = $gateway->fetchPayment($payment->gateway_payment_id);
            $status = $gatewayPayment['status'] ?? $payment->status;

            $payment->update([
                'status' => $status,
                'method' => $gatewayPayment['method'] ?? $payment->method,
                'gateway_payload' => $gatewayPayment,
                'captured_at' => $status === 'captured' ? ($payment->captured_at ?? now()) : $payment->captured_at,
                'failed_at' => $status === 'failed' ? ($payment->failed_at ?? now()) : $payment->failed_at,
            ]);

            if ($payment->order) {
                $payment->order->update([
                    'payment_status' => match ($status) {
                        'captured' => 'completed',
                        'failed' => 'failed',
                        default => $payment->order->payment_status,
                    },
                ]);
            }

            $updated++;
        }

        $this->info("Reconciled {$updated} Razorpay payment(s).");

        return self::SUCCESS;
    }
}
