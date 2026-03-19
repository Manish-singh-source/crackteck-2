# Razorpay Integration in Laravel

A production-oriented guide to integrate Razorpay into a Laravel application using a maintainable, testable architecture.

## Goals

- Keep Razorpay-specific code isolated behind an application service.
- Create a Razorpay **order** on the server for every payment attempt.
- Verify the Checkout signature on the server before marking a payment as successful.
- Treat **webhooks** as the source of truth for asynchronous payment state changes.
- Make payment processing **idempotent** so duplicate callbacks or retries do not create duplicate orders or ledger entries.
- Support future gateways by keeping a gateway-agnostic domain layer.

---

## 1) Recommended architecture

Use a layered design:

### Domain layer
Owns business concepts and state transitions.

**Core models**
- `Order`
- `Payment`
- `PaymentAttempt`
- `WebhookEvent`

**Suggested payment states**
- `created`
- `pending`
- `authorized`
- `captured`
- `failed`
- `refunded`
- `partially_refunded`

### Application layer
Coordinates use-cases.

**Use-cases / actions**
- `CreatePaymentOrderAction`
- `VerifyCheckoutSignatureAction`
- `CapturePaymentAction`
- `ProcessWebhookAction`
- `RefundPaymentAction`

### Infrastructure layer
Contains Razorpay SDK integration, persistence details, queue jobs, HTTP controllers.

**Adapters**
- `RazorpayGateway` implements `PaymentGatewayInterface`
- `WebhookSignatureVerifier`
- `PaymentRepository`
- `WebhookEventRepository`

### Why this structure
It keeps controllers thin, business rules testable, and external-gateway code replaceable.

---

## 2) Official flow to design around

Razorpay’s recommended flow for Standard Checkout is:

1. Generate API keys in the dashboard.
2. Create an **order** on your server.
3. Pass the returned `order_id` to Checkout.
4. On success, verify the `razorpay_signature` on your server.
5. Track final payment state using dashboard checks, webhooks, or API polling.
6. Capture the payment if you are not using automatic capture. Razorpay documents that the capture API changes a payment from `authorized` to `captured`, and that uncaptured payments are not settled. Use webhooks plus API verification for reliability. These steps are part of the official Standard Checkout and Payments API flow.  
Sources:  
- https://razorpay.com/docs/payments/payment-gateway/web-integration/standard/integration-steps/  
- https://razorpay.com/docs/payments/payment-gateway/ecommerce-plugins/build-your-own/  
- https://razorpay.com/docs/api/payments/capture/  
- https://razorpay.com/docs/webhooks/

---

## 3) Package choice

Use Razorpay’s official PHP SDK:

```bash
composer require razorpay/razorpay
```

Official SDK repo:  
https://github.com/razorpay/razorpay-php

---

## 4) Environment configuration

Add these to `.env`:

```env
RAZORPAY_KEY_ID=rzp_test_xxxxxxxxxx
RAZORPAY_KEY_SECRET=xxxxxxxxxx
RAZORPAY_WEBHOOK_SECRET=xxxxxxxxxx
RAZORPAY_CURRENCY=INR
RAZORPAY_AUTO_CAPTURE=true
```

Create `config/services.php` entries:

```php
'razorpay' => [
    'key_id' => env('RAZORPAY_KEY_ID'),
    'key_secret' => env('RAZORPAY_KEY_SECRET'),
    'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
    'currency' => env('RAZORPAY_CURRENCY', 'INR'),
    'auto_capture' => filter_var(env('RAZORPAY_AUTO_CAPTURE', true), FILTER_VALIDATE_BOOL),
],
```

---

## 5) Database design

### 5.1 Payments table

Create a payments table separate from orders.

