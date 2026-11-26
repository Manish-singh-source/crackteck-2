# Push and In-App Notification Integration

This document describes the notification system currently implemented in this Laravel backend for the customer app, engineer/staff app, delivery app, sales app, and CRM web panel.

## 1. Important behavior summary

The backend has one central notification flow:

```text
Successful mutating API/web request
        |
        v
RecordCrmNotification middleware
        |
        +--> notifications table (in-app notification)
        |
        +--> queued SendFcmNotification job
                    |
                    v
              Firebase FCM HTTP v1
                    |
                    v
              Registered app/browser devices
```

Notifications are generic CRM activity notifications. The backend does not currently create different notification classes for every business event such as “quotation accepted” or “engineer assigned”. Instead, the middleware derives the title and message from the route name.

## 2. Base URLs and authentication

The API route prefix is:

```text
https://srbcomputers.co.in/api/v1
```

Authenticated mobile routes use:

```text
jwt.verify
crm.notifications
```

Send the JWT in the same format already used by the app, normally:

```http
Authorization: Bearer <jwt-token>
Accept: application/json
```

The notification APIs require `user_id` and `role_id` in the request where shown below.

Role IDs:

| `role_id` | User type |
|---:|---|
| 1 | Engineer/staff |
| 2 | Delivery person/staff |
| 3 | Sales person/staff |
| 4 | Customer |

## 3. Device token registration

Every Android/iOS device must send its current Firebase token after login and whenever the token refreshes.

### Register token

```http
POST /api/v1/device-token
Authorization: Bearer <jwt-token>
Content-Type: application/json
```

Request body:

```json
{
  "user_id": 4,
  "role_id": 1,
  "fcm_token": "FCM_DEVICE_TOKEN",
  "device_type": "android",
  "device_id": "ANDROID_DEVICE_ID"
}
```

Allowed `device_type` values:

```text
android | ios | web
```

Success response:

```json
{
  "success": true,
  "message": "FCM token stored successfully."
}
```

The backend stores one row in `device_tokens` and updates an existing row when the same FCM token is registered again. The token is associated with either `App\\Models\\Staff` or `App\\Models\\Customer` based on `role_id`.

### Remove token on logout

```http
DELETE /api/v1/device-token
Authorization: Bearer <jwt-token>
Content-Type: application/json
```

Request body:

```json
{
  "fcm_token": "FCM_DEVICE_TOKEN"
}
```

The app should call this before logout when possible. It should also delete/clear the local token after logout.

## 4. In-app notification API

### Get notifications

```http
GET /api/v1/notifications?user_id=4&role_id=1
Authorization: Bearer <jwt-token>
Accept: application/json
```

Customer example:

```http
GET /api/v1/notifications?user_id=3&role_id=4
```

Response:

```json
{
  "success": true,
  "notifications": [
    {
      "id": "uuid",
      "type": "App\\Notifications\\CrmActivityNotification",
      "notifiable_type": "App\\Models\\Staff",
      "notifiable_id": 4,
      "data": {
        "title": "Service Request",
        "message": "Engineer Tech updated Service Request.",
        "category": "crm",
        "route_name": "api.field_engineer_controller.accept_service_request",
        "url": null,
        "actor_id": 4,
        "created_at": "2026-11-17T09:30:00+00:00"
      },
      "read_at": null,
      "created_at": "2026-11-17T09:30:00.000000Z",
      "updated_at": "2026-11-17T09:30:00.000000Z"
    }
  ]
}
```

The app should treat `data` as the notification payload. `read_at == null` means unread. The current endpoint returns the user’s complete Laravel notification collection; pagination is not currently implemented.

There is currently no mobile endpoint to mark a notification as read or delete it. The CRM web panel has those actions, but the mobile API only exposes the list endpoint.

## 5. Notification payload and message rules

The payload written to the database and sent to FCM contains:

```json
{
  "title": "Derived route label",
  "message": "Actor Name updated Derived route label.",
  "category": "crm",
  "route_name": "route-or-generated-controller-method-name",
  "url": null,
  "actor_id": 4,
  "created_at": "ISO-8601 timestamp"
}
```

`title` is derived from the route name. Route separators, underscores, and hyphens become spaces and the result is converted to headline case.

The verb is derived from the final route action:

