# Here’s a clean, from‑scratch, **Laravel → FCM HTTP v1 → Flutter** setup, tailored to your current stack (Laravel 12, PHP 8.2, `tymon/jwt-auth`).

I’ll break it into:

1. Firebase console setup
2. Laravel backend (send push via HTTP v1)
3. Flutter app (receive push)

Try to actually do each step in your project as you read; that’ll cement it.

***

## 1. Firebase setup (one-time)

1. Create project
    - Go to Firebase Console → “Add project” → create a new project.[^1]
2. Enable Cloud Messaging
    - In left menu: Build → Cloud Messaging → complete any setup prompt.[^1]
3. Create service account key (for Laravel)
    - Project settings → Service accounts → Firebase Admin SDK.
    - Click “Generate new private key” → download JSON.
    - Move it into your Laravel project, e.g.:
`storage/app/firebase/service-account.json`.
    - Note your **Project ID** from Project settings → General.[^2][^3]
4. Add Android app (for Flutter)
    - In Project Overview, “Add app” → Android.
    - Package name = your Flutter `applicationId` (`android/app/build.gradle`).
    - Download `google-services.json` and place it in `android/app/`.[^4]

We’ll use this service account JSON in Laravel to get an OAuth access token and call FCM HTTP v1.[^3][^2]

***

## 2. Laravel: send FCM HTTP v1

### 2.1. Install minimal packages

From your Laravel project root:

```bash
composer require google/auth guzzlehttp/guzzle
```

These work with PHP 8.2 and don’t interfere with your existing packages.[^5][^6]

### 2.2. Add env + config

In `.env`:

```env
FIREBASE_CREDENTIALS=/absolute/path/to/storage/app/firebase/service-account.json
FIREBASE_PROJECT_ID=your_project_id_here
```

In `config/services.php` add:

```php
'firebase' => [
    'project_id'  => env('FIREBASE_PROJECT_ID'),
    'credentials' => env('FIREBASE_CREDENTIALS'),
],
```

This lets the service read config cleanly.[^7]

### 2.3. Create FCM service class

Create file `app/Services/FirebaseFcmService.php`:

```php
<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;

class FirebaseFcmService
{
    protected string $projectId;
    protected string $credentialsPath;
    protected Client $http;

    public function __construct()
    {
        $this->projectId = config('services.firebase.project_id');
        $this->credentialsPath = config('services.firebase.credentials');

        $this->http = new Client([
            'base_uri' => 'https://fcm.googleapis.com/v1/',
            'timeout'  => 5.0,
        ]);
    }

    protected function getAccessToken(): string
    {
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];

        $creds = new ServiceAccountCredentials(
            $scopes,
            $this->credentialsPath
        );

        $token = $creds->fetchAuthToken();

        return $token['access_token'] ?? '';
    }

    public function sendToToken(string $token, string $title, string $body, array $data = []): array
    {
        $accessToken = $this->getAccessToken();

        $url = sprintf('projects/%s/messages:send', $this->projectId);

        $payload = [
            'message' => [
                'token'        => $token,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
                'data' => $data,
            ],
        ];

        $response = $this->http->post($url, [
            'headers' => [
                'Authorization' => 'Bearer '.$accessToken,
                'Content-Type'  => 'application/json; charset=UTF-8',
            ],
            'json' => $payload,
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
```

This matches Google’s HTTP v1 spec using `ServiceAccountCredentials` to fetch an access token.[^8][^2][^3]

### 2.4. Test controller + route

Create controller:

```bash
php artisan make:controller Api/FcmTestController
```

`routes/api.php`:

```php
use App\Http\Controllers\Api\FcmTestController;

Route::post('/test-fcm', [FcmTestController::class, 'send']);
```

`app/Http/Controllers/Api/FcmTestController.php`:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FirebaseFcmService;
use Illuminate\Http\Request;

class FcmTestController extends Controller
{
    public function send(Request $request, FirebaseFcmService $fcm)
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'title' => ['required', 'string'],
            'body'  => ['required', 'string'],
        ]);

        $result = $fcm->sendToToken(
            $data['token'],
            $data['title'],
            $data['body'],
            ['screen' => 'home']
        );

        return response()->json([
            'status' => 'sent',
            'fcm_response' => $result,
        ]);
    }
}
```

Once Flutter gives you a device token, you’ll call this endpoint from Postman to verify notifications reach the device.[^9][^2]

***

## 3. Flutter: receive FCM and get token

### 3.1. Add Firebase to Flutter

From Flutter project root:

```bash
dart pub global activate flutterfire_cli
flutterfire configure
```

Pick your Firebase project and platforms (Android now, iOS later). This generates `lib/firebase_options.dart`.[^10]

### 3.2. Add dependencies

In `pubspec.yaml`:

```yaml
dependencies:
  firebase_core: ^latest
  firebase_messaging: ^latest
```

Then:

```bash
flutter pub get
```


### 3.3. Android native setup

1. Make sure `google-services.json` is at `android/app/google-services.json`.[^4]
2. `android/build.gradle`:
```gradle
buildscript {
    dependencies {
        classpath 'com.google.gms:google-services:4.4.0'
    }
}
```

3. `android/app/build.gradle`:
```gradle
plugins {
    id "com.android.application"
    id "com.google.gms.google-services"
}
```

4. `minSdkVersion` should satisfy `firebase_messaging` (typically 21+).[^11][^12]

### 3.4. Initialize Firebase in `main.dart`

`lib/main.dart` (minimal):

```dart
import 'package:flutter/material.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'firebase_options.dart';

Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  await Firebase.initializeApp(
    options: DefaultFirebaseOptions.currentPlatform,
  );
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
      home: const HomeScreen(),
    );
  }
}

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  String? _token;

  @override
  void initState() {
    super.initState();
    _initFcm();
  }

  Future<void> _initFcm() async {
    final messaging = FirebaseMessaging.instance;

    await messaging.requestPermission(
      alert: true,
      badge: true,
      sound: true,
    );

    final token = await messaging.getToken();
    setState(() => _token = token);

    print('FCM TOKEN: $token'); // copy this into Postman for Laravel
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('FCM Demo')),
      body: Center(
        child: Text(_token ?? 'Getting FCM token...'),
      ),
    );
  }
}
```

This follows the current FlutterFire FCM getting‑started pattern.[^11][^12][^4]

### 3.5. Listen for messages (optional now, but useful)

Add listeners in `_initFcm`:

```dart
FirebaseMessaging.onMessage.listen((RemoteMessage message) {
  print('Foreground message: ${message.notification?.title}');
});

FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
  print('Notification clicked: ${message.data}');
});
```

This lets you see logs when messages arrive and when user taps them.[^12][^4]

***

## 4. Test the full flow

1. Run Flutter app on a real device (recommended) and copy the printed FCM token.[^4]
2. From Postman (or any client), call your Laravel endpoint:

- Method: `POST`
- URL: `http://your-local-host/api/test-fcm`
- Body (JSON):

```json
{
  "token": "PASTE_DEVICE_FCM_TOKEN_HERE",
  "title": "Test from Laravel",
  "body": "If you see this, HTTP v1 works!"
}
```

3. Ensure the app is in background or foreground on device and check if notification appears.[^2][^4]
