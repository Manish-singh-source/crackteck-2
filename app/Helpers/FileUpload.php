<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class FileUpload
{
    public function fileUpload(UploadedFile $file, string $path = ''): string
    {
        // Use default path if empty
        $path = !empty($path) ? $path : 'uploads/crm/amc/brochure/';

        // Ensure path ends with slash
        if (!str_ends_with($path, '/')) {
            $path .= '/';
        }

        // Create directory if it doesn't exist
        $fullPath = public_path($path);
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move($fullPath, $filename);

        return $path . $filename;
    }

    /**
     * Update an existing file by deleting the old one and uploading the new one
     * 
     * @param UploadedFile $file The new file to upload
     * @param string $oldFilePath The path of the old file to delete
     * @param string $path The directory path where the file will be stored
     * @return string The path to the newly uploaded file
     */
    public function updateFileUpload(UploadedFile $file, string $oldFilePath = '', string $path = ''): string
    {
        // Delete old file if it exists
        if (!empty($oldFilePath) && file_exists(public_path($oldFilePath))) {
            @unlink(public_path($oldFilePath));
        }

        // Upload new file using existing method
        return $this->fileUpload($file, $path);
    }
}
