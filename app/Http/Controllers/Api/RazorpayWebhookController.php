<?php

namespace App\Http\Controllers\Api;

use App\Contracts\PaymentGatewayInterface;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessRazorpayWebhookJob;
use App\Models\WebhookEvent;
use Illuminate\Http\Request;

class RazorpayWebhookController extends Controller
{
    public function __construct(
        protected PaymentGatewayInterface $gateway,
    ) {}

    public function __invoke(Request $request)
    {
        $payload = $request->getContent();
        $signature = (string) $request->header('X-Razorpay-Signature', '');

        if (! $this->gateway->verifyWebhookSignature($payload, $signature)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Razorpay webhook signature.',
            ], 400);
        }

        $decodedPayload = $request->json()->all();

        $event = WebhookEvent::create([
            'gateway' => 'razorpay',
            'event_id' => $request->header('X-Razorpay-Event-Id'),
            'event_type' => $decodedPayload['event'] ?? 'unknown',
            'signature' => $signature,
            'status' => 'received',
            'headers' => $request->headers->all(),
            'payload' => $payload,
        ]);

        ProcessRazorpayWebhookJob::dispatch($event->getKey());

        return response()->json([
            'success' => true,
            'message' => 'Webhook received.',
        ], 202);
    }
}
