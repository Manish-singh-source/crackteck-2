# Let’s wire FCM end‑to‑end: Firebase → Laravel (sender) → Flutter (receiver), with concrete steps and commands.

## 1. Firebase setup (once for project)

1. Create Firebase project
    - Go to Firebase Console → “Add project” → choose name → finish wizard.[^1]
2. Enable Cloud Messaging
    - In left menu: Build → Cloud Messaging → click “Get started” if needed.[^1]
3. Add Android app (for Flutter)
    - In Project Overview → “Add app” → Android.
    - Package name = your Flutter `applicationId` in `android/app/build.gradle`.
    - Download `google-services.json` and put it in `android/app/`.[^2][^3]
4. (Optional now, needed later) Add iOS app
    - Add iOS app, download `GoogleService-Info.plist`, put it in `ios/Runner/`.[^3][^2]
5. Create service account (for Laravel)
    - Project settings → Service accounts → Firebase Admin SDK.
    - Click “Generate new private key” → download JSON.
    - Put file into Laravel, e.g. `storage/app/firebase/service-account.json`.[^4][^5]

***

## 2. Laravel setup (sending push)

### 2.1. Install packages

From your Laravel project root:

```bash
composer require kreait/laravel-firebase
```

This brings in Firebase Admin (including Messaging).[^5]

Publish config (optional but useful):

```bash
php artisan vendor:publish --provider="Kreait\Laravel\Firebase\ServiceProvider"
```

You should now have `config/firebase.php`.[^5]

### 2.2. Configure credentials

In `.env`:

```env
FIREBASE_CREDENTIALS=/full/path/to/storage/app/firebase/service-account.json
```

In `config/firebase.php` ensure:

```php
'credentials' => [
    'file' => env('FIREBASE_CREDENTIALS'),
],
```

So Laravel can load your service account.[^5]

### 2.3. Create a notification service

Create a service class to isolate FCM logic.

```bash
php artisan make:service FirebaseNotificationService
```

If `make:service` is not in your stubs, just create file manually:

`app/Services/FirebaseNotificationService.php`:

```php
<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotificationService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('firebase.credentials.file'));

        $this->messaging = $factory->createMessaging();
    }

    public function sendToToken(string $token, string $title, string $body, array $data = []): void
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification)
            ->withData($data);

        $this->messaging->send($message);
    }

    public function sendToTokens(array $tokens, string $title, string $body, array $data = []): void
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::new()
            ->withNotification($notification)
            ->withData($data);

        $this->messaging->sendMulticast($message, $tokens);
    }
}
```

Structure is the same as common Kreait FCM examples.[^6][^4][^5]

### 2.4. Expose API to test sending

Route in `routes/api.php`:

```php
use App\Http\Controllers\Api\NotificationTestController;

Route::post('/test-notification', [NotificationTestController::class, 'send']);
```

Create controller:

```bash
php artisan make:controller Api/NotificationTestController
```

`app/Http/Controllers/Api/NotificationTestController.php`:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;

class NotificationTestController extends Controller
{
    public function send(Request $request, FirebaseNotificationService $fcm)
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'title' => ['required', 'string'],
            'body'  => ['required', 'string'],
        ]);

        $fcm->sendToToken(
            $data['token'],
            $data['title'],
            $data['body'],
            ['screen' => 'home']
        );

        return response()->json(['status' => 'sent']);
    }
}
```

You can later replace `token` with reading from `users` table.

***

## 3. Flutter setup (receiving FCM)

### 3.1. Add Firebase to Flutter project

From Flutter project root, install CLI tools:[^7][^3]

```bash
dart pub global activate flutterfire_cli
```

Configure Firebase:

```bash
flutterfire configure
```

Choose your Firebase project and platforms. This generates `lib/firebase_options.dart`.[^7][^3]

### 3.2. Add dependencies

In `pubspec.yaml`:

```yaml
dependencies:
  firebase_core: ^latest
  firebase_messaging: ^latest
  flutter_local_notifications: ^latest
