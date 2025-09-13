<?php
/**
 * Email Notification Handler
 * Handles email notifications for school registration
 */

require_once '../config/config.php';

class EmailNotification {
    private $conn;
    private $smtp_host;
    private $smtp_port;
    private $smtp_username;
    private $smtp_password;
    private $from_email;
    private $from_name;

    public function __construct($database) {
        $this->conn = $database;
        $this->smtp_host = SMTP_HOST;
        $this->smtp_port = SMTP_PORT;
        $this->smtp_username = SMTP_USERNAME;
        $this->smtp_password = SMTP_PASSWORD;
        $this->from_email = FROM_EMAIL;
        $this->from_name = FROM_NAME;
    }

    /**
     * Send registration confirmation email
     */
    public function sendRegistrationConfirmation($school_data) {
        $subject = "Registration Confirmation - " . APP_NAME;
        
        $message = $this->getRegistrationEmailTemplate($school_data);
        
        return $this->sendEmail(
            $school_data['admin_email'],
            $subject,
            $message,
            'registration_confirmation',
            $school_data['id']
        );
    }

    /**
     * Send admin notification email
     */
    public function sendAdminNotification($school_data) {
        $admin_email = 'admin@edumanagepro.com'; // Replace with actual admin email
        $subject = "New School Registration - " . $school_data['school_name'];
        
        $message = $this->getAdminNotificationTemplate($school_data);
        
        return $this->sendEmail(
            $admin_email,
            $subject,
            $message,
            'admin_notification',
            $school_data['id']
        );
    }

    /**
     * Send setup completion email
     */
    public function sendSetupCompletionEmail($school_data, $setup_data) {
        $subject = "Setup Complete - Welcome to EduManage Pro!";
        
        $message = $this->getSetupCompletionTemplate($school_data, $setup_data);
        
        return $this->sendEmail(
            $school_data['admin_email'],
            $subject,
            $message,
            'setup_completion',
            $school_data['id']
        );
    }

    /**
     * Send email using SMTP
     */
    private function sendEmail($to, $subject, $message, $email_type, $school_id) {
        try {
            // Log email to database
            $this->logEmail($school_id, $email_type, $to, $subject, $message);

            // For now, we'll use PHP's mail() function
            // In production, you should use PHPMailer or similar library
            $headers = [
                'From: ' . $this->from_name . ' <' . $this->from_email . '>',
                'Reply-To: ' . $this->from_email,
                'X-Mailer: PHP/' . phpversion(),
                'MIME-Version: 1.0',
                'Content-Type: text/html; charset=UTF-8'
            ];

            $success = mail($to, $subject, $message, implode("\r\n", $headers));

            // Update email status
            $this->updateEmailStatus($school_id, $email_type, $success ? 'sent' : 'failed');

            return $success;

        } catch (Exception $e) {
            $this->updateEmailStatus($school_id, $email_type, 'failed');
            throw new Exception('Email sending failed: ' . $e->getMessage());
        }
    }

