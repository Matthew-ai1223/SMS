<?php
/**
 * School Class
 * Handles school registration and management
 */

require_once '../config/config.php';

class School {
    private $conn;
    private $table_name = "schools";

    public function __construct($database) {
        $this->conn = $database;
    }

    /**
     * Register a new school
     */
    public function register($data) {
        try {
            $this->conn->beginTransaction();

            // Insert school data
            $query = "INSERT INTO " . $this->table_name . " 
                     (school_name, school_email, school_location, school_logo, 
                      website_url, has_website, admin_phone, admin_email) 
                     VALUES (:school_name, :school_email, :school_location, :school_logo, 
                             :website_url, :has_website, :admin_phone, :admin_email)";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':school_name', $data['school_name']);
            $stmt->bindParam(':school_email', $data['school_email']);
            $stmt->bindParam(':school_location', $data['school_location']);
            $stmt->bindParam(':school_logo', $data['school_logo']);
            $stmt->bindParam(':website_url', $data['website_url']);
            $stmt->bindParam(':has_website', $data['has_website']);
            $stmt->bindParam(':admin_phone', $data['admin_phone']);
            $stmt->bindParam(':admin_email', $data['admin_email']);

            $stmt->execute();
            $school_id = $this->conn->lastInsertId();

            // Insert selected features
            if (!empty($data['features'])) {
                $this->insertFeatures($school_id, $data['features']);
            }

            // Log registration
            $this->logRegistration($school_id, 'registration', 'School registered successfully');

            $this->conn->commit();
            return $school_id;

        } catch (Exception $e) {
            $this->conn->rollBack();
            throw new Exception("Registration failed: " . $e->getMessage());
        }
    }

    /**
     * Insert school features
     */
    private function insertFeatures($school_id, $features) {
        $query = "INSERT INTO school_features (school_id, feature_name, feature_value) VALUES (:school_id, :feature_name, :feature_value)";
        $stmt = $this->conn->prepare($query);

        foreach ($features as $feature) {
            $stmt->bindParam(':school_id', $school_id);
            $stmt->bindParam(':feature_name', $feature);
            $stmt->bindParam(':feature_value', $feature);
            $stmt->execute();
        }
    }

    /**
     * Log registration activity
     */
    private function logRegistration($school_id, $action, $details) {
        $query = "INSERT INTO registration_logs (school_id, action, details, ip_address, user_agent) 
                 VALUES (:school_id, :action, :details, :ip_address, :user_agent)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':school_id', $school_id);
        $stmt->bindParam(':action', $action);
        $stmt->bindParam(':details', $details);
        $stmt->bindParam(':ip_address', $_SERVER['REMOTE_ADDR']);
        $stmt->bindParam(':user_agent', $_SERVER['HTTP_USER_AGENT']);
        $stmt->execute();
    }

    /**
     * Check if school email already exists
     */
    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE school_email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    /**
     * Get school by ID
     */
    public function getSchoolById($id) {
        $query = "SELECT s.*, GROUP_CONCAT(sf.feature_name) as features 
                  FROM " . $this->table_name . " s 
                  LEFT JOIN school_features sf ON s.id = sf.school_id 
                  WHERE s.id = :id 
                  GROUP BY s.id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    /**
     * Get all schools with pagination
     */
    public function getAllSchools($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        
        $query = "SELECT s.*, GROUP_CONCAT(sf.feature_name) as features 
                  FROM " . $this->table_name . " s 
                  LEFT JOIN school_features sf ON s.id = sf.school_id 
                  GROUP BY s.id 
                  ORDER BY s.created_at DESC 
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    /**
     * Update school status
     */
    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    /**
     * Get available features
     */
    public function getAvailableFeatures() {
        $query = "SELECT * FROM available_features WHERE is_active = 1 ORDER BY feature_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}
?>
