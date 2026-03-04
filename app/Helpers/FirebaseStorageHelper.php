<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FirebaseStorageHelper
{
    public static function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        $firebaseStoragePath = trim($folder, '/').'/';

        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug($name).'-'.time().'.'.$extension;

        $localFolder = storage_path('app/tmp/');
        if (! is_dir($localFolder)) {
            mkdir($localFolder, 0775, true);
        }

        if (! $file->move($localFolder, $filename)) {
            throw new \RuntimeException('Failed to move file locally');
        }

        $uploadedFile = fopen($localFolder.$filename, 'r');

        $bucket = app('firebase.storage')->getBucket();
        $object = $bucket->upload($uploadedFile, [
            'name' => $firebaseStoragePath.$filename,
        ]);

        fclose($uploadedFile);
        @unlink($localFolder.$filename);

        // Public URL (if bucket is public or you use signed URLs)
        $publicUrl = sprintf(
            'https://storage.googleapis.com/%s/%s%s',
            $bucket->name(),
            $firebaseStoragePath,
            $filename
        );

        return $publicUrl;
    }
}
