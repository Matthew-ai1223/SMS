<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Registration - EduManage Pro</title>
    <link rel="stylesheet" href="asset/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Signup Page Specific Styles */
        .signup-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .signup-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 800px;
            position: relative;
            overflow: hidden;
        }

        .signup-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #3b82f6, #1e40af);
        }

        .signup-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .signup-header h1 {
            color: #1e293b;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .signup-header p {
            color: #64748b;
            font-size: 1.1rem;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #3b82f6;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-label.required::after {
            content: ' *';
            color: #ef4444;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-upload-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 20px;
            border: 2px dashed #cbd5e1;
            border-radius: 10px;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .file-upload-label:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .file-upload-label i {
            font-size: 1.5rem;
            color: #64748b;
        }

        .file-preview {
            margin-top: 10px;
            padding: 10px;
            background: #f0f9ff;
            border-radius: 8px;
            display: none;
        }

        .file-preview img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .checkbox-item:hover {
            background: #eff6ff;
            border-color: #3b82f6;
        }

        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #3b82f6;
        }

        .checkbox-item label {
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            margin: 0;
        }

        .conditional-field {
            display: none;
            margin-top: 15px;
            padding: 15px;
            background: #f0f9ff;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }

        .conditional-field.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .radio-item input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #3b82f6;
        }

        .radio-item label {
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            margin: 0;
        }

        .submit-section {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
        }

        .btn-submit {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 20px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #3b82f6;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.9rem;
            margin-top: 5px;
            display: none;
        }

        .success-message {
            color: #10b981;
            font-size: 0.9rem;
            margin-top: 5px;
            display: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .signup-card {
                padding: 30px 20px;
                margin: 10px;
            }

            .signup-header h1 {
                font-size: 2rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .checkbox-group {
                grid-template-columns: 1fr;
            }

            .radio-group {
                flex-direction: column;
                gap: 10px;
            }
        }

        /* Loading Animation */
        .loading {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-card">
            <a href="index.php" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to Home
            </a>
            
            <div class="signup-header">
                <h1>School Registration</h1>
                <p>Join thousands of schools using EduManage Pro</p>
            </div>

            <form id="signupForm" enctype="multipart/form-data">
                <!-- School Information Section -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-school"></i>
                        School Information
                    </h2>
                    
                    <div class="form-group">
                        <label for="schoolName" class="form-label required">School Name</label>
                        <input type="text" id="schoolName" name="schoolName" class="form-input" placeholder="Enter your school name" required>
                        <div class="error-message" id="schoolNameError"></div>
                    </div>

                    <div class="form-group">
                        <label for="schoolLogo" class="form-label">School Logo</label>
                        <div class="file-upload">
                            <input type="file" id="schoolLogo" name="schoolLogo" class="file-upload-input" accept="image/*">
                            <label for="schoolLogo" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Click to upload school logo (PNG, JPG, SVG)</span>
                            </label>
                        </div>
                        <div class="file-preview" id="logoPreview"></div>
                    </div>

                    <div class="form-group">
                        <label for="schoolEmail" class="form-label required">School Email</label>
                        <input type="email" id="schoolEmail" name="schoolEmail" class="form-input" placeholder="school@example.com" required>
                        <div class="error-message" id="schoolEmailError"></div>
                    </div>

                    <div class="form-group">
                        <label for="schoolLocation" class="form-label required">School Location</label>
                        <textarea id="schoolLocation" name="schoolLocation" class="form-input form-textarea" placeholder="Enter complete school address" required></textarea>
                        <div class="error-message" id="schoolLocationError"></div>
                    </div>
                </div>

                <!-- Features Selection Section -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-cogs"></i>
                        Select Features
                    </h2>
                    
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="feature_student_mgmt" name="features[]" value="student_management">
                            <label for="feature_student_mgmt">Student Management</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="feature_teacher_portal" name="features[]" value="teacher_portal">
                            <label for="feature_teacher_portal">Teacher Portal</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="feature_academic_calendar" name="features[]" value="academic_calendar">
                            <label for="feature_academic_calendar">Academic Calendar</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="feature_analytics" name="features[]" value="analytics_reports">
                            <label for="feature_analytics">Analytics & Reports</label>
                        </div>
                        <!-- <div class="checkbox-item">
                            <input type="checkbox" id="feature_mobile_access" name="features[]" value="mobile_access">
                            <label for="feature_mobile_access">Mobile Access</label>
                        </div> -->
                        <div class="checkbox-item">
                            <input type="checkbox" id="feature_cbt_system" name="features[]" value="cbt_system">
                            <label for="feature_cbt_system">CBT System</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="feature_payment_system" name="features[]" value="payment_system">
                            <label for="feature_payment_system">Payment System</label>
                        </div>
                        <!-- <div class="checkbox-item">
                            <input type="checkbox" id="feature_security" name="features[]" value="security_reliable">
                            <label for="feature_security">Security & Reliability</label>
                        </div> -->
                    </div>
                </div>

                <!-- Website Information Section -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-globe"></i>
                        Website Information
                    </h2>
                    
                    <div class="form-group">
                        <label class="form-label">Does your school have an existing website?</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" id="hasWebsite_yes" name="hasWebsite" value="yes">
                                <label for="hasWebsite_yes">Yes</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="hasWebsite_no" name="hasWebsite" value="no">
                                <label for="hasWebsite_no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="conditional-field" id="websiteUrlField">
                        <div class="form-group">
                            <label for="websiteUrl" class="form-label required">Website URL</label>
                            <input type="url" id="websiteUrl" name="websiteUrl" class="form-input" placeholder="https://www.yourschool.com">
                            <div class="error-message" id="websiteUrlError"></div>
                        </div>
                    </div>
                </div>

                <!-- Admin Contact Section -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-user-shield"></i>
                        School Administrator Contact
                    </h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="adminPhone" class="form-label required">Phone Number</label>
                            <input type="tel" id="adminPhone" name="adminPhone" class="form-input" placeholder="+1 (555) 123-4567" required>
                            <div class="error-message" id="adminPhoneError"></div>
                        </div>
                        <div class="form-group">
                            <label for="adminEmail" class="form-label required">Email Address</label>
                            <input type="email" id="adminEmail" name="adminEmail" class="form-input" placeholder="admin@school.com" required>
                            <div class="error-message" id="adminEmailError"></div>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="submit-section">
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="loading" id="loadingSpinner"></span>
                        Register School
                    </button>
                    <p style="margin-top: 15px; color: #64748b; font-size: 0.9rem;">
                        By registering, you agree to our <a href="#" style="color: #3b82f6;">Terms of Service</a> and <a href="#" style="color: #3b82f6;">Privacy Policy</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script src="asset/main.js"></script>
    <script>
        // Signup form specific JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('signupForm');
            const websiteUrlField = document.getElementById('websiteUrlField');
            const logoInput = document.getElementById('schoolLogo');
            const logoPreview = document.getElementById('logoPreview');
            const submitBtn = document.getElementById('submitBtn');
            const loadingSpinner = document.getElementById('loadingSpinner');

            // Show/hide website URL field based on radio selection
            document.querySelectorAll('input[name="hasWebsite"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'yes') {
                        websiteUrlField.classList.add('show');
                        document.getElementById('websiteUrl').required = true;
                    } else {
                        websiteUrlField.classList.remove('show');
                        document.getElementById('websiteUrl').required = false;
                        document.getElementById('websiteUrl').value = '';
                    }
                });
            });

            // Logo preview functionality
            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        logoPreview.innerHTML = `
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="${e.target.result}" alt="Logo Preview">
                                <div>
                                    <p style="margin: 0; font-weight: 500; color: #374151;">${file.name}</p>
                                    <p style="margin: 0; font-size: 0.9rem; color: #64748b;">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                                </div>
                            </div>
                        `;
                        logoPreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    logoPreview.style.display = 'none';
                }
            });

            // Form validation
            function validateForm() {
                let isValid = true;
                const requiredFields = ['schoolName', 'schoolEmail', 'schoolLocation', 'adminPhone', 'adminEmail'];
                
                requiredFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    const errorElement = document.getElementById(fieldId + 'Error');
                    
                    if (!field.value.trim()) {
                        field.classList.add('error');
                        errorElement.textContent = 'This field is required';
                        errorElement.style.display = 'block';
                        isValid = false;
                    } else {
                        field.classList.remove('error');
                        errorElement.style.display = 'none';
                    }
                });

                // Email validation
                const emailFields = ['schoolEmail', 'adminEmail'];
                emailFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    const errorElement = document.getElementById(fieldId + 'Error');
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    
                    if (field.value && !emailRegex.test(field.value)) {
                        field.classList.add('error');
                        errorElement.textContent = 'Please enter a valid email address';
                        errorElement.style.display = 'block';
                        isValid = false;
                    }
                });

                // Phone validation
                const phoneField = document.getElementById('adminPhone');
                const phoneError = document.getElementById('adminPhoneError');
                const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
                
                if (phoneField.value && !phoneRegex.test(phoneField.value.replace(/[\s\-\(\)]/g, ''))) {
                    phoneField.classList.add('error');
                    phoneError.textContent = 'Please enter a valid phone number';
                    phoneError.style.display = 'block';
                    isValid = false;
                }

                // Website URL validation (if required)
                const websiteUrlField = document.getElementById('websiteUrl');
                const websiteUrlError = document.getElementById('websiteUrlError');
                if (websiteUrlField.required && websiteUrlField.value) {
                    const urlRegex = /^https?:\/\/.+/;
                    if (!urlRegex.test(websiteUrlField.value)) {
                        websiteUrlField.classList.add('error');
                        websiteUrlError.textContent = 'Please enter a valid URL starting with http:// or https://';
                        websiteUrlError.style.display = 'block';
                        isValid = false;
                    }
                }

                // Check if at least one feature is selected
                const features = document.querySelectorAll('input[name="features[]"]:checked');
                if (features.length === 0) {
                    alert('Please select at least one feature for your school.');
                    isValid = false;
                }

                return isValid;
            }

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!validateForm()) {
                    return;
                }
                // Show loading state
                submitBtn.disabled = true;
                loadingSpinner.style.display = 'inline-block';
                submitBtn.innerHTML = '<span class="loading"></span>Processing...';
                // Prepare form data
                const formData = new FormData(form);
                fetch('../backend/api/signup.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.school_id) {
                        showSuccessMessage('School registration submitted successfully! We will contact you within 24 hours.');
                        form.reset();
                        logoPreview.style.display = 'none';
                        websiteUrlField.classList.remove('show');
                        setTimeout(() => {
                            window.location.href = 'setup.php?school_id=' + encodeURIComponent(data.school_id);
                        }, 2000);
                    } else {
                        showErrorMessage(data.message || 'Registration failed. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorMessage('Network error. Please check your connection and try again.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    loadingSpinner.style.display = 'none';
                    submitBtn.innerHTML = 'Register School';
                });
            });

            // Real-time validation
            document.querySelectorAll('.form-input').forEach(input => {
                input.addEventListener('blur', function() {
                    const fieldId = this.id;
                    const errorElement = document.getElementById(fieldId + 'Error');
                    
                    if (this.hasAttribute('required') && !this.value.trim()) {
                        this.classList.add('error');
                        errorElement.textContent = 'This field is required';
                        errorElement.style.display = 'block';
                    } else {
                        this.classList.remove('error');
                        errorElement.style.display = 'none';
                    }
                });
            });

            // Helper functions for showing messages
            function showSuccessMessage(message) {
                showMessage(message, 'success');
            }

            function showErrorMessage(message) {
                showMessage(message, 'error');
            }

            function showMessage(message, type) {
                // Remove existing message if any
                const existingMessage = document.querySelector('.form-message');
                if (existingMessage) {
                    existingMessage.remove();
                }

                // Create message element
                const messageDiv = document.createElement('div');
                messageDiv.className = `form-message ${type}-message`;
                messageDiv.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 15px 20px;
                    border-radius: 8px;
                    color: white;
                    font-weight: 500;
                    z-index: 10000;
                    max-width: 400px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    animation: slideIn 0.3s ease;
                `;

                if (type === 'success') {
                    messageDiv.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                } else {
                    messageDiv.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
                }

                messageDiv.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                        <span>${message}</span>
                    </div>
                `;

                document.body.appendChild(messageDiv);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (messageDiv.parentNode) {
                        messageDiv.style.animation = 'slideOut 0.3s ease';
                        setTimeout(() => {
                            messageDiv.remove();
                        }, 300);
                    }
                }, 5000);
            }
        });
    </script>
</body>
</html>
