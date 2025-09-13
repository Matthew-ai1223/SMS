<?php
/**
 * School Data API
 * Retrieves school information for setup page
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once '../config/config.php';
require_once '../classes/School.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Handle only GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get school ID from URL parameter
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'School ID is required']);
        exit;
    }

    $school_id = intval($_GET['id']);

    // Initialize School class
    $school = new School($db);

    // Get school data
    $school_data = $school->getSchoolById($school_id);

    if (!$school_data) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'School not found']);
        exit;
    }

    // Format features
    $school_data['features'] = $school_data['features'] ? explode(',', $school_data['features']) : [];

    echo json_encode([
        'success' => true,
        'school' => $school_data
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to retrieve school data: ' . $e->getMessage()]);
}
?>
