<?php

namespace App\Http\Middleware;

use App\Support\ApiMediaUrl;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Adds absolute, client-ready URLs for every persisted media field in API JSON. */
class ExposeApiMediaUrls
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $response instanceof JsonResponse) {
            return $response;
        }

        $data = $response->getData(true);
        $response->setData($this->transform($data));

        return $response;
    }

    private function transform(mixed $value, ?string $key = null): mixed
    {
        if (is_array($value)) {
            $result = [];
            foreach ($value as $itemKey => $itemValue) {
                $field = is_string($itemKey) ? $itemKey : $key;
                $result[$itemKey] = $this->transform($itemValue, $field);

                if (is_string($itemKey) && $this->isMediaField($itemKey) && ! str_ends_with($itemKey, '_url')) {
                    $result[$itemKey.'_url'] = $this->urlValue($itemValue);
                }
            }

            return $result;
        }

        // Several legacy columns store a JSON array/object in a text field.
        // Decode only media fields so non-media API contracts stay unchanged.
        if (is_string($value) && $key && $this->isMediaField($key)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $this->transform($decoded, $key);
            }
        }

        return $value;
    }

    private function urlValue(mixed $value): mixed
    {
        if (is_array($value)) {
            return array_map(fn ($item) => is_string($item) ? ApiMediaUrl::make($item) : $this->urlValue($item), $value);
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $this->urlValue($decoded);
            }

            return ApiMediaUrl::make($value);
        }

        return null;
    }

    private function isMediaField(string $key): bool
    {
        $key = strtolower($key);

        return str_contains($key, 'image')
            || str_contains($key, 'photo')
            || str_contains($key, 'profile')
            || str_contains($key, 'receipt')
            || str_contains($key, 'document_file')
            || str_contains($key, 'certificate')
            || str_contains($key, 'passbook')
            || str_contains($key, 'address_proof')
            || str_ends_with($key, '_path');
    }
}