| Route action | Message verb |
|---|---|
| `store`, `create`, `submit`, `add`, `buy_product`, `request_product` | `created` |
| `delete`, `destroy`, `remove` | `deleted` |
| Everything else | `updated` |

For API requests, `url` is currently `null`. For successful CRM web mutations it may contain the previous page URL.

## 6. Who receives each notification?

For a successful authenticated API mutation:

1. All active staff records receive a database notification. Staff with status `inactive`, `Inactive`, or `deleted` are excluded.
2. The customer who performed the request receives a database notification when the request actor is a customer (`role_id=4`).
3. The queued FCM job sends the push to all matching registered device tokens.

The FCM recipient query matches:

| Recipient | Match |
|---|---|
| Staff/engineer/delivery/sales | `user_id` in staff recipient IDs and `owner_type=App\\Models\\Staff` |
| Customer | `user_id` in customer recipient IDs and `owner_type=App\\Models\\Customer` |
| Legacy staff token | `owner_type` null and `role_id` in `1,2,3` |
| Legacy customer token | `owner_type` null and `role_id=4` |

The token must also belong to the current configured `FIREBASE_PROJECT_ID`.

Important: the current implementation sends most activity notifications to all active staff, not only the staff member assigned to that service/order.

## 7. APIs that generate notifications

All successful `POST`, `PUT`, `PATCH`, and `DELETE` routes inside the authenticated `/api/v1` route group pass through `crm.notifications` and generate the generic in-app + push notification described above.

The main notification-generating API groups are:

### Service requests, AMC, quotations, invoices, and diagnosis

```text
POST /submit-quick-service-request
POST /customer-approve-reject-part
POST /customer-approve-reject-pickup
POST /service-request-quotations/{id}/accept
POST /service-request-quotations/{id}/reject
POST /service-request-quotation-payment
POST /service-request-invoice/{id}/accept
POST /service-request-invoice/{id}/reject
POST /invoice-payment/{id}
POST /give-feedback
POST /service-request/{id}/accept
POST /service-request/{id}/send-otp
POST /service-request/{id}/verify-otp
POST /service-request/{id}/case-transfer
POST /service-request/{id}/reschedule
POST /service-request/{id}/{product_id}/submit-diagnosis
POST /service-request/{id}/{product_id}/request-part
```

### Orders, payments, refunds, and rewards

```text
POST /buy-product/{id}
POST /cancel-order/{order_id}
POST /return-order/{order_id}
POST /orders/{id}/claim-reward
POST /checkout/orders/{order}/razorpay
POST /checkout/razorpay/verify
POST /payments/{payment}/refund
```

### CRM data and sales workflows

```text
POST   /lead
PUT    /lead/{id}
DELETE /lead/{id}
POST   /follow-up
PUT    /follow-up/{id}
DELETE /follow-up/{id}
POST   /meet
PUT    /meet/{id}
DELETE /meet/{id}
POST   /quotation
PUT    /quotation/{id}
DELETE /quotation/{id}
PUT    /profile
POST   /address
PUT    /address/{id}
POST   /aadhar-card
PUT    /aadhar-card/{id}
POST   /customer-pan-card
PUT    /customer-pan-card/{id}
POST   /company-details
PUT    /company-details/{id}
```

### Delivery, pickup, return, and part workflows

```text
GET  /accept-order/{order_id}
POST /order/profile/{order_id}
POST /order/{order_id}/otp
POST /order/{order_id}/verify-otp
POST /delivery-orders
POST /accept-return-order/{id}
POST /return-order/{id}/otp
POST /return-order/{id}/verify-otp
POST /return-order-received/{id}
POST /pickup-request/{id}/accept
POST /pickup-request/{id}/send-otp
POST /pickup-request/{id}/verify-otp
POST /return-request/{id}/accept
POST /return-request/{id}/send-otp
POST /return-request/{id}/verify-otp
POST /part-request/{id}/accept
POST /part-request/{id}/send-otp
POST /part-request/{id}/verify-otp
```

### Products, stock, expenses, cash, attendance, and quick service

```text
POST /request-product
POST /stock-in-hand/request
POST /staff-reimbursements
POST /cash-received
POST /attendance-login
POST /attendance-logout
POST /quick-service/{id}
POST /vehicle-registration
PUT  /update-vehicle-details
POST /store-aadhar
PUT  /update-aadhar
POST /store-pan-card
PUT  /update-pan-card
POST /store-driving-license
PUT  /update-driving-license
```