    /**
     * Log email to database
     */
    private function logEmail($school_id, $email_type, $recipient, $subject, $message) {
        $query = "INSERT INTO email_notifications (school_id, email_type, recipient_email, subject, message) 
                 VALUES (:school_id, :email_type, :recipient, :subject, :message)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':school_id', $school_id);
        $stmt->bindParam(':email_type', $email_type);
        $stmt->bindParam(':recipient', $recipient);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
    }

    /**
     * Update email status
     */
    private function updateEmailStatus($school_id, $email_type, $status) {
        $query = "UPDATE email_notifications 
                 SET status = :status, sent_at = :sent_at 
                 WHERE school_id = :school_id AND email_type = :email_type 
                 ORDER BY created_at DESC LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':sent_at', $status === 'sent' ? date('Y-m-d H:i:s') : null);
        $stmt->bindParam(':school_id', $school_id);
        $stmt->bindParam(':email_type', $email_type);
        $stmt->execute();
    }

    /**
     * Get registration confirmation email template
     */
    private function getRegistrationEmailTemplate($school_data) {
        $features = !empty($school_data['features']) ? implode(', ', $school_data['features']) : 'None selected';
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Registration Confirmation</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #3b82f6, #1e40af); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8fafc; padding: 30px; border-radius: 0 0 10px 10px; }
                .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                .info-table th, .info-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
                .info-table th { background: #3b82f6; color: white; }
                .footer { text-align: center; margin-top: 30px; color: #64748b; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🎓 Registration Confirmed!</h1>
                    <p>Welcome to EduManage Pro</p>
                </div>
                <div class='content'>
                    <h2>Dear " . htmlspecialchars($school_data['school_name']) . ",</h2>
                    <p>Thank you for registering with EduManage Pro! Your school registration has been received and is currently under review.</p>
                    
                    <h3>Registration Details:</h3>
                    <table class='info-table'>
                        <tr><th>School Name</th><td>" . htmlspecialchars($school_data['school_name']) . "</td></tr>
                        <tr><th>School Email</th><td>" . htmlspecialchars($school_data['school_email']) . "</td></tr>
                        <tr><th>Location</th><td>" . htmlspecialchars($school_data['school_location']) . "</td></tr>
                        <tr><th>Admin Contact</th><td>" . htmlspecialchars($school_data['admin_email']) . "</td></tr>
                        <tr><th>Phone</th><td>" . htmlspecialchars($school_data['admin_phone']) . "</td></tr>
                        <tr><th>Selected Features</th><td>" . htmlspecialchars($features) . "</td></tr>
                        <tr><th>Registration Date</th><td>" . date('F j, Y \a\t g:i A') . "</td></tr>
                    </table>
                    
                    <h3>What's Next?</h3>
                    <ul>
                        <li>Our team will review your registration within 24 hours</li>
                        <li>You'll receive an email with your login credentials</li>
                        <li>We'll schedule a setup call to configure your school's features</li>
                        <li>Your school will be ready to use EduManage Pro!</li>
                    </ul>
                    
                    <p>If you have any questions, please don't hesitate to contact our support team.</p>
                </div>
                <div class='footer'>
                    <p>© 2024 EduManage Pro. All rights reserved.</p>
                    <p>This is an automated message. Please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Get admin notification email template
     */
    private function getAdminNotificationTemplate($school_data) {
        $features = !empty($school_data['features']) ? implode(', ', $school_data['features']) : 'None selected';
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>New School Registration</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #ef4444; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8fafc; padding: 30px; border-radius: 0 0 10px 10px; }
                .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                .info-table th, .info-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
                .info-table th { background: #3b82f6; color: white; }
                .action-buttons { text-align: center; margin: 30px 0; }
                .btn { display: inline-block; padding: 12px 24px; margin: 0 10px; text-decoration: none; border-radius: 6px; font-weight: bold; }
                .btn-approve { background: #10b981; color: white; }
                .btn-reject { background: #ef4444; color: white; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🚨 New School Registration</h1>
                    <p>Action Required</p>
                </div>
                <div class='content'>
                    <h2>New School Registration Received</h2>
                    <p>A new school has registered for EduManage Pro and requires your review.</p>
                    
                    <h3>School Details:</h3>
                    <table class='info-table'>
                        <tr><th>School Name</th><td>" . htmlspecialchars($school_data['school_name']) . "</td></tr>
                        <tr><th>School Email</th><td>" . htmlspecialchars($school_data['school_email']) . "</td></tr>
                        <tr><th>Location</th><td>" . htmlspecialchars($school_data['school_location']) . "</td></tr>
                        <tr><th>Admin Contact</th><td>" . htmlspecialchars($school_data['admin_email']) . "</td></tr>
                        <tr><th>Phone</th><td>" . htmlspecialchars($school_data['admin_phone']) . "</td></tr>
                        <tr><th>Website</th><td>" . ($school_data['has_website'] === 'yes' ? htmlspecialchars($school_data['website_url']) : 'No website') . "</td></tr>
                        <tr><th>Selected Features</th><td>" . htmlspecialchars($features) . "</td></tr>
                        <tr><th>Registration Date</th><td>" . date('F j, Y \a\t g:i A') . "</td></tr>
                    </table>
                    
                    <div class='action-buttons'>
                        <a href='" . APP_URL . "backend/admin/approve.php?id=" . $school_data['id'] . "' class='btn btn-approve'>Approve Registration</a>
                        <a href='" . APP_URL . "backend/admin/reject.php?id=" . $school_data['id'] . "' class='btn btn-reject'>Reject Registration</a>
                    </div>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Get setup completion email template
     */
    private function getSetupCompletionTemplate($school_data, $setup_data) {
        $features = !empty($setup_data['features']) ? implode(', ', $setup_data['features']) : 'None selected';
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Setup Complete - EduManage Pro</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8fafc; padding: 30px; border-radius: 0 0 10px 10px; }
                .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                .info-table th, .info-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
                .info-table th { background: #3b82f6; color: white; }
                .cta-button { display: inline-block; background: #3b82f6; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 20px 0; }
                .footer { text-align: center; margin-top: 30px; color: #64748b; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🎉 Setup Complete!</h1>
                    <p>Your EduManage Pro system is ready to use</p>
                </div>
                <div class='content'>
                    <h2>Congratulations " . htmlspecialchars($school_data['school_name']) . "!</h2>
                    <p>Your school management system has been successfully configured and is now ready for use.</p>
                    
                    <h3>System Configuration:</h3>
                    <table class='info-table'>
                        <tr><th>Academic Year</th><td>" . htmlspecialchars($setup_data['academic_year']) . "</td></tr>
                        <tr><th>School Type</th><td>" . htmlspecialchars($setup_data['school_type']) . "</td></tr>
                        <tr><th>Curriculum</th><td>" . htmlspecialchars($setup_data['curriculum']) . "</td></tr>
                        <tr><th>Timezone</th><td>" . htmlspecialchars($setup_data['timezone']) . "</td></tr>
                        <tr><th>Language</th><td>" . htmlspecialchars($setup_data['language']) . "</td></tr>
                        <tr><th>Admin Username</th><td>" . htmlspecialchars($setup_data['admin_username']) . "</td></tr>
                        <tr><th>Enabled Features</th><td>" . htmlspecialchars($features) . "</td></tr>
                    </table>
                    
                    <h3>What's Next?</h3>
                    <ul>
                        <li>Access your admin dashboard using your credentials</li>
                        <li>Start adding students, teachers, and classes</li>
                        <li>Configure your academic calendar</li>
                        <li>Set up your payment system</li>
                        <li>Explore all the features you've selected</li>
                    </ul>
                    
                    <div style='text-align: center;'>
                        <a href='" . APP_URL . "backend/admin/dashboard.php' class='cta-button'>Access Your Dashboard</a>
                    </div>
                    
                    <p><strong>Need Help?</strong> Our support team is here to assist you. Contact us at support@edumanagepro.com or check our documentation.</p>
                </div>
                <div class='footer'>
                    <p>© 2024 EduManage Pro. All rights reserved.</p>
                    <p>This is an automated message. Please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>";
    }
}
?>
