<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Converts a persisted media path into a link that an API client can use.
 *
 * Database values remain paths so local and Firebase storage can be changed
 * without a data migration. Absolute URLs are created only at the API edge.
 */
class ApiMediaUrl
{
    public static function make(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        $path = trim($path);

        if (Str::startsWith($path, ['http://', 'https://', 'data:'])) {
            return $path;
        }

        $path = ltrim($path, '/');

        // Files written with $file->store(..., 'public') are exposed through
        // the public storage symlink, not directly from public/. This includes
        // service-request product photos. Returning the raw path here creates
        // URLs such as /service-request-images/foo.jpg, which do not exist.
        if (Str::startsWith($path, [
            'diagnosis_photos/',
            'kyc_documents/',
            'service-request-images/',
            'ecommerce/',
        ])) {
            $storageUrl = Storage::disk('public')->url($path);

            // APP_URL is sometimes configured with a trailing slash. Avoid
            // returning https://example.com//storage/file.jpg.
            $storageUrl = preg_replace('#(?<!:)/{2,}#', '/', $storageUrl);

            return Str::startsWith($storageUrl, ['http://', 'https://'])
                ? $storageUrl
                : url($storageUrl);
        }

        if (Str::startsWith($path, 'storage/')) {
            return url($path);
        }

        return asset($path);
    }
}
