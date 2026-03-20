# Razorpay Integration in Laravel

> A production-oriented guide to integrate Razorpay into a Laravel application using a maintainable, testable, JWT-compatible architecture.

---

## Table of Contents

1. [Goals](#goals)
2. [Recommended Architecture](#1-recommended-architecture)
3. [Official Flow](#2-official-flow-to-design-around)
4. [Package Choice](#3-package-choice)
5. [Environment Configuration](#4-environment-configuration)
6. [Database Design](#5-database-design)
7. [Models](#6-models)
8. [Service Contract](#7-service-contract)
9. [Razorpay Adapter](#8-razorpay-adapter)
10. [Checkout Order Creation](#9-checkout-order-creation-use-case)
11. [API Endpoints](#10-api-endpoints)
12. [Signature Verification](#11-signature-verification-use-case)
13. [Frontend Checkout Payload](#12-frontend-checkout-payload)
14. [Webhook Handling](#13-webhook-handling)
15. [Refunds](#14-refunds)
16. [Validation & Security Rules](#15-validation-and-security-rules)
17. [Capture Strategy](#16-capture-strategy)
18. [Reconciliation Strategy](#17-reconciliation-strategy)
19. [Test Cases](#18-suggested-test-cases)
20. [What Not To Do](#19-what-not-to-do)
21. [Implementation Checklist](#20-minimal-implementation-checklist)
22. [Practical Recommendation](#21-practical-recommendation)
23. [References](#22-references)

---

## Goals

- Keep Razorpay-specific code isolated behind an application service.
- Create a Razorpay **order** on the server for every payment attempt.
- Verify the Checkout signature on the server before marking a payment as successful.
- Treat **webhooks** as the source of truth for asynchronous payment state changes.
- Make payment processing **idempotent** — duplicate callbacks or retries do not create duplicate orders or ledger entries.
- Support future gateways by keeping a gateway-agnostic domain layer.
- Support both **web (session/cookie)** and **API (JWT token)** consumers from the same endpoints.

---

## Authentication: Web vs. API (JWT)

This integration supports two authentication modes on the same routes:

| Consumer | Auth Driver | Token Location |
|---|---|---|
| Web (browser SPA) | `sanctum` (cookie/session) | Cookie or Bearer header |
| API / Mobile | `jwt` via `tymon/jwt-auth` | `Authorization: Bearer <token>` |

### Install JWT Auth

```bash
composer require tymon/jwt-auth
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

Add to `.env`:

```env
JWT_SECRET=your_generated_secret
JWT_TTL=60
JWT_REFRESH_TTL=20160
```

Update `config/auth.php`:

```php
'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

Implement `JWTSubject` on your `User` model:

```php
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
```

### Obtaining a JWT Token

```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "secret"
}
```

Response:

```json
{
  "access_token": "eyJ0eXAiOiJKV1...",
  "token_type": "bearer",
  "expires_in": 3600
}
```

Pass the token in subsequent requests:

```http
Authorization: Bearer eyJ0eXAiOiJKV1...
```

---

## 1) Recommended Architecture

A layered design keeps controllers thin, business rules testable, and gateway code replaceable.

### Domain Layer
Owns business concepts and state transitions.

**Core Models:** `Order`, `Payment`, `PaymentAttempt`, `WebhookEvent`

**Payment States:**

| State | Description |
|---|---|
| `created` | Payment record initialised |
| `pending` | Awaiting customer action |
| `authorized` | Card authorised, not yet captured |
| `captured` | Funds captured and settled |
| `failed` | Payment declined or errored |
| `refunded` | Fully refunded |
| `partially_refunded` | Partial amount refunded |

### Application Layer
Coordinates use-cases / actions:
- `CreatePaymentOrderAction`
- `VerifyCheckoutSignatureAction`
- `CapturePaymentAction`
- `ProcessWebhookAction`
- `RefundPaymentAction`

### Infrastructure Layer
Contains SDK integration, persistence, queue jobs, HTTP controllers:
- `RazorpayGateway` implements `PaymentGatewayInterface`
- `WebhookSignatureVerifier`
- `PaymentRepository`
- `WebhookEventRepository`

---

## 2) Official Flow to Design Around

Razorpay's recommended Standard Checkout flow:

1. Generate API keys in the Razorpay dashboard.
2. Create an **order** on your server (never on the client).
3. Pass the returned `order_id` to Razorpay Checkout.
4. On success, verify `razorpay_signature` on your server.
5. Track final payment state via webhooks, dashboard, or API polling.
6. Capture the payment if automatic capture is disabled (uncaptured payments are not settled).

**Sources:**
- [Standard Checkout Integration Steps](https://razorpay.com/docs/payments/payment-gateway/web-integration/standard/integration-steps/)
- [Build Your Own Integration](https://razorpay.com/docs/payments/payment-gateway/ecommerce-plugins/build-your-own/)
- [Capture Payment API](https://razorpay.com/docs/api/payments/capture/)
- [Webhooks Overview](https://razorpay.com/docs/webhooks/)

---

## 3) Package Choice

Use Razorpay's official PHP SDK:

```bash
composer require razorpay/razorpay
```

Official SDK: [https://github.com/razorpay/razorpay-php](https://github.com/razorpay/razorpay-php)

---

## 4) Environment Configuration

Add to `.env`:

```env
RAZORPAY_KEY_ID=rzp_test_xxxxxxxxxx
RAZORPAY_KEY_SECRET=xxxxxxxxxx
RAZORPAY_WEBHOOK_SECRET=xxxxxxxxxx
RAZORPAY_CURRENCY=INR
RAZORPAY_AUTO_CAPTURE=true
```

`config/services.php`:

```php
'razorpay' => [
    'key_id'         => env('RAZORPAY_KEY_ID'),
    'key_secret'     => env('RAZORPAY_KEY_SECRET'),
    'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
    'currency'       => env('RAZORPAY_CURRENCY', 'INR'),
    'auto_capture'   => filter_var(env('RAZORPAY_AUTO_CAPTURE', true), FILTER_VALIDATE_BOOL),
],
```

---

## 5) Database Design

### 5.1 Payments Table

```bash
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
            $table->unsignedBigInteger('amount'); // in paise
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

### 5.2 Payment Attempts Table

```bash
php artisan make:migration create_payment_attempts_table
```

```php
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

### 5.3 Webhook Events Table

```bash
php artisan make:migration create_webhook_events_table
```

```php
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

> **Design Notes:**
> - Store money in the **smallest currency unit** (paise for INR).
> - Never trust amount, order ID, or ownership from the client.
> - Unique constraints on `gateway_order_id`, `gateway_payment_id`, and `event_id` enforce idempotency.

---

## 6) Models

### `app/Models/Payment.php`

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'gateway', 'gateway_order_id', 'gateway_payment_id',
        'gateway_signature', 'amount', 'currency', 'status', 'method',
        'gateway_payload', 'authorized_at', 'captured_at', 'failed_at', 'refunded_at',
    ];

    protected $casts = [
        'gateway_payload' => 'array',
        'authorized_at'   => 'datetime',
        'captured_at'     => 'datetime',
        'failed_at'       => 'datetime',
        'refunded_at'     => 'datetime',
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
        'payment_id', 'gateway_order_id', 'amount',
        'currency', 'status', 'receipt', 'gateway_payload',
    ];

    protected $casts = ['gateway_payload' => 'array'];

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
        'gateway', 'event_id', 'event_type', 'signature',
        'status', 'processed_at', 'headers', 'payload',
    ];

    protected $casts = [
        'headers'      => 'array',
        'processed_at' => 'datetime',
    ];
}
```

---

## 7) Service Contract

`app/Contracts/PaymentGatewayInterface.php`

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

## 8) Razorpay Adapter

### `app/Services/Payments/RazorpayGateway.php`

```php
namespace App\Services\Payments;

use App\Contracts\PaymentGatewayInterface;
use Razorpay\Api\Api;

class RazorpayGateway implements PaymentGatewayInterface
{
    public function __construct(private readonly Api $api) {}

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
        return $this->api->payment->fetch($paymentId)
            ->capture(['amount' => $amount, 'currency' => $currency])
            ->toArray();
    }

    public function refundPayment(string $paymentId, int $amount = null, array $meta = []): array
    {
        $payload = array_filter([
            'amount'  => $amount,
            'notes'   => $meta['notes'] ?? null,
            'receipt' => $meta['receipt'] ?? null,
        ], fn($v) => !is_null($v));

        return $this->api->payment->fetch($paymentId)->refund($payload)->toArray();
    }
}
```

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

## 9) Checkout Order Creation Use-Case

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
    public function __construct(private readonly PaymentGatewayInterface $gateway) {}

    public function execute(Order $order): array
    {
        return DB::transaction(function () use ($order) {
            $payment = Payment::firstOrCreate(
                ['order_id' => $order->id],
                [
                    'gateway'  => 'razorpay',
                    'amount'   => $order->payable_amount_paise,
                    'currency' => 'INR',
                    'status'   => 'pending',
                ]
            );

            $receipt = 'ord_' . $order->id . '_' . Str::uuid();

            $gatewayOrder = $this->gateway->createOrder([
                'amount'   => $payment->amount,
                'currency' => $payment->currency,
                'receipt'  => $receipt,
                'notes'    => [
                    'order_id'   => (string) $order->id,
                    'payment_id' => (string) $payment->id,
                ],
            ]);

            $payment->update([
                'gateway_order_id' => $gatewayOrder['id'],
                'gateway_payload'  => $gatewayOrder,
            ]);

            PaymentAttempt::create([
                'payment_id'       => $payment->id,
                'gateway_order_id' => $gatewayOrder['id'],
                'amount'           => $payment->amount,
                'currency'         => $payment->currency,
                'status'           => 'created',
                'receipt'          => $receipt,
                'gateway_payload'  => $gatewayOrder,
            ]);

            return [
                'payment'       => $payment->fresh(),
                'gateway_order' => $gatewayOrder,
            ];
        });
    }
}
```

---

## 10) API Endpoints

### Routes

Supports both `auth:sanctum` (web/SPA) and `auth:api` (JWT) guards via a combined middleware:

```php
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\RazorpayWebhookController;

// Authenticated routes — accepts both Sanctum session and JWT Bearer token
Route::middleware(['auth:sanctum,api'])->group(function () {
    Route::post('/checkout/orders/{order}/razorpay', [CheckoutController::class, 'createRazorpayOrder']);
    Route::post('/checkout/razorpay/verify',         [CheckoutController::class, 'verifyRazorpayPayment']);
    Route::post('/payments/{payment}/refund',         [CheckoutController::class, 'refund']);
});

// Webhook — no auth, signature-verified instead
Route::post('/webhooks/razorpay', RazorpayWebhookController::class);
```

> **JWT clients** send `Authorization: Bearer <token>` — the `api` guard handles this.  
> **Web/SPA clients** use Sanctum cookies or `Authorization: Bearer <sanctum-token>`.

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
            'success'           => true,
            'order_id'          => $order->id,
            'payment_id'        => $result['payment']->id,
            'razorpay_order_id' => $result['gateway_order']['id'],
            'amount'            => $result['payment']->amount,
            'currency'          => $result['payment']->currency,
            'key'               => config('services.razorpay.key_id'),
            'customer'          => [
                'name'    => auth()->user()->name,
                'email'   => auth()->user()->email,
                'contact' => auth()->user()->phone,
            ],
        ]);
    }

    public function verifyRazorpayPayment(Request $request, VerifyCheckoutSignatureAction $action)
    {
        $data = $request->validate([
            'payment_id'          => ['required', 'integer', 'exists:payments,id'],
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_order_id'   => ['required', 'string'],
            'razorpay_signature'  => ['required', 'string'],
        ]);

        $payment = $action->execute($data);

        return response()->json([
            'success' => true,
            'status'  => $payment->status,
        ]);
    }
}
```

### Example API Request (JWT)

```http
POST /api/checkout/orders/42/razorpay
Authorization: Bearer eyJ0eXAiOiJKV1...
Content-Type: application/json
```

Response:

```json
{
  "success": true,
  "order_id": 42,
  "payment_id": 7,
  "razorpay_order_id": "order_XXXXXXXXXXXXXXXX",
  "amount": 49900,
  "currency": "INR",
  "key": "rzp_test_xxxxxxxxxx",
  "customer": {
    "name": "John Doe",
    "email": "john@example.com",
    "contact": "9876543210"
  }
}
```

---

## 11) Signature Verification Use-Case

> Verify using your **server-side** secret. Never trust the order ID from the client alone.  
> Source: [Standard Checkout Docs](https://razorpay.com/docs/payments/payment-gateway/web-integration/standard/integration-steps/)

### `app/Actions/VerifyCheckoutSignatureAction.php`

```php
namespace App\Actions;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class VerifyCheckoutSignatureAction
{
    public function __construct(private readonly PaymentGatewayInterface $gateway) {}

    public function execute(array $data): Payment
    {
        return DB::transaction(function () use ($data) {
            $payment = Payment::lockForUpdate()->findOrFail($data['payment_id']);

            if ($payment->status === 'captured') {
                return $payment;
            }

            if ($payment->gateway_order_id !== $data['razorpay_order_id']) {
                throw new RuntimeException('Gateway order mismatch.');
            }

            $this->gateway->verifyCheckoutSignature([
                'razorpay_order_id'   => $payment->gateway_order_id,
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_signature'  => $data['razorpay_signature'],
            ]);

            $gatewayPayment = $this->gateway->fetchPayment($data['razorpay_payment_id']);

            $payment->update([
                'gateway_payment_id' => $data['razorpay_payment_id'],
                'gateway_signature'  => $data['razorpay_signature'],
                'status'             => $gatewayPayment['status'] ?? 'authorized',
                'method'             => $gatewayPayment['method'] ?? null,
                'gateway_payload'    => $gatewayPayment,
                'authorized_at'      => now(),
            ]);

            if (!config('services.razorpay.auto_capture') && ($gatewayPayment['status'] ?? null) === 'authorized') {
                $captured = $this->gateway->capturePayment(
                    $payment->gateway_payment_id,
                    $payment->amount,
                    $payment->currency
                );

                $payment->update([
                    'status'          => $captured['status'] ?? 'captured',
                    'gateway_payload' => $captured,
                    'captured_at'     => now(),
                ]);
            }

            return $payment->fresh();
        });
    }
}
```

---

## 12) Frontend Checkout Payload

Your frontend calls the Laravel API first, then opens Razorpay Checkout with the returned values.

### Web / SPA (Axios + Sanctum)

```js
// Step 1: Create Razorpay order via Laravel API
const { data: response } = await axios.post(
  `/api/checkout/orders/${orderId}/razorpay`
);

// Step 2: Open Razorpay Checkout
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
      payment_id:          response.payment_id,
      razorpay_payment_id: rzpResponse.razorpay_payment_id,
      razorpay_order_id:   rzpResponse.razorpay_order_id,
      razorpay_signature:  rzpResponse.razorpay_signature,
    });
  }
};

const rzp = new Razorpay(options);
rzp.open();
```

### Mobile / Flutter (JWT Bearer)

```dart
// Step 1: Create Razorpay order
final createRes = await dio.post(
  '/api/checkout/orders/$orderId/razorpay',
  options: Options(headers: {'Authorization': 'Bearer $jwtToken'}),
);
final data = createRes.data;

// Step 2: Open Razorpay checkout, then verify
final verifyRes = await dio.post(
  '/api/checkout/razorpay/verify',
  data: {
    'payment_id':          data['payment_id'],
    'razorpay_payment_id': rzpPaymentId,
    'razorpay_order_id':   rzpOrderId,
    'razorpay_signature':  rzpSignature,
  },
  options: Options(headers: {'Authorization': 'Bearer $jwtToken'}),
);
```

---

## 13) Webhook Handling

> Razorpay recommends webhooks for near-real-time event notifications, and emphasises idempotency and correct event ordering.  
> Sources: [Webhooks](https://razorpay.com/docs/webhooks/) | [Validate & Test](https://razorpay.com/docs/webhooks/validate-test/)

### Design Principles

- Verify webhook signature **before** processing.
- Persist the raw event **first**.
- Make the handler **idempotent**.
- Queue heavy processing.
- Never update business state twice for the same event.

> Webhook endpoints do **not** use JWT or Sanctum auth — they are verified by Razorpay's HMAC-SHA256 signature header (`X-Razorpay-Signature`). Exclude the webhook route from `auth` middleware and CSRF protection.

### Controller

```php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessRazorpayWebhookJob;
use App\Models\WebhookEvent;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RazorpayWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $payload   = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');
        $eventType = $request->input('event');
        $eventId   = data_get($request->all(), 'payload.payment.entity.id')
            ?? data_get($request->all(), 'payload.order.entity.id')
            ?? sha1($payload);

        $record = WebhookEvent::firstOrCreate(
            ['event_id' => $eventId],
            [
                'gateway'    => 'razorpay',
                'event_type' => $eventType ?? 'unknown',
                'signature'  => $signature,
                'payload'    => $payload,
                'headers'    => $request->headers->all(),
                'status'     => 'received',
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

class ProcessRazorpayWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $webhookEventId) {}

    public function handle(Api $api): void
    {
        $event = WebhookEvent::findOrFail($this->webhookEventId);

        if ($event->status === 'processed') return;

        $api->utility->verifyWebhookSignature(
            $event->payload,
            $event->signature,
            config('services.razorpay.webhook_secret')
        );

        $body      = json_decode($event->payload, true, flags: JSON_THROW_ON_ERROR);
        $eventType = $body['event'] ?? null;
        $entity    = data_get($body, 'payload.payment.entity')
            ?? data_get($body, 'payload.order.entity');

        DB::transaction(function () use ($event, $eventType, $entity) {
            if (in_array($eventType, ['payment.authorized', 'payment.captured', 'payment.failed'])) {
                $payment = Payment::where('gateway_order_id', $entity['order_id'] ?? null)
                    ->orWhere('gateway_payment_id', $entity['id'] ?? null)
                    ->lockForUpdate()
                    ->first();

                if ($payment) {
                    $status = $entity['status'] ?? null;
                    $payment->update([
                        'gateway_payment_id' => $entity['id'] ?? $payment->gateway_payment_id,
                        'status'             => $status ?? $payment->status,
                        'method'             => $entity['method'] ?? $payment->method,
                        'gateway_payload'    => $entity,
                        'authorized_at'      => $status === 'authorized' ? now() : $payment->authorized_at,
                        'captured_at'        => $status === 'captured'   ? now() : $payment->captured_at,
                        'failed_at'          => $status === 'failed'     ? now() : $payment->failed_at,
                    ]);
                }
            }

            $event->update(['status' => 'processed', 'processed_at' => now()]);
        });
    }
}
```

---

## 14) Refunds

### `app/Actions/RefundPaymentAction.php`

```php
namespace App\Actions;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class RefundPaymentAction
{
    public function __construct(private readonly PaymentGatewayInterface $gateway) {}

    public function execute(Payment $payment, int $amount = null): array
    {
        return DB::transaction(function () use ($payment, $amount) {
            $refund = $this->gateway->refundPayment(
                $payment->gateway_payment_id,
                $amount,
                ['receipt' => 'refund_' . $payment->id . '_' . now()->timestamp]
            );

            $payment->update([
                'status'      => ($amount && $amount < $payment->amount) ? 'partially_refunded' : 'refunded',
                'refunded_at' => now(),
            ]);

            return $refund;
        });
    }
}
```

---

## 15) Validation and Security Rules

1. Create Razorpay orders **only on the server**.
2. Never trust amount, currency, discount, or order ownership from the client.
3. Verify the Checkout signature **on the server**.
4. Verify the webhook signature **on the server**.
5. Use webhook processing + API verification for resilient payment state updates.
6. Use **HTTPS** end-to-end.
7. Keep `key_secret` and webhook secret **server-side only** — never expose in JS or mobile apps.
8. Use **CSRF protection** for web routes; **JWT / Sanctum token auth** for API routes.
9. Implement **idempotency** for retries and duplicate callbacks.
10. Do **not** ship goods or activate services until payment is `captured`.

**Sources:** [Integration Steps](https://razorpay.com/docs/payments/payment-gateway/web-integration/standard/integration-steps/) | [Capture API](https://razorpay.com/docs/api/payments/capture/) | [Webhooks](https://razorpay.com/docs/webhooks/)

---

## 16) Capture Strategy

### Recommended
Enable **automatic capture** in Razorpay unless your business requires manual review. Uncaptured payments are refunded after the configured window.

**Sources:** [Capture Settings](https://razorpay.com/docs/payments/payments/capture-settings/) | [Capture API](https://razorpay.com/docs/api/payments/capture/) | [How It Works](https://razorpay.com/docs/payments/payment-gateway/how-it-works/)

### Use Manual Capture Only If
- You need anti-fraud or manual review.
- You validate inventory post-authorization.
- You need a deferred fulfillment workflow.

> If using manual capture, keep a **scheduled reconciliation job** that finds `authorized` but uncaptured payments and resolves them.

---

## 17) Reconciliation Strategy

```bash
php artisan make:command ReconcileRazorpayPayments
```

**Behavior:**
- Find local payments stuck in `pending` or `authorized` beyond an SLA threshold.
- Call `fetchPayment()` from Razorpay API.
- Update local state to match gateway state.
- Alert on mismatches.

> Protects against missed callbacks, queue outages, and temporary webhook delivery failures.

---

## 18) Suggested Test Cases

### Happy Path
- Create local order → create Razorpay order → open Checkout → complete payment → verify signature → process `payment.captured` webhook → mark order paid.

### Failure Path
- Payment failed in Checkout
- Invalid signature
- Webhook delivered twice (idempotency check)
- Webhook arrives before callback verification
- Authorized but not captured within SLA
- Partial refund

### Security Path
- Tampered amount from frontend
- Tampered order ID from frontend
- Wrong webhook signature
- Wrong checkout signature
- Duplicate payment callback
- Expired or invalid JWT token on API routes

---

## 19) What Not To Do

- ❌ Do not create Razorpay orders on the frontend.
- ❌ Do not trust `razorpay_order_id` from the client without matching to your stored order.
- ❌ Do not mark orders paid solely from the browser callback.
- ❌ Do not depend on one signal only — use callback verification for UX and webhooks for durable state.
- ❌ Do not store money as decimal floats.
- ❌ Do not mix cart, order, and payment concerns in a single controller method.
- ❌ Do not expose `key_secret` or webhook secret in any client-side code.
- ❌ Do not skip JWT validation for API endpoints — always authenticate before accessing payment resources.

---

## 20) Minimal Implementation Checklist

- [ ] Razorpay account created with Test and Live keys configured
- [ ] Official PHP SDK installed (`composer require razorpay/razorpay`)
- [ ] JWT auth installed and configured (`tymon/jwt-auth`)
- [ ] `User` model implements `JWTSubject`
- [ ] Auth guard configured for `api` → `jwt` driver
- [ ] Server endpoint to create Razorpay order (JWT-protected)
- [ ] Checkout wired to backend-created order
- [ ] Signature verification endpoint implemented (JWT-protected)
- [ ] Webhook endpoint implemented (signature-verified, no JWT)
- [ ] Webhook excluded from CSRF middleware
- [ ] Queue worker configured for webhook jobs
- [ ] Automatic or manual capture strategy decided
- [ ] Refund flow implemented
- [ ] Reconciliation command scheduled
- [ ] Test-mode end-to-end flow verified (web + mobile/API)
- [ ] Live-mode rollout checklist completed

---

## 21) Practical Recommendation

For most Laravel e-commerce apps, this is the best balance:

| Concern | Recommendation |
|---|---|
| Order creation | Server-side only |
| Immediate UX feedback | Browser/app callback (verify signature) |
| Durable state | Webhooks as source of truth |
| Capture | Automatic unless manual review needed |
| Payment tables | Separate from `orders` table |
| Business logic | Action classes + gateway interface |
| API auth | JWT (`tymon/jwt-auth`) for mobile/API, Sanctum for SPA |
| Webhook auth | Razorpay HMAC-SHA256 signature (no JWT) |

---

## 22) References

| Resource | Link |
|---|---|
| Standard Checkout Integration | [integration-steps](https://razorpay.com/docs/payments/payment-gateway/web-integration/standard/integration-steps/) |
| Build Your Own Integration | [build-your-own](https://razorpay.com/docs/payments/payment-gateway/ecommerce-plugins/build-your-own/) |
| Payments API | [api/payments](https://razorpay.com/docs/api/payments/) |
| Capture Payment API | [api/payments/capture](https://razorpay.com/docs/api/payments/capture/) |
| Webhooks Overview | [webhooks](https://razorpay.com/docs/webhooks/) |
| Webhook Validation & Testing | [webhooks/validate-test](https://razorpay.com/docs/webhooks/validate-test/) |
| Capture Settings | [capture-settings](https://razorpay.com/docs/payments/payments/capture-settings/) |
| Official PHP SDK | [razorpay-php (GitHub)](https://github.com/razorpay/razorpay-php) |
| tymon/jwt-auth | [jwt-auth (GitHub)](https://github.com/tymondesigns/jwt-auth) |
| JWT Auth Laravel Docs | [jwt-auth.readthedocs.io](https://jwt-auth.readthedocs.io/en/develop/) |
