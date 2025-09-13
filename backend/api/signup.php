<?php
/**
 * School Registration API Endpoint
 * Handles form submission from signup.php
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/config.php';
require_once '../classes/School.php';
require_once '../classes/FileUpload.php';
require_once '../classes/EmailNotification.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Log incoming POST and FILES data for debugging
file_put_contents(__DIR__ . '/signup_debug.log',
    "POST: " . print_r($_POST, true) .
    "\nFILES: " . print_r($_FILES, true) .
    "\n---\n",
    FILE_APPEND
);

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    error_log('Database connection failed');
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Initialize classes
$school = new School($db);
$fileUpload = new FileUpload();
$emailNotification = new EmailNotification($db);

// Handle only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Validate and sanitize input data
    $data = validateAndSanitizeInput();
    
    // Check if school email already exists
    if ($school->emailExists($data['school_email'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'School email already exists']);
        exit;
    }
    
    // Handle file upload if logo is provided
    if (isset($_FILES['schoolLogo']) && $_FILES['schoolLogo']['error'] === UPLOAD_ERR_OK) {
        try {
            $data['school_logo'] = $fileUpload->uploadLogo($_FILES['schoolLogo']);
            
            // Resize image if it's too large
            $file_path = UPLOAD_PATH . $data['school_logo'];
            $fileUpload->resizeImage($file_path, 300, 300);
            
        } catch (Exception $e) {
            error_log('File upload failed: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'File upload failed: ' . $e->getMessage()]);
            exit;
        }
    } else {
        $data['school_logo'] = null;
    }
    
    // Register the school
    try {
        $school_id = $school->register($data);
    } catch (Exception $e) {
        error_log('Registration failed: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()]);
        exit;
    }
    
    // Get school data for email
    $school_data = $school->getSchoolById($school_id);
    
    // Send confirmation email to school
    try {
        $emailNotification->sendRegistrationConfirmation($school_data);
    } catch (Exception $e) {
        // Log email error but don't fail registration
        error_log('Email sending failed: ' . $e->getMessage());
    }
    
    // Send notification to admin
    try {
        $emailNotification->sendAdminNotification($school_data);
    } catch (Exception $e) {
        // Log email error but don't fail registration
        error_log('Admin notification failed: ' . $e->getMessage());
    }
    
    // Return success response
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'School registration completed successfully',
        'school_id' => $school_id,
        'data' => [
            'school_name' => $data['school_name'],
            'school_email' => $data['school_email'],
            'status' => 'pending'
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()]);
}

/**
 * Validate and sanitize input data
 */
function validateAndSanitizeInput() {
    $data = [];
    $errors = [];
    
    // Required fields
    $required_fields = [
        'schoolName' => 'School Name',
        'schoolEmail' => 'School Email',
        'schoolLocation' => 'School Location',
        'adminPhone' => 'Admin Phone',
        'adminEmail' => 'Admin Email'
    ];
    
    // Validate required fields
    foreach ($required_fields as $field => $label) {
        if (empty($_POST[$field])) {
            $errors[] = $label . ' is required';
        } else {
            $data[strtolower(str_replace(' ', '_', $field))] = trim($_POST[$field]);
        }
    }
    
    // Validate email formats
    if (!empty($data['school_email']) && !filter_var($data['school_email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid school email format';
    }
    
    if (!empty($data['admin_email']) && !filter_var($data['admin_email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid admin email format';
    }
    
    // Validate phone number
    if (!empty($data['admin_phone'])) {
        $phone = preg_replace('/[^0-9+]/', '', $data['admin_phone']);
        if (strlen($phone) < 10) {
            $errors[] = 'Invalid phone number format';
        }
    }
    
    // Validate website URL if provided
    if (!empty($_POST['websiteUrl'])) {
        if (!filter_var($_POST['websiteUrl'], FILTER_VALIDATE_URL)) {
            $errors[] = 'Invalid website URL format';
        } else {
            $data['website_url'] = trim($_POST['websiteUrl']);
        }
    } else {
        $data['website_url'] = null;
    }
    
    // Validate has website field
    if (empty($_POST['hasWebsite']) || !in_array($_POST['hasWebsite'], ['yes', 'no'])) {
        $errors[] = 'Please specify if school has a website';
    } else {
        $data['has_website'] = $_POST['hasWebsite'];
    }
    
    // Validate features selection
    if (empty($_POST['features']) || !is_array($_POST['features'])) {
        $errors[] = 'Please select at least one feature';
    } else {
        $data['features'] = $_POST['features'];
        
        // Validate feature values
        $valid_features = [
            'student_management',
            'teacher_portal', 
            'academic_calendar',
            'analytics_reports',
            'mobile_access',
            'cbt_system',
            'payment_system',
            'security_reliable'
        ];
        
        foreach ($data['features'] as $feature) {
            if (!in_array($feature, $valid_features)) {
                $errors[] = 'Invalid feature selected: ' . $feature;
            }
        }
    }
    
    // If there are validation errors, throw exception
    if (!empty($errors)) {
        throw new Exception('Validation failed: ' . implode(', ', $errors));
    }
    
    // Sanitize string data
    $string_fields = ['school_name', 'school_email', 'school_location', 'admin_phone', 'admin_email'];
    foreach ($string_fields as $field) {
        if (isset($data[$field])) {
            $data[$field] = htmlspecialchars($data[$field], ENT_QUOTES, 'UTF-8');
        }
    }
    
    return $data;
}
?>
