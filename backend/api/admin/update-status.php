<?php
/**
 * Update School Status API
 * Handles school approval/rejection
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../../config/config.php';
require_once '../../classes/School.php';

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
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['school_id']) || !isset($input['status'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
        exit;
    }
    
    $school_id = $input['school_id'];
    $status = $input['status'];
    
    // Validate status
    if (!in_array($status, ['pending', 'approved', 'rejected', 'active'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid status']);
        exit;
    }
    
    // Initialize School class
    $school = new School($db);
    
    // Update school status
    $success = $school->updateStatus($school_id, $status);
    
    if ($success) {
        // Log the status change
        $school->logRegistration($school_id, 'status_change', "Status changed to: $status");
        
        // Send notification email if approved
        if ($status === 'approved') {
            try {
                $school_data = $school->getSchoolById($school_id);
                $emailNotification = new EmailNotification($db);
                $emailNotification->sendApprovalNotification($school_data);
            } catch (Exception $e) {
                error_log('Approval email failed: ' . $e->getMessage());
            }
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'School status updated successfully',
            'status' => $status
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to update school status']);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Update failed: ' . $e->getMessage()]);
}
?>
