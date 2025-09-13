-- EduManage Pro Database Schema
-- School Management System

CREATE DATABASE IF NOT EXISTS edumanage_pro;
USE edumanage_pro;

-- Schools table
CREATE TABLE schools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    school_name VARCHAR(255) NOT NULL,
    school_email VARCHAR(255) NOT NULL UNIQUE,
    school_location TEXT NOT NULL,
    school_logo VARCHAR(255) NULL,
    website_url VARCHAR(500) NULL,
    has_website ENUM('yes', 'no') DEFAULT 'no',
    admin_phone VARCHAR(20) NOT NULL,
    admin_email VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'rejected', 'active') DEFAULT 'pending',
    academic_year VARCHAR(20) NULL,
    school_type ENUM('primary', 'secondary', 'high_school', 'college', 'university', 'mixed') NULL,
    curriculum ENUM('national', 'international', 'montessori', 'waldorf', 'british', 'american', 'other') NULL,
    school_motto VARCHAR(500) NULL,
    timezone VARCHAR(50) NULL,
    language VARCHAR(10) NULL,
    setup_completed BOOLEAN DEFAULT FALSE,
    setup_date TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_school_email (school_email),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    INDEX idx_setup_completed (setup_completed)
);

-- School features table
CREATE TABLE school_features (
    id INT AUTO_INCREMENT PRIMARY KEY,
    school_id INT NOT NULL,
    feature_name VARCHAR(100) NOT NULL,
    feature_value VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    INDEX idx_school_id (school_id),
    INDEX idx_feature_name (feature_name)
);

-- Available features table
CREATE TABLE available_features (
    id INT AUTO_INCREMENT PRIMARY KEY,
    feature_key VARCHAR(50) NOT NULL UNIQUE,
    feature_name VARCHAR(100) NOT NULL,
    feature_description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default features
INSERT INTO available_features (feature_key, feature_name, feature_description) VALUES
('student_management', 'Student Management', 'Complete student lifecycle management from enrollment to graduation'),
('teacher_portal', 'Teacher Portal', 'Tools for teachers including attendance, grading, and communication'),
('academic_calendar', 'Academic Calendar', 'Schedule and event management system'),
('analytics_reports', 'Analytics & Reports', 'Comprehensive reporting and analytics dashboard'),
('mobile_access', 'Mobile Access', 'Mobile-friendly interface and app access'),
('cbt_system', 'CBT System', 'Computer-Based Testing platform'),
('payment_system', 'Payment System', 'Integrated payment gateway and billing'),
('security_reliable', 'Security & Reliability', 'Enterprise-grade security features');

-- Admin users table
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    school_id INT NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    role ENUM('super_admin', 'school_admin', 'teacher') DEFAULT 'school_admin',
    is_active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_school_id (school_id)
);

-- Registration logs table
CREATE TABLE registration_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    school_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    details TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    INDEX idx_school_id (school_id),
    INDEX idx_action (action),
    INDEX idx_created_at (created_at)
);

-- Email notifications table
CREATE TABLE email_notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    school_id INT NOT NULL,
    email_type VARCHAR(50) NOT NULL,
    recipient_email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('pending', 'sent', 'failed') DEFAULT 'pending',
    sent_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    INDEX idx_school_id (school_id),
    INDEX idx_status (status),
    INDEX idx_email_type (email_type)
);
