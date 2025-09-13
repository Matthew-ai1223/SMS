<?php
/**
 * File Upload Handler
 * Handles file uploads for school logos
 */

class FileUpload {
    private $upload_path;
    private $max_file_size;
    private $allowed_extensions;

    public function __construct() {
        $this->upload_path = UPLOAD_PATH;
        $this->max_file_size = MAX_FILE_SIZE;
        $this->allowed_extensions = ALLOWED_EXTENSIONS;
        
        // Create upload directory if it doesn't exist
        $this->createUploadDirectory();
    }

    /**
     * Create upload directory if it doesn't exist
     */
    private function createUploadDirectory() {
        if (!file_exists($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    /**
     * Upload school logo
     */
    public function uploadLogo($file) {
        try {
            // Ensure upload directory exists
            if (!file_exists($this->upload_path)) {
                mkdir($this->upload_path, 0777, true);
            }
            // Validate file
            $this->validateFile($file);

            // Generate unique filename
            $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $filename = 'logo_' . uniqid() . '_' . time() . '.' . $file_extension;
            $file_path = $this->upload_path . $filename;

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                return $filename;
            } else {
                throw new Exception('Failed to move uploaded file');
            }

        } catch (Exception $e) {
            throw new Exception('File upload failed: ' . $e->getMessage());
        }
    }

    /**
     * Validate uploaded file
     */
    private function validateFile($file) {
        // Check if file was uploaded
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('No file uploaded or upload error occurred');
        }

        // Check file size
        if ($file['size'] > $this->max_file_size) {
            throw new Exception('File size exceeds maximum allowed size of ' . ($this->max_file_size / 1024 / 1024) . 'MB');
        }

        // Check file extension
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($file_extension, $this->allowed_extensions)) {
            throw new Exception('File type not allowed. Allowed types: ' . implode(', ', $this->allowed_extensions));
        }

        // Check MIME type for security
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowed_mimes = [
            'image/jpeg',
            'image/jpg', 
            'image/png',
            'image/gif',
            'image/svg+xml'
        ];

        if (!in_array($mime_type, $allowed_mimes)) {
            throw new Exception('Invalid file type detected');
        }

        // Additional security check for images
        if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $image_info = getimagesize($file['tmp_name']);
            if ($image_info === false) {
                throw new Exception('Invalid image file');
            }
        }
    }

    /**
     * Delete uploaded file
     */
    public function deleteFile($filename) {
        $file_path = $this->upload_path . $filename;
        if (file_exists($file_path)) {
            return unlink($file_path);
        }
        return false;
    }

    /**
     * Get file URL
     */
    public function getFileUrl($filename) {
        return APP_URL . 'uploads/school_logos/' . $filename;
    }

    /**
     * Resize image if needed
     */
    public function resizeImage($file_path, $max_width = 300, $max_height = 300) {
        $image_info = getimagesize($file_path);
        if ($image_info === false) {
            return false;
        }

        $original_width = $image_info[0];
        $original_height = $image_info[1];
        $mime_type = $image_info['mime'];

        // Calculate new dimensions
        $ratio = min($max_width / $original_width, $max_height / $original_height);
        $new_width = intval($original_width * $ratio);
        $new_height = intval($original_height * $ratio);

        // Create image resource
        switch ($mime_type) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($file_path);
                break;
            case 'image/png':
                $source = imagecreatefrompng($file_path);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($file_path);
                break;
            default:
                return false;
        }

        // Create new image
        $resized = imagecreatetruecolor($new_width, $new_height);
        
        // Preserve transparency for PNG and GIF
        if ($mime_type == 'image/png' || $mime_type == 'image/gif') {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
            imagefilledrectangle($resized, 0, 0, $new_width, $new_height, $transparent);
        }

        // Resize image
        imagecopyresampled($resized, $source, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

        // Save resized image
        switch ($mime_type) {
            case 'image/jpeg':
                imagejpeg($resized, $file_path, 90);
                break;
            case 'image/png':
                imagepng($resized, $file_path, 9);
                break;
            case 'image/gif':
                imagegif($resized, $file_path);
                break;
        }

        // Clean up
        imagedestroy($source);
        imagedestroy($resized);

        return true;
    }
}
?>
