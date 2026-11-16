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
        // the public storage symlink, not directly from public/.
        if (Str::startsWith($path, ['diagnosis_photos/', 'kyc_documents/'])) {
            return url(Storage::disk('public')->url($path));
        }

        if (Str::startsWith($path, 'storage/')) {
            return url($path);
        }

        return asset($path);
    }
}