### GET routes that can also generate notifications

The middleware explicitly treats these legacy GET controller actions as mutations:

```text
accept
approve
reject
cancel
deliver
receive
pick
complete
close
assign
transfer
reschedule
verify
start
logout
```

Therefore any API route using one of those action names can generate a notification even if its HTTP method is `GET`. The known example is:

```text
GET /accept-order/{order_id}
```

## 8. APIs that do not generate notifications

These endpoints are intentionally excluded from the middleware notification flow:

```text
GET    /api/v1/notifications
POST   /api/v1/device-token
DELETE /api/v1/device-token
POST   /api/v1/logout
POST   /api/v1/refresh-token
```

Normal read-only `GET` endpoints such as lists, details, dashboards, products, service details, and order details do not generate notifications.

## 9. Direct FCM test APIs

These endpoints send a push directly to one supplied FCM token. They do not create a database/in-app notification.

### Normal FCM test

```http
POST /api/v1/test-fcm
Content-Type: application/json
```

Request:

```json
{
  "token": "FCM_DEVICE_TOKEN",
  "title": "Test notification",
  "body": "FCM test from Laravel"
}
```

`fcm_token` can be used instead of `token`.

### Final FCM test

```http
POST /api/v1/test-fcm-final
Content-Type: application/json
```

This uses the separate `FIREBASE_FINAL_PROJECT_ID` and `FIREBASE_FINAL_CREDENTIALS` configuration and sends only the notification title/body. It does not send the application data payload.

Do not leave these test endpoints publicly available in production without authentication or an IP restriction.

## 10. FCM transport details

The production notification job is:

```text
app/Jobs/SendFcmNotification.php
```

The transport service is:

```text
app/Services/FirebaseFcmService.php
```

It sends Firebase Cloud Messaging HTTP v1 requests to:

```text
https://fcm.googleapis.com/v1/projects/{FIREBASE_PROJECT_ID}/messages:send
```

FCM message shape:

```json
{
  "message": {
    "token": "FCM_DEVICE_TOKEN",
    "notification": {
      "title": "Service Request",
      "body": "Engineer Tech updated Service Request."
    },
    "data": {
      "category": "crm",
      "url": "",
      "route_name": "api.some_controller.some_action"
    }
  }
}
```

All FCM data values are converted to strings. The Flutter app should not assume that a data field is a JSON object.

The job has `tries = 3`. FCM failures are logged and do not fail the original API response. The API request can succeed while the push later fails in the queue worker.

## 11. Queue worker requirement

Push sending is queued. A queue worker must be running on production:

```bash
php artisan queue:work --tries=3
```

If the worker is not running, in-app database notifications will still be created, but push notifications will remain queued and will not reach devices.

For shared hosting, configure a cron job or supervisor equivalent to process the queue. Confirm the application queue connection and worker configuration in `.env`.

## 12. Flutter integration flow

### App startup/login

1. Initialize Firebase.
2. Request notification permission.
3. Get the FCM token.
4. POST the token to `/api/v1/device-token` with the logged-in user ID and role ID.
5. Register `FirebaseMessaging.onTokenRefresh` and send the new token again.
6. Register foreground, background, and notification-tap handlers.

### Suggested Dart token registration

```dart
Future<void> registerFcmToken({
  required String apiBaseUrl,
  required String jwt,
  required int userId,
  required int roleId,
  required String token,
  String deviceType = 'android',
  String? deviceId,
}) async {
  final response = await http.post(
    Uri.parse('$apiBaseUrl/api/v1/device-token'),
    headers: {
      'Authorization': 'Bearer $jwt',
      'Accept': 'application/json',
      'Content-Type': 'application/json',
    },
    body: jsonEncode({
      'user_id': userId,
      'role_id': roleId,
      'fcm_token': token,
      'device_type': deviceType,
      'device_id': deviceId,
    }),
  );

  if (response.statusCode < 200 || response.statusCode >= 300) {
    throw Exception('Unable to register FCM token: ${response.body}');
  }
}
```

### Load in-app notifications

```dart
final response = await http.get(
  Uri.parse('$apiBaseUrl/api/v1/notifications?user_id=$userId&role_id=$roleId'),
  headers: {
    'Authorization': 'Bearer $jwt',
    'Accept': 'application/json',
  },
);
```

