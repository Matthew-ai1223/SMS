<?php
/**
 * Admin Dashboard API
 * Provides data for the admin dashboard
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once '../../config/config.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

try {
    // Get statistics
    $stats = getStatistics($db);
    
    // Get recent schools
    $schools = getRecentSchools($db);
    
    echo json_encode([
        'success' => true,
        'stats' => $stats,
        'schools' => $schools
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to load dashboard data: ' . $e->getMessage()]);
}

/**
 * Get dashboard statistics
 */
function getStatistics($db) {
    $stats = [];
    
    // Total schools
    $query = "SELECT COUNT(*) as total FROM schools";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stats['total'] = $stmt->fetch()['total'];
    
    // Pending schools
    $query = "SELECT COUNT(*) as pending FROM schools WHERE status = 'pending'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stats['pending'] = $stmt->fetch()['pending'];
    
    // Approved schools
    $query = "SELECT COUNT(*) as approved FROM schools WHERE status = 'approved'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stats['approved'] = $stmt->fetch()['approved'];
    
    // Rejected schools
    $query = "SELECT COUNT(*) as rejected FROM schools WHERE status = 'rejected'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stats['rejected'] = $stmt->fetch()['rejected'];
    
    return $stats;
}

/**
 * Get recent school registrations
 */
function getRecentSchools($db) {
    $query = "SELECT s.*, GROUP_CONCAT(sf.feature_name) as features 
              FROM schools s 
              LEFT JOIN school_features sf ON s.id = sf.school_id 
              GROUP BY s.id 
              ORDER BY s.created_at DESC 
              LIMIT 20";
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $schools = $stmt->fetchAll();
    
    // Format features
    foreach ($schools as &$school) {
        $school['features'] = $school['features'] ? explode(',', $school['features']) : [];
    }
    
    return $schools;
}
?>