```php
php artisan make:migration create_payments_table
```

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('gateway')->default('razorpay');
            $table->string('gateway_order_id')->nullable()->unique();
            $table->string('gateway_payment_id')->nullable()->unique();
            $table->string('gateway_signature')->nullable();
            $table->unsignedBigInteger('amount'); // paise
            $table->string('currency', 10)->default('INR');
            $table->string('status')->default('created');
            $table->string('method')->nullable();
            $table->json('gateway_payload')->nullable();
            $table->timestamp('authorized_at')->nullable();
            $table->timestamp('captured_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
```

### 5.2 Payment attempts table

This is useful if a customer retries payment for the same order.

```php
php artisan make:migration create_payment_attempts_table
```

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->string('gateway_order_id')->unique();
            $table->unsignedBigInteger('amount');
            $table->string('currency', 10)->default('INR');
            $table->string('status')->default('created');
            $table->string('receipt')->nullable()->unique();
            $table->json('gateway_payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_attempts');
    }
};
```

### 5.3 Webhook events table

This makes webhook processing replay-safe and auditable.

```php
php artisan make:migration create_webhook_events_table
```

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webhook_events', function (Blueprint $table) {
            $table->id();
            $table->string('gateway')->default('razorpay');
            $table->string('event_id')->nullable()->unique();
            $table->string('event_type');
            $table->string('signature')->nullable();
            $table->string('status')->default('received');
            $table->timestamp('processed_at')->nullable();
            $table->json('headers')->nullable();
            $table->longText('payload');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_events');
    }
};
```

### Important design notes

- Store money in the **smallest currency unit**. For INR, that means **paise**.
- Never trust amount, order id, or order ownership from the client.
- Use unique constraints on `gateway_order_id`, `gateway_payment_id`, and webhook `event_id` to enforce idempotency.

---

## 6) Models

### `app/Models/Payment.php`

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'gateway',
        'gateway_order_id',
        'gateway_payment_id',
        'gateway_signature',
        'amount',
        'currency',
        'status',
        'method',
        'gateway_payload',
        'authorized_at',
        'captured_at',
        'failed_at',
        'refunded_at',
    ];

    protected $casts = [
        'gateway_payload' => 'array',
        'authorized_at' => 'datetime',
        'captured_at' => 'datetime',
        'failed_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
```

