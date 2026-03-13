<?php

namespace App\Services;

use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use RuntimeException;

class FirebaseStorageService
{
    protected StorageClient $client;

    protected Bucket $bucket;

    protected string $bucketName;

    protected string $baseUrl;

    public function __construct()
    {
        $credentialsPath = config('services.firebase.credentials');
        $projectId = config('services.firebase.project_id');
        $this->bucketName = (string) config('services.firebase.storage_bucket');
        $this->baseUrl = rtrim((string) config('services.firebase.storage_base_url', ''), '/');

        if (empty($credentialsPath)) {
            throw new RuntimeException('FIREBASE_CREDENTIALS is not configured.');
        }

        if (! file_exists($credentialsPath)) {
            throw new RuntimeException('Firebase credentials file not found at: '.$credentialsPath);
        }

        if (empty($this->bucketName)) {
            throw new RuntimeException('FIREBASE_STORAGE_BUCKET is not configured.');
        }

        $config = [
            'keyFilePath' => $credentialsPath,
        ];

        if (! empty($projectId)) {
            $config['projectId'] = $projectId;
        }

        $this->client = new StorageClient($config);
        $this->bucket = $this->client->bucket($this->bucketName);
    }

    public function bucket(): Bucket
    {
        return $this->bucket;
    }

    public function upload(UploadedFile $file, string $folder = 'uploads', ?string $filename = null): string
    {
        $folder = trim($folder, '/');
        $filename = $filename ?: $this->generateFilename($file);
        $objectPath = ltrim(($folder !== '' ? $folder.'/' : '').$filename, '/');

        $stream = fopen($file->getRealPath(), 'r');

        if ($stream === false) {
            throw new RuntimeException('Unable to read uploaded file for Firebase Storage upload.');
        }

        try {
            $options = [
                'name' => $objectPath,
            ];

            if ($mimeType = $file->getMimeType()) {
                $options['metadata'] = [
                    'contentType' => $mimeType,
                ];
            }

            $this->bucket->upload($stream, $options);
        } finally {
            fclose($stream);
        }

        return $this->publicUrl($objectPath);
    }

    public function delete(?string $path): bool
    {
        $objectPath = $this->extractObjectPath($path);

        if (empty($objectPath)) {
            return false;
        }

        $object = $this->bucket->object($objectPath);

        if (! $object->exists()) {
            return false;
        }

        $object->delete();

        return true;
    }

    public function publicUrl(string $objectPath): string
    {
        $objectPath = ltrim($objectPath, '/');

        if ($this->baseUrl !== '') {
            return $this->baseUrl.'/'.$this->encodeObjectPath($objectPath);
        }

        return sprintf(
            'https://storage.googleapis.com/%s/%s',
            $this->bucketName,
            $this->encodeObjectPath($objectPath)
        );
    }

    protected function generateFilename(UploadedFile $file): string
    {
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $slug = Str::slug($name);
        $slug = $slug !== '' ? $slug : 'file';

        return $slug.'-'.time().'-'.Str::lower(Str::random(8)).($extension ? '.'.$extension : '');
    }

    protected function extractObjectPath(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        $path = trim($path);

        if (! Str::startsWith($path, ['http://', 'https://'])) {
            return ltrim($path, '/');
        }

        $parsed = parse_url($path);
        $parsedPath = $parsed['path'] ?? '';
        $parsedPath = ltrim($parsedPath, '/');

        if ($parsedPath === '') {
            return '';
        }

        if (Str::startsWith($parsedPath, $this->bucketName.'/')) {
            return substr($parsedPath, strlen($this->bucketName) + 1);
        }

        return $parsedPath;
    }

    protected function encodeObjectPath(string $objectPath): string
    {
        return implode('/', array_map('rawurlencode', explode('/', $objectPath)));
    }
}
