<?php
/**
 * Application Configuration
 * EduManage Pro - School Management System
 */

// Application Settings
define('APP_NAME', 'EduManage Pro');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/new files/SMS/');

// File Upload Settings
// Use absolute path for reliability
// Make sure this directory exists and is writable by the web server
// Example for XAMPP: C:/xampp/htdocs/new files/SMS/backend/uploads/school_logos/
define('UPLOAD_PATH', __DIR__ . '/../uploads/school_logos/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'svg']);

// Email Settings
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-app-password');
define('FROM_EMAIL', 'noreply@edumanagepro.com');
define('FROM_NAME', 'EduManage Pro');

// Security Settings
define('ENCRYPTION_KEY', 'your-secret-key-here');
define('JWT_SECRET', 'your-jwt-secret-key');

// Timezone
date_default_timezone_set('UTC');

// Error Reporting (Set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session Settings
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 for HTTPS

// Include database configuration
require_once 'database.php';
?>
