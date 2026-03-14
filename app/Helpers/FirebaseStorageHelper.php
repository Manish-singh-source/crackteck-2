<?php

namespace App\Helpers;

use App\Services\FirebaseStorageService;
use Illuminate\Http\UploadedFile;

class FirebaseStorageHelper
{
    public static function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        return app(FirebaseStorageService::class)->upload($file, $folder);
    }

    public static function delete(?string $path): bool
    {
        return app(FirebaseStorageService::class)->delete($path);
    }
}