### `app/Models/PaymentAttempt.php`

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAttempt extends Model
{
    protected $fillable = [
        'payment_id',
        'gateway_order_id',
        'amount',
        'currency',
        'status',
        'receipt',
        'gateway_payload',
    ];

    protected $casts = [
        'gateway_payload' => 'array',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
```

### `app/Models/WebhookEvent.php`

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookEvent extends Model
{
    protected $fillable = [
        'gateway',
        'event_id',
        'event_type',
        'signature',
        'status',
        'processed_at',
        'headers',
        'payload',
    ];

    protected $casts = [
        'headers' => 'array',
        'processed_at' => 'datetime',
    ];
}
```

---

## 7) Service contract

Create a gateway contract so your app depends on an interface, not the Razorpay SDK directly.

### `app/Contracts/PaymentGatewayInterface.php`

```php
namespace App\Contracts;

interface PaymentGatewayInterface
{
    public function createOrder(array $payload): array;

    public function verifyCheckoutSignature(array $attributes): bool;

    public function fetchPayment(string $paymentId): array;

    public function capturePayment(string $paymentId, int $amount, string $currency = 'INR'): array;

    public function refundPayment(string $paymentId, int $amount = null, array $meta = []): array;
}
```

---

## 8) Razorpay adapter

### `app/Services/Payments/RazorpayGateway.php`

```php
namespace App\Services\Payments;

use App\Contracts\PaymentGatewayInterface;
use Razorpay\Api\Api;
use RuntimeException;

class RazorpayGateway implements PaymentGatewayInterface
{
    public function __construct(private readonly Api $api)
    {
    }

    public function createOrder(array $payload): array
    {
        return $this->api->order->create($payload)->toArray();
    }

    public function verifyCheckoutSignature(array $attributes): bool
    {
        $this->api->utility->verifyPaymentSignature($attributes);
        return true;
    }

    public function fetchPayment(string $paymentId): array
    {
        return $this->api->payment->fetch($paymentId)->toArray();
    }

    public function capturePayment(string $paymentId, int $amount, string $currency = 'INR'): array
    {
        return $this->api->payment->fetch($paymentId)->capture([
            'amount' => $amount,
            'currency' => $currency,
        ])->toArray();
    }

    public function refundPayment(string $paymentId, int $amount = null, array $meta = []): array
    {
        $payload = array_filter([
            'amount' => $amount,
            'notes' => $meta['notes'] ?? null,
            'receipt' => $meta['receipt'] ?? null,
        ], fn ($v) => ! is_null($v));

        return $this->api->payment->fetch($paymentId)->refund($payload)->toArray();
    }
}
```

### Service provider binding

### `app/Providers/AppServiceProvider.php`

```php
use App\Contracts\PaymentGatewayInterface;
use App\Services\Payments\RazorpayGateway;
use Razorpay\Api\Api;

public function register(): void
{
    $this->app->singleton(Api::class, function () {
        return new Api(
            config('services.razorpay.key_id'),
            config('services.razorpay.key_secret')
        );
    });

    $this->app->bind(PaymentGatewayInterface::class, RazorpayGateway::class);
}
```

---

## 9) Checkout order creation use-case

The client should never create a Razorpay order directly. Your Laravel backend should do it.

### `app/Actions/CreatePaymentOrderAction.php`

```php
namespace App\Actions;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentAttempt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CreatePaymentOrderAction
{
    public function __construct(private readonly PaymentGatewayInterface $gateway)
    {
    }

    public function execute(Order $order): array
    {
        return DB::transaction(function () use ($order) {
            $payment = Payment::firstOrCreate(
                ['order_id' => $order->id],
                [
                    'gateway' => 'razorpay',
                    'amount' => $order->payable_amount_paise,
                    'currency' => 'INR',
                    'status' => 'pending',
                ]
            );

            $receipt = 'ord_' . $order->id . '_' . Str::uuid();

            $gatewayOrder = $this->gateway->createOrder([
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                'receipt' => $receipt,
                'notes' => [
                    'order_id' => (string) $order->id,
                    'payment_id' => (string) $payment->id,
                ],
            ]);

            $payment->update([
                'gateway_order_id' => $gatewayOrder['id'],
                'gateway_payload' => $gatewayOrder,
            ]);

            PaymentAttempt::create([
                'payment_id' => $payment->id,
                'gateway_order_id' => $gatewayOrder['id'],
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                'status' => 'created',
                'receipt' => $receipt,
                'gateway_payload' => $gatewayOrder,
            ]);

            return [
                'payment' => $payment->fresh(),
                'gateway_order' => $gatewayOrder,
            ];
        });
    }
}
```

---

## 10) API endpoints

### Routes

```php
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\RazorpayWebhookController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/checkout/orders/{order}/razorpay', [CheckoutController::class, 'createRazorpayOrder']);
    Route::post('/checkout/razorpay/verify', [CheckoutController::class, 'verifyRazorpayPayment']);
    Route::post('/payments/{payment}/refund', [CheckoutController::class, 'refund']);
});

Route::post('/webhooks/razorpay', RazorpayWebhookController::class);
```

### Controller

```php
namespace App\Http\Controllers\Api;

use App\Actions\CreatePaymentOrderAction;
use App\Actions\VerifyCheckoutSignatureAction;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function createRazorpayOrder(Order $order, CreatePaymentOrderAction $action)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $result = $action->execute($order);

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'payment_id' => $result['payment']->id,
            'razorpay_order_id' => $result['gateway_order']['id'],
            'amount' => $result['payment']->amount,
            'currency' => $result['payment']->currency,
            'key' => config('services.razorpay.key_id'),
            'customer' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'contact' => auth()->user()->phone,
            ],
        ]);
    }

    public function verifyRazorpayPayment(Request $request, VerifyCheckoutSignatureAction $action)
    {
        $data = $request->validate([
            'payment_id' => ['required', 'integer', 'exists:payments,id'],
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_order_id' => ['required', 'string'],
            'razorpay_signature' => ['required', 'string'],
        ]);

        $payment = $action->execute($data);

        return response()->json([
            'success' => true,
            'status' => $payment->status,
        ]);
    }
}
```

---

## 11) Signature verification use-case

Razorpay’s docs say you must verify the Checkout signature on your server using your **server-side** secret, and that the signature should be built using your original `order_id` and the `razorpay_payment_id`. Do not trust the order id from the client alone.  
Source: https://razorpay.com/docs/payments/payment-gateway/web-integration/standard/integration-steps/

### `app/Actions/VerifyCheckoutSignatureAction.php`

```php
namespace App\Actions;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class VerifyCheckoutSignatureAction
{
    public function __construct(private readonly PaymentGatewayInterface $gateway)
    {
    }

    public function execute(array $data): Payment
    {
        return DB::transaction(function () use ($data) {
            /** @var Payment $payment */
            $payment = Payment::lockForUpdate()->findOrFail($data['payment_id']);

            if ($payment->status === 'captured') {
                return $payment;
            }

            if ($payment->gateway_order_id !== $data['razorpay_order_id']) {
                throw new RuntimeException('Gateway order mismatch.');
            }

            $this->gateway->verifyCheckoutSignature([
                'razorpay_order_id' => $payment->gateway_order_id,
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_signature' => $data['razorpay_signature'],
            ]);

            $gatewayPayment = $this->gateway->fetchPayment($data['razorpay_payment_id']);

            $payment->update([
                'gateway_payment_id' => $data['razorpay_payment_id'],
                'gateway_signature' => $data['razorpay_signature'],
                'status' => $gatewayPayment['status'] ?? 'authorized',
                'method' => $gatewayPayment['method'] ?? null,
                'gateway_payload' => $gatewayPayment,
                'authorized_at' => now(),
            ]);

            if (! config('services.razorpay.auto_capture') && ($gatewayPayment['status'] ?? null) === 'authorized') {
                $captured = $this->gateway->capturePayment(
                    $payment->gateway_payment_id,
                    $payment->amount,
                    $payment->currency
                );

                $payment->update([
                    'status' => $captured['status'] ?? 'captured',
                    'gateway_payload' => $captured,
                    'captured_at' => now(),
                ]);
            }

            return $payment->fresh();
        });
    }
}
```

---

## 12) Frontend checkout payload

Your frontend should call your Laravel API first, then open Razorpay Checkout using the values returned by Laravel.

Example JS payload:

```js
const options = {
  key: response.key,
  amount: response.amount,
  currency: response.currency,
  order_id: response.razorpay_order_id,
  name: 'Your App Name',
  description: `Order #${response.order_id}`,
  prefill: {
    name: response.customer.name,
    email: response.customer.email,
    contact: response.customer.contact,
  },
  handler: async function (rzpResponse) {
    await axios.post('/api/checkout/razorpay/verify', {
      payment_id: response.payment_id,
      razorpay_payment_id: rzpResponse.razorpay_payment_id,
      razorpay_order_id: rzpResponse.razorpay_order_id,
      razorpay_signature: rzpResponse.razorpay_signature,
    });
  }
};

const rzp = new Razorpay(options);
rzp.open();
```

---

## 13) Webhook handling

Razorpay recommends webhooks for near-real-time event notifications. For user-facing flows that need instant feedback, Razorpay recommends combining webhook processing with API verification. Razorpay also highlights idempotency and correct event ordering when validating and testing webhooks.  
Sources:  
- https://razorpay.com/docs/webhooks/  
- https://razorpay.com/docs/webhooks/validate-test/  
- https://razorpay.com/docs/payments/payment-gateway/flutter-integration/standard/integration-steps/

### Webhook design principles

- Verify webhook signature before processing.
- Persist the raw event first.
- Make the handler idempotent.
- Queue heavy processing.
- Never update business state twice for the same event.

### Controller

```php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessRazorpayWebhookJob;
use App\Models\WebhookEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RazorpayWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');
        $eventType = $request->input('event');
        $eventId = data_get($request->all(), 'payload.payment.entity.id')
            ?? data_get($request->all(), 'payload.order.entity.id')
            ?? sha1($payload);

        $record = WebhookEvent::firstOrCreate(
            ['event_id' => $eventId],
            [
                'gateway' => 'razorpay',
                'event_type' => $eventType ?? 'unknown',
                'signature' => $signature,
                'payload' => $payload,
                'headers' => $request->headers->all(),
                'status' => 'received',
            ]
        );

        if ($record->wasRecentlyCreated) {
            ProcessRazorpayWebhookJob::dispatch($record->id);
        }

        return response()->json(['ok' => true], Response::HTTP_OK);
    }
}
```

### Job

```php
namespace App\Jobs;