```

Install:

```bash
flutter pub get
```


### 3.3. Android configuration

1. `android/build.gradle`:
```gradle
buildscript {
    dependencies {
        classpath 'com.google.gms:google-services:4.4.0'
    }
}
```

2. `android/app/build.gradle`:
```gradle
plugins {
    id "com.android.application"
    id "com.google.gms.google-services"
}
```

3. Make sure `minSdkVersion` is at least what `firebase_messaging` requires (often 21+).[^2][^8]

`google-services.json` should already be in `android/app/`.

### 3.4. Initialize Firebase in `main.dart`

`lib/main.dart` (simplified):[^9][^3][^7]

```dart
import 'package:flutter/material.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'firebase_options.dart';

Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  await Firebase.initializeApp(
    options: DefaultFirebaseOptions.currentPlatform,
  );
  // handle background message (logging etc.)
}

void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  await Firebase.initializeApp(
    options: DefaultFirebaseOptions.currentPlatform,
  );

  FirebaseMessaging.onBackgroundMessage(_firebaseMessagingBackgroundHandler);

  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'FCM Demo',
      home: Scaffold(
        appBar: AppBar(title: const Text('FCM Demo')),
        body: const Center(child: Text('Home')),
      ),
    );
  }
}
```


### 3.5. Request permission and get token

Create a small notification service:[^10][^8][^9]

```dart
import 'package:firebase_messaging/firebase_messaging.dart';

class PushNotificationService {
  final FirebaseMessaging _fcm = FirebaseMessaging.instance;

  Future<String?> init() async {
    // iOS permission; on Android this will just complete
    final settings = await _fcm.requestPermission(
      alert: true,
      badge: true,
      sound: true,
    );

    if (settings.authorizationStatus == AuthorizationStatus.denied) {
      return null;
    }

    final token = await _fcm.getToken();

    // TODO: send token to Laravel API
    return token;
  }

  void listen() {
    FirebaseMessaging.onMessage.listen((RemoteMessage message) {
      // foreground message
      // show local notification, log, etc.
    });

    FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
      // user tapped notification
      // navigate based on message.data
    });
  }
}
```

Use it after app starts (e.g. in `initState` of your first screen):

```dart
@override
void initState() {
  super.initState();
  final service = PushNotificationService();
  service.init().then((token) {
    if (token != null) {
      // call your Laravel API to save token against user
      // e.g. PATCH /api/fcm-token
    }
  });
  service.listen();
}
```


### 3.6. iOS configuration (if you target iOS)

High level:[^11][^2]

- Add `GoogleService-Info.plist` to `Runner` in Xcode.
- In Xcode → Runner target → Signing \& Capabilities:
    - Add “Push Notifications”.
    - Add “Background Modes” → enable “Remote notifications”.
- In Apple Developer portal, create APNs key, upload to Firebase → Cloud Messaging → iOS configuration.

***

## 4. Connecting Flutter and Laravel

1. Flutter sends token to Laravel:

Example call (using `http` package):

```dart
import 'package:http/http.dart' as http;

Future<void> sendTokenToServer(String token) async {
  await http.post(
    Uri.parse('https://your-api.com/api/fcm-token'),
    headers: {'Authorization': 'Bearer YOUR_USER_TOKEN'},
    body: {'fcm_token': token},
  );
}
```

2. Laravel endpoint to store token:
```bash
php artisan make:migration add_fcm_token_to_users_table --table=users
```

Migration:

```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('fcm_token')->nullable();
    });
}
```

Run:

```bash
php artisan migrate
```

Route:

```php
Route::post('/fcm-token', function (Request $request) {
    $request->user()->update([
        'fcm_token' => $request->string('fcm_token'),
    ]);

    return response()->json(['status' => 'saved']);
})->middleware('auth:sanctum');
```

Then, when you need to notify a user:

```php
$user = User::find($id);

if ($user?->fcm_token) {
    $fcm->sendToToken(
        $user->fcm_token,
        'Order Update',
        'Your order has been shipped',
        ['order_id' => (string) $order->id]
    );
}
```

This is the usual Laravel ↔ FCM ↔ Flutter pattern.[^10][^7][^5]
