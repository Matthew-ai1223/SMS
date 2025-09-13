<?php
/**
 * School Setup API
 * Handles school setup configuration
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/config.php';
require_once '../classes/School.php';
require_once '../classes/EmailNotification.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Handle only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Validate and sanitize input data
    $data = validateAndSanitizeInput();
    
    // Initialize School class
    $school = new School($db);
    
    // Check if school exists
    $school_data = $school->getSchoolById($data['school_id']);
    if (!$school_data) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'School not found']);
        exit;
    }
    
    // Update school with setup data
    $success = updateSchoolSetup($db, $data);
    
    if ($success) {
        // Create admin user
        $admin_user_id = createAdminUser($db, $data);
        
        // Update school status to active
        $school->updateStatus($data['school_id'], 'active');
        
        // Log setup completion
        $school->logRegistration($data['school_id'], 'setup_completed', 'School setup completed successfully');
        
        // Send setup completion email
        try {
            $emailNotification = new EmailNotification($db);
            $emailNotification->sendSetupCompletionEmail($school_data, $data);
        } catch (Exception $e) {
            error_log('Setup completion email failed: ' . $e->getMessage());
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'School setup completed successfully',
            'admin_user_id' => $admin_user_id
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to complete school setup']);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Setup failed: ' . $e->getMessage()]);
}

/**
 * Validate and sanitize input data
 */
function validateAndSanitizeInput() {
    $data = [];
    $errors = [];
    
    // Required fields
    $required_fields = [
        'school_id' => 'School ID',
        'academic_year' => 'Academic Year',
        'school_type' => 'School Type',
        'curriculum' => 'Curriculum',
        'timezone' => 'Timezone',
        'language' => 'Language',
        'admin_first_name' => 'Admin First Name',
        'admin_last_name' => 'Admin Last Name',
        'admin_username' => 'Admin Username',
        'admin_password' => 'Admin Password'
    ];
    
    // Validate required fields
    foreach ($required_fields as $field => $label) {
        if (empty($_POST[$field])) {
            $errors[] = $label . ' is required';
        } else {
            $data[$field] = trim($_POST[$field]);
        }
    }
    
    // Validate school ID
    if (!empty($data['school_id']) && !is_numeric($data['school_id'])) {
        $errors[] = 'Invalid school ID';
    }
    
    // Validate password strength
    if (!empty($data['admin_password'])) {
        if (strlen($data['admin_password']) < 8) {
            $errors[] = 'Password must be at least 8 characters long';
        }
        if (!preg_match('/[A-Z]/', $data['admin_password'])) {
            $errors[] = 'Password must contain at least one uppercase letter';
        }
        if (!preg_match('/[a-z]/', $data['admin_password'])) {
            $errors[] = 'Password must contain at least one lowercase letter';
        }
        if (!preg_match('/\d/', $data['admin_password'])) {
            $errors[] = 'Password must contain at least one number';
        }
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $data['admin_password'])) {
            $errors[] = 'Password must contain at least one special character';
        }
    }
    
    // Validate username
    if (!empty($data['admin_username'])) {
        if (strlen($data['admin_username']) < 3) {
            $errors[] = 'Username must be at least 3 characters long';
        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $data['admin_username'])) {
            $errors[] = 'Username can only contain letters, numbers, and underscores';
        }
    }
    
    // Optional fields
    $data['school_motto'] = !empty($_POST['school_motto']) ? trim($_POST['school_motto']) : null;
    $data['features'] = !empty($_POST['features']) ? $_POST['features'] : [];
    
    // If there are validation errors, throw exception
    if (!empty($errors)) {
        throw new Exception('Validation failed: ' . implode(', ', $errors));
    }
    
    // Sanitize string data
    $string_fields = ['academic_year', 'school_type', 'curriculum', 'school_motto', 'timezone', 'language', 'admin_first_name', 'admin_last_name', 'admin_username'];
    foreach ($string_fields as $field) {
        if (isset($data[$field])) {
            $data[$field] = htmlspecialchars($data[$field], ENT_QUOTES, 'UTF-8');
        }
    }
    
    return $data;
}

/**
 * Update school with setup data
 */
function updateSchoolSetup($db, $data) {
    try {
        $db->beginTransaction();
        
        // Update school table with setup data
        $query = "UPDATE schools SET 
                 academic_year = :academic_year,
                 school_type = :school_type,
                 curriculum = :curriculum,
                 school_motto = :school_motto,
                 timezone = :timezone,
                 language = :language,
                 setup_completed = 1,
                 setup_date = NOW()
                 WHERE id = :school_id";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':academic_year', $data['academic_year']);
        $stmt->bindParam(':school_type', $data['school_type']);
        $stmt->bindParam(':curriculum', $data['curriculum']);
        $stmt->bindParam(':school_motto', $data['school_motto']);
        $stmt->bindParam(':timezone', $data['timezone']);
        $stmt->bindParam(':language', $data['language']);
        $stmt->bindParam(':school_id', $data['school_id']);
        
        $stmt->execute();
        
        // Update school features if provided
        if (!empty($data['features'])) {
            // Delete existing features
            $delete_query = "DELETE FROM school_features WHERE school_id = :school_id";
            $delete_stmt = $db->prepare($delete_query);
            $delete_stmt->bindParam(':school_id', $data['school_id']);
            $delete_stmt->execute();
            
            // Insert new features
            $insert_query = "INSERT INTO school_features (school_id, feature_name, feature_value) VALUES (:school_id, :feature_name, :feature_value)";
            $insert_stmt = $db->prepare($insert_query);
            
            foreach ($data['features'] as $feature) {
                $insert_stmt->bindParam(':school_id', $data['school_id']);
                $insert_stmt->bindParam(':feature_name', $feature);
                $insert_stmt->bindParam(':feature_value', $feature);
                $insert_stmt->execute();
            }
        }
        
        $db->commit();
        return true;
        
    } catch (Exception $e) {
        $db->rollBack();
        throw new Exception('Failed to update school setup: ' . $e->getMessage());
    }
}

/**
 * Create admin user
 */
function createAdminUser($db, $data) {
    // Check if username already exists
    $check_query = "SELECT id FROM admin_users WHERE username = :username";
    $check_stmt = $db->prepare($check_query);
    $check_stmt->bindParam(':username', $data['admin_username']);
    $check_stmt->execute();
    
    if ($check_stmt->rowCount() > 0) {
        throw new Exception('Username already exists');
    }
    
    // Hash password
    $password_hash = password_hash($data['admin_password'], PASSWORD_DEFAULT);
    
    // Insert admin user
    $query = "INSERT INTO admin_users 
             (school_id, username, email, password_hash, first_name, last_name, role, is_active) 
             VALUES (:school_id, :username, :email, :password_hash, :first_name, :last_name, 'school_admin', 1)";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':school_id', $data['school_id']);
    $stmt->bindParam(':username', $data['admin_username']);
    $stmt->bindParam(':email', $data['school_id']); // Use school email for now
    $stmt->bindParam(':password_hash', $password_hash);
    $stmt->bindParam(':first_name', $data['admin_first_name']);
    $stmt->bindParam(':last_name', $data['admin_last_name']);
    
    $stmt->execute();
    return $db->lastInsertId();
}
?>