use App\Models\Payment;
use App\Models\WebhookEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use RuntimeException;

class ProcessRazorpayWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $webhookEventId)
    {
    }

    public function handle(Api $api): void
    {
        $event = WebhookEvent::findOrFail($this->webhookEventId);

        if ($event->status === 'processed') {
            return;
        }

        $signature = $event->signature;
        $secret = config('services.razorpay.webhook_secret');

        $api->utility->verifyWebhookSignature($event->payload, $signature, $secret);

        $body = json_decode($event->payload, true, flags: JSON_THROW_ON_ERROR);
        $eventType = $body['event'] ?? null;
        $entity = data_get($body, 'payload.payment.entity') ?? data_get($body, 'payload.order.entity');

        DB::transaction(function () use ($event, $eventType, $entity) {
            if ($eventType === 'payment.authorized' || $eventType === 'payment.captured' || $eventType === 'payment.failed') {
                $gatewayOrderId = $entity['order_id'] ?? null;
                $gatewayPaymentId = $entity['id'] ?? null;
                $status = $entity['status'] ?? null;

                $payment = Payment::where('gateway_order_id', $gatewayOrderId)
                    ->orWhere('gateway_payment_id', $gatewayPaymentId)
                    ->lockForUpdate()
                    ->first();

                if ($payment) {
                    $payment->update([
                        'gateway_payment_id' => $gatewayPaymentId ?? $payment->gateway_payment_id,
                        'status' => $status ?? $payment->status,
                        'method' => $entity['method'] ?? $payment->method,
                        'gateway_payload' => $entity,
                        'authorized_at' => $status === 'authorized' ? now() : $payment->authorized_at,
                        'captured_at' => $status === 'captured' ? now() : $payment->captured_at,
                        'failed_at' => $status === 'failed' ? now() : $payment->failed_at,
                    ]);
                }
            }

            $event->update([
                'status' => 'processed',
                'processed_at' => now(),
            ]);
        });
    }
}
```

---

## 14) Refunds

Design refunds as a dedicated use-case. Never bury refund logic inside controllers.

### `app/Actions/RefundPaymentAction.php`

```php
namespace App\Actions;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class RefundPaymentAction
{
    public function __construct(private readonly PaymentGatewayInterface $gateway)
    {
    }