Use `notification['data']['title']`, `notification['data']['message']`, and `notification['data']['route_name']` to render the list and decide where to navigate.

### Foreground behavior

FCM notification messages do not automatically show a system notification while the app is in the foreground on every platform. Use `flutter_local_notifications` or an in-app banner for `FirebaseMessaging.onMessage`.

### Background/tap behavior

Handle:

```dart
FirebaseMessaging.onBackgroundMessage(backgroundHandler);
FirebaseMessaging.onMessageOpenedApp.listen(handleOpenedMessage);
final initialMessage = await FirebaseMessaging.instance.getInitialMessage();
```

Navigate using `message.data['route_name']` or `message.data['url']`. For the current API notifications, `url` is normally empty/null, so the app should map `route_name` to its own screen.

## 13. CRM web notification behavior

The CRM web panel uses these routes:

```text
GET    /demo/crm/notifications
POST   /demo/crm/notifications/device-token
POST   /demo/crm/notifications/read-all
POST   /demo/crm/notifications/{notification}/read
DELETE /demo/crm/notifications
```

The web panel polls the notification list every 30 seconds. It can register a browser FCM token using the Firebase web VAPID key and service worker:

```text
/demo/firebase-messaging-sw.js
```

The same `CrmActivityNotification` database records are used by the CRM web panel and the mobile notification API.

## 14. Backend files involved

| File | Responsibility |
|---|---|
| `app/Http/Middleware/RecordCrmNotification.php` | Detects successful mutations and starts notification publishing |
| `app/Services/CrmNotificationService.php` | Builds payload, selects staff/customer recipients, writes in-app notifications, dispatches FCM job |
| `app/Notifications/CrmActivityNotification.php` | Laravel database notification representation |
| `app/Jobs/SendFcmNotification.php` | Queued device-token selection and push dispatch |
| `app/Services/FirebaseFcmService.php` | Firebase HTTP v1 transport |
| `app/Http/Controllers/Api/NotificationController.php` | Mobile in-app notification list API |
| `app/Http/Controllers/Api/DeviceTokenController.php` | Mobile token registration/removal API |
| `app/Http/Controllers/CrmNotificationController.php` | CRM web list/read/delete/token APIs |
| `public/assets/js/crm-notifications.js` | CRM browser notification polling and web FCM registration |
| `resources/views/crm/firebase-messaging-sw.blade.php` | Browser push service worker |
| `database/migrations/*create_notifications_table.php` | In-app notification storage |
| `database/migrations/*create_device_tokens_table.php` | FCM token storage |

## 15. Production configuration checklist

Required `.env` values:

```env
FIREBASE_PROJECT_ID=your-firebase-project-id
FIREBASE_CREDENTIALS=/absolute/path/to/firebase-service-account.json
```

For CRM browser push, also configure:

```env
FIREBASE_WEB_API_KEY=...
FIREBASE_WEB_AUTH_DOMAIN=...
FIREBASE_WEB_PROJECT_ID=...
FIREBASE_WEB_MESSAGING_SENDER_ID=...
FIREBASE_WEB_APP_ID=...
FIREBASE_WEB_VAPID_KEY=...
```

Verify:

- `notifications` and `device_tokens` migrations have run.
- `FIREBASE_CREDENTIALS` points to a readable service-account JSON file.
- The Firebase service account has permission to send Firebase Cloud Messaging messages.
- `FIREBASE_PROJECT_ID` matches the Firebase project used by the mobile apps.
- The queue worker is running.
- Each app registers its FCM token after login and on token refresh.
- Android/iOS Firebase configuration belongs to the same Firebase project.
- Notification permission is granted on the device.
- The app handles foreground notifications locally.

## 16. Current limitations to consider during app integration

1. There is no `unread_count` field in the mobile `/api/v1/notifications` response; calculate it from `read_at`.
2. There are no mobile mark-read, mark-all-read, or delete endpoints.
3. Most notifications are broadcast to all active staff devices.
4. API notification `url` is normally null; use `route_name` for app navigation.
5. All event messages are generic route activity messages, not business-specific templates.
6. A successful API response does not guarantee immediate push delivery because FCM sending is queued.
7. The direct test endpoints send push only and do not create in-app notification rows.

