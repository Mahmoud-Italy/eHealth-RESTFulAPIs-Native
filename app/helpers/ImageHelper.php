<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Validates and resizes an uploaded image.
     *
     * @param array $file The uploaded file ($_FILES['key']).
     * @param string $targetDir The directory where the image should be saved.
     * @param int $maxWidth The maximum width of the resized image.
     * @param int $maxHeight The maximum height of the resized image.
     * @return string|null The path to the saved image or null if the upload fails.
     */
    public static function processImage(array $file, string $targetDir, int $maxWidth = 800, int $maxHeight = 800): ?string
    {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return null; // Invalid file upload
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return null; // Unsupported file type
        }

        // Generate a unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('medication_', true) . '.' . $extension;
        $targetPath = rtrim($targetDir, '/') . '/' . $filename;

        // Load the image
        switch ($file['type']) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($file['tmp_name']);
                break;
            case 'image/png':
                $image = imagecreatefrompng($file['tmp_name']);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($file['tmp_name']);
                break;
            default:
                return null;
        }

        if (!$image) {
            return null; // Failed to load image
        }

        // Get the original dimensions
        list($width, $height) = getimagesize($file['tmp_name']);

        // Calculate new dimensions
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = (int)($width * $ratio);
        $newHeight = (int)($height * $ratio);

        // Resize the image
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save the resized image
        switch ($file['type']) {
            case 'image/jpeg':
                imagejpeg($resizedImage, $targetPath, 85); // 85% quality for JPEG
                break;
            case 'image/png':
                imagepng($resizedImage, $targetPath);
                break;
            case 'image/gif':
                imagegif($resizedImage, $targetPath);
                break;
        }

        // Clean up resources
        imagedestroy($image);
        imagedestroy($resizedImage);

        return $targetPath;
    }
}
