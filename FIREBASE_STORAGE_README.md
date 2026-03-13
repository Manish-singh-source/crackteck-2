# Firebase Storage Setup

This project already has Firebase-related code for two separate concerns:

- `app/Services/FirebaseStorageService.php`: upload/delete files in Firebase Storage
- `app/Services/FirebaseFcmService.php`: send Firebase Cloud Messaging notifications
- `app/Helpers/FileUpload.php`: shared upload helper used by controllers
- `app/Helpers/FirebaseStorageHelper.php`: thin helper wrapper around the storage service

The upload layer is now configurable. You can keep local uploads or switch the whole app to Firebase Storage through env values.

## 1. Required packages

These packages are already present in `composer.json`:

- `google/auth`
- `google/cloud-storage`
- `guzzlehttp/guzzle`

If you install dependencies on a fresh machine:

```bash
composer install
```

## 2. Firebase service account

Create or download a Firebase service account JSON file with access to your Firebase project's Storage bucket.

Recommended location:

```text
storage/app/firebase/service-account.json
```

Do not commit this file.

## 3. Environment variables

Add these values to `.env`:

```env
FILE_UPLOAD_DISK=firebase
FIREBASE_PROJECT_ID=your-firebase-project-id
FIREBASE_CREDENTIALS=C:\xampp\htdocs\crackteck-2\storage\app\firebase\service-account.json
FIREBASE_STORAGE_BUCKET=your-project-id.appspot.com
FIREBASE_STORAGE_BASE_URL=
```

Notes:

- Set `FILE_UPLOAD_DISK=public` if you want to keep local uploads.
- `FIREBASE_STORAGE_BASE_URL` is optional.
- If empty, the app builds URLs like `https://storage.googleapis.com/<bucket>/<object-path>`.
- On Windows, use a full absolute path for `FIREBASE_CREDENTIALS`.

## 4. Clear cached config

After changing `.env`, run:

```bash
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
```

## 5. How uploads work now

Controllers should continue using:

```php
use App\Helpers\FileUpload;

$path = FileUpload::fileUpload($request->file('image'), 'uploads/e-commerce/banner/website_banner/');
```

Behavior depends on `FILE_UPLOAD_DISK`:

- `public`: stores files under `public/<path>` and returns the relative path
- `firebase`: uploads to Firebase Storage and returns the public Firebase URL

Updating files:

```php
$path = FileUpload::updateFileUpload($request->file('image'), $model->image_url, 'uploads/example/');
```

Deleting files:

```php
FileUpload::deleteFile($model->image_url);
```

## 6. Direct Firebase helper usage

If you want to bypass the generic helper:

```php
use App\Helpers\FirebaseStorageHelper;

$url = FirebaseStorageHelper::upload($request->file('document'), 'uploads/documents');
FirebaseStorageHelper::delete($url);
```

You can also inject the service directly:

```php
use App\Services\FirebaseStorageService;

public function store(Request $request, FirebaseStorageService $firebaseStorage)
{
    $url = $firebaseStorage->upload($request->file('file'), 'uploads/test');
}
```

## 7. Container binding

The app registers Firebase Storage in `AppServiceProvider` as:

- `App\Services\FirebaseStorageService::class`
- `app('firebase.storage')`

So old helper-style access still works.

## 8. Existing helper/service review

### `app/Helpers/FileUpload.php`

This is the main upload entry point used across controllers.

Current behavior:

- accepts nullable uploaded files safely
- switches between local and Firebase storage using config
- supports upload, update, and delete in one place

Recommendation:

- use this helper for all file uploads in controllers
- avoid mixing direct `move()` and `store()` calls if you want one consistent storage strategy

### `app/Helpers/FirebaseStorageHelper.php`

This is now a thin wrapper around the service.

Recommendation:

- use it only when you explicitly want Firebase-specific behavior
- otherwise prefer `FileUpload` so local/Firebase can be swapped by env

### `app/Services/FirebaseStorageService.php`

This is the real Firebase Storage integration.

Responsibilities:

- validate Firebase config
- create the Google Cloud Storage client
- upload files to the configured bucket
- build public URLs
- delete stored objects

### `app/Services/FirebaseFcmService.php`

This service is for Firebase Cloud Messaging, not storage.

It now validates:

- `FIREBASE_PROJECT_ID`
- `FIREBASE_CREDENTIALS`
- credentials file existence
- access token retrieval

## 9. Important compatibility note

A lot of this project already uses `FileUpload::fileUpload(...)`.
That is good, because switching to Firebase only requires updating env values.

But some places still use Laravel local storage directly, for example:

```php
$request->file('...')->store(..., 'public')
```

Those places will not automatically use Firebase through this helper-based setup.
If you want full Firebase consistency, convert those remaining direct storage calls to `FileUpload` as well.

## 10. Recommended usage standard

Use this rule in the project:

- generic app uploads: `FileUpload`
- Firebase-only operations: `FirebaseStorageHelper` or `FirebaseStorageService`
- notifications: `FirebaseFcmService`

## 11. Quick test

After setup:

1. set `FILE_UPLOAD_DISK=firebase`
2. upload a file from a controller that already uses `FileUpload`
3. confirm the saved database value is a Firebase URL
4. open the URL in browser
5. test update and delete flows
