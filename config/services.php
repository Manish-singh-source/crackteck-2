<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'fast2sms' => [
        'api_key' => env('FAST2SMS_API_KEY'),
        'sender_id' => env('FAST2SMS_SENDER_ID'),
        'template_id' => env('FAST2SMS_TEMPLATE_ID'),
        'entity_id' => env('FAST2SMS_ENTITY_ID'),
    ],

    'firebase' => [
        'project_id' => env('FIREBASE_PROJECT_ID'),
        'credentials' => env('FIREBASE_CREDENTIALS'),
        'storage_bucket' => env('FIREBASE_STORAGE_BUCKET'),
        'storage_base_url' => env('FIREBASE_STORAGE_BASE_URL'),
        'upload_disk' => env('FILE_UPLOAD_DISK', 'public'),
    ],

    'firebasefinal' => [
        'project_id' => env('FIREBASE_FINAL_PROJECT_ID'),
        'credentials' => env('FIREBASE_FINAL_CREDENTIALS'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'razorpay' => [
        'key_id' => env('RAZORPAY_KEY_ID'),
        'key_secret' => env('RAZORPAY_KEY_SECRET'),
        'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
        'currency' => env('RAZORPAY_CURRENCY', 'INR'),
        'auto_capture' => filter_var(env('RAZORPAY_AUTO_CAPTURE', true), FILTER_VALIDATE_BOOL),
    ],

];
