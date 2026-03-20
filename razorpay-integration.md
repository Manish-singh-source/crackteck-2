# Razorpay Integration in Laravel

A production-oriented guide to integrate Razorpay into a Laravel application using a maintainable, testable architecture.


## Website Checkout Integration Documentation

This repo now uses the existing `#checkout-form` for Razorpay website checkout.
The order is created first, then Razorpay popup payment is started.

### Step 1
Add Razorpay env keys in `.env`:
- `RAZORPAY_KEY_ID`
- `RAZORPAY_KEY_SECRET`
- `RAZORPAY_WEBHOOK_SECRET`
- `RAZORPAY_CURRENCY`
- `RAZORPAY_AUTO_CAPTURE`

### Step 2
Map those keys in `config/services.php` under `services.razorpay`.

### Step 3
In `app/Providers/AppServiceProvider.php`:
- register `Razorpay\Api\Api`
- bind `PaymentGatewayInterface` to `RazorpayGateway`

### Step 4
Use `app/Services/Payments/RazorpayGateway.php` for:
- create order
- fetch payment
- verify signature
- refund payment
- verify webhook signature

### Step 5
Use `app/Actions/CreatePaymentOrderAction.php` and `app/Actions/VerifyCheckoutSignatureAction.php` to create Razorpay orders and verify payments.

### Step 6
In `resources/views/frontend/checkout.blade.php`:
- keep using `#checkout-form`
- load Razorpay checkout.js
- submit checkout with AJAX
- open Razorpay popup after local order creation

### Step 7
In `app/Http/Controllers/CheckoutController.php`:
- keep existing `store()` order flow
- return `order_id`, `order_number`, `payment_method`, `redirect`
- add web Razorpay create and verify methods
- keep direct card fields optional

### Web Routes Generated
- `POST /checkout/place-order` as `checkout.store`
- `POST /checkout/orders/{order}/razorpay` as `checkout.razorpay.order`
- `POST /checkout/razorpay/verify` as `checkout.razorpay.verify`

### Existing API Routes
- `POST /api/v1/checkout/orders/{order}/razorpay`
- `POST /api/v1/checkout/razorpay/verify`
- `POST /api/v1/webhooks/razorpay`

### Frontend Flow
1. Submit `#checkout-form`
2. Call `checkout.store`
3. If COD, redirect normally
4. If online, call `checkout.razorpay.order`
5. Open Razorpay popup
6. Verify via `checkout.razorpay.verify`
7. Redirect to order details

### Main Files
- `resources/views/frontend/checkout.blade.php`
- `routes/frontend.php`
- `app/Http/Controllers/CheckoutController.php`
- `app/Actions/CreatePaymentOrderAction.php`
- `app/Actions/VerifyCheckoutSignatureAction.php`
- `app/Services/Payments/RazorpayGateway.php`






APIs for razorpay: 

customer login: 

curl -X POST http://127.0.0.1:8000/api/v1/send-otp ^
  -H "Content-Type: application/json" ^
  -d "{\"phone_number\":\"9999999999\",\"role_id\":4}"


customer verify otp: 

curl -X POST http://127.0.0.1:8000/api/v1/verify-otp ^
  -H "Content-Type: application/json" ^
  -d "{\"phone_number\":\"9999999999\",\"otp\":\"1234\",\"role_id\":4}"


create razorpay order: 

curl -X POST http://127.0.0.1:8000/api/v1/checkout/orders/ORDER_ID/razorpay ^
  -H "Authorization: Bearer JWT_TOKEN" ^
  -H "Content-Type: application/json" ^
  -d "{\"user_id\":CUSTOMER_ID,\"role_id\":4}"

verify razorpay payment:

curl -X POST http://127.0.0.1:8000/api/v1/checkout/razorpay/verify ^
  -H "Authorization: Bearer JWT_TOKEN" ^
  -H "Content-Type: application/json" ^
  -d "{\"user_id\":CUSTOMER_ID,\"role_id\":4,\"order_id\":ORDER_ID,\"razorpay_order_id\":\"order_xxx\",\"razorpay_payment_id\":\"pay_xxx\",\"razorpay_signature\":\"SIGNATURE\"}"

webhook verification:

curl -X POST http://127.0.0.1:8000/api/v1/webhooks/razorpay ^
  -H "Content-Type: application/json" ^
  -H "X-Razorpay-Signature: WEBHOOK_SIGNATURE" ^
  -d "{\"event\":\"payment.captured\",\"payload\":{\"payment\":{\"entity\":{\"id\":\"pay_xxx\",\"order_id\":\"order_xxx\",\"status\":\"captured\",\"method\":\"upi\"}}}}"

refund payment:

curl -X POST http://127.0.0.1:8000/api/v1/payments/PAYMENT_DB_ID/refund ^
  -H "Authorization: Bearer JWT_TOKEN" ^
  -H "Content-Type: application/json" ^
  -d "{\"user_id\":CUSTOMER_ID,\"role_id\":4}"