    public function execute(Payment $payment, int $amount = null): array
    {
        return DB::transaction(function () use ($payment, $amount) {
            $refund = $this->gateway->refundPayment(
                $payment->gateway_payment_id,
                $amount,
                ['receipt' => 'refund_' . $payment->id . '_' . now()->timestamp]
            );

            $payment->update([
                'status' => $amount && $amount < $payment->amount ? 'partially_refunded' : 'refunded',
                'refunded_at' => now(),
            ]);

            return $refund;
        });
    }
}
```

---

## 15) Validation and security rules

1. Create Razorpay orders **only on the server**.
2. Never trust amount, currency, discount, or order ownership from the client.
3. Verify the Checkout signature on the server.
4. Verify the webhook signature on the server.
5. Use webhook processing plus API verification for resilient payment state updates.
6. Use HTTPS end-to-end.
7. Keep `key_secret` and webhook secret server-side only.
8. Use CSRF protection for web routes and token auth for API routes.
9. Implement idempotency for retries and duplicate callbacks.
10. Do not ship goods or activate services until payment is `captured`.

Razorpay’s docs explicitly call out signature verification, server-side order creation, tracking state via webhooks or APIs, and the need to capture authorized payments for settlement.  
Sources:  
- https://razorpay.com/docs/payments/payment-gateway/web-integration/standard/integration-steps/  
- https://razorpay.com/docs/api/payments/capture/  
- https://razorpay.com/docs/webhooks/

---

## 16) Capture strategy

### Recommended
Enable **automatic capture** in Razorpay if your business does not need a manual review step.

Razorpay documents both auto-capture settings and manual capture via API/dashboard. Payments that remain uncaptured are refunded after the configured window.  
Sources:  
- https://razorpay.com/docs/payments/payments/capture-settings/  
- https://razorpay.com/docs/api/payments/capture/  
- https://razorpay.com/docs/payments/payment-gateway/how-it-works/

### Use manual capture only if
- you need anti-fraud/manual review
- you validate inventory after authorization
- you need a deferred fulfillment workflow

If you use manual capture, keep a scheduled reconciliation job that finds `authorized` but uncaptured payments and captures or fails them intentionally.

---

## 17) Reconciliation strategy

Build a scheduled command to reconcile stale states.

### Command

```php
php artisan make:command ReconcileRazorpayPayments
```

### Behavior
- Find local payments stuck in `pending` or `authorized` for too long.
- Call `fetchPayment()` from Razorpay.
- Update local state.
- Alert on mismatches.

This protects you against missed callbacks, queue outages, and temporary webhook delivery issues.

---

## 18) Suggested test cases

### Happy path
- create local order
- create Razorpay order
- open Checkout
- complete payment
- verify signature
- process `payment.captured` webhook
- mark order paid

### Failure path
- payment failed in Checkout
- invalid signature
- webhook delivered twice
- webhook arrives before callback verification
- callback verification succeeds but webhook is delayed
- authorized but not captured within SLA
- partial refund

### Security path
- tampered amount from frontend
- tampered order id from frontend
- wrong webhook signature
- wrong checkout signature
- duplicate payment callback

---

## 19) What not to do

- Do not create orders on the frontend.
- Do not trust `razorpay_order_id` from the frontend without matching it to your own stored order.
- Do not mark orders paid solely from the browser callback.
- Do not depend on one signal only. Use callback verification for immediate UX and webhooks for durable state.
- Do not store money in decimal floats.
- Do not mix cart, order, and payment concerns in the same controller method.

---

## 20) Minimal implementation checklist

- [ ] Razorpay account created
- [ ] Test and Live keys configured
- [ ] Official SDK installed
- [ ] Server endpoint to create Razorpay order
- [ ] Checkout wired to backend-created order
- [ ] Signature verification endpoint implemented
- [ ] Webhook endpoint implemented
- [ ] Webhook signature verification implemented
- [ ] Queue worker configured for webhook jobs
- [ ] Automatic or manual capture strategy decided
- [ ] Refund flow implemented
- [ ] Reconciliation command scheduled
- [ ] Test-mode end-to-end flow verified
- [ ] Live-mode rollout checklist completed

---

## 21) Practical recommendation

For most Laravel ecommerce apps, this is the best balance:

- **Server-side Razorpay order creation**
- **Browser/app callback only for immediate UX**
- **Webhooks as the durable source of truth**
- **Automatic capture enabled** unless your business requires manual review
- **Dedicated payment tables** instead of overloading `orders`
- **Action classes + gateway interface** instead of fat controllers

That gives you a payment module that is easier to test, extend, and audit.

---

## 22) References

- Razorpay Standard Checkout integration steps: https://razorpay.com/docs/payments/payment-gateway/web-integration/standard/integration-steps/
- Razorpay “build your own” integration notes: https://razorpay.com/docs/payments/payment-gateway/ecommerce-plugins/build-your-own/
- Razorpay Payments API: https://razorpay.com/docs/api/payments/
- Razorpay Capture Payment API: https://razorpay.com/docs/api/payments/capture/
- Razorpay Webhooks overview: https://razorpay.com/docs/webhooks/
- Razorpay Webhook validation and testing: https://razorpay.com/docs/webhooks/validate-test/
- Razorpay capture settings: https://razorpay.com/docs/payments/payments/capture-settings/
- Official Razorpay PHP SDK: https://github.com/razorpay/razorpay-php
