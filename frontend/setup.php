<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Setup - EduManage Pro</title>
    <link rel="stylesheet" href="asset/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Setup Page Specific Styles */
        .setup-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .setup-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 900px;
            position: relative;
            overflow: hidden;
        }

        .setup-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #3b82f6, #1e40af);
        }

        .setup-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .setup-header h1 {
            color: #1e293b;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .setup-header p {
            color: #64748b;
            font-size: 1.1rem;
        }

        .progress-bar {
            background: #e2e8f0;
            border-radius: 10px;
            height: 8px;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .progress-fill {
            background: linear-gradient(90deg, #3b82f6, #1e40af);
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
        }

        .progress-text {
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .setup-step {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .setup-step.active {
            display: block;
        }

        .step-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        .step-number {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .step-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
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

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: #64748b;
            border: 2px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
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

        .welcome-section {
            text-align: center;
            padding: 40px 0;
        }

        .welcome-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .welcome-icon i {
            font-size: 2rem;
            color: white;
        }

        .school-info {
            background: #f0f9ff;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
        }

        .school-info h3 {
            color: #1e293b;
            margin-bottom: 10px;
        }

        .school-info p {
            color: #64748b;
            margin: 5px 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .setup-card {
                padding: 30px 20px;
                margin: 10px;
            }

            .setup-header h1 {
                font-size: 2rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .checkbox-group {
                grid-template-columns: 1fr;
            }

            .navigation-buttons {
                flex-direction: column;
                gap: 15px;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="setup-card">
            <div class="setup-header">
                <h1>🎓 School Setup</h1>
                <p>Let's configure your EduManage Pro system</p>
            </div>

            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
            <div class="progress-text" id="progressText">Step 1 of 4</div>

            <form id="setupForm">
                <!-- Step 1: Welcome -->
                <div class="setup-step active" id="step1">
                    <div class="step-header">
                        <div class="step-number">1</div>
                        <div class="step-title">Welcome to EduManage Pro!</div>
                    </div>
                    
                    <div class="welcome-section">
                        <div class="welcome-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h2>Congratulations!</h2>
                        <p>Your school has been successfully registered with EduManage Pro.</p>
                        
                        <div class="school-info" id="schoolInfo">
                            <h3>School Information</h3>
                            <p><strong>Name:</strong> <span id="schoolName">Loading...</span></p>
                            <p><strong>Email:</strong> <span id="schoolEmail">Loading...</span></p>
                            <p><strong>Status:</strong> <span id="schoolStatus">Loading...</span></p>
                        </div>
                        
                        <p>Let's set up your school management system with the features you selected during registration.</p>
                    </div>
                </div>

                <!-- Step 2: Academic Settings -->
                <div class="setup-step" id="step2">
                    <div class="step-header">
                        <div class="step-number">2</div>
                        <div class="step-title">Academic Settings</div>
                    </div>
                    
                    <div class="form-section">
                        <div class="form-group">
                            <label for="academicYear" class="form-label required">Academic Year</label>
                            <input type="text" id="academicYear" name="academicYear" class="form-input" placeholder="2024-2025" required>
                            <div class="error-message" id="academicYearError"></div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="schoolType" class="form-label required">School Type</label>
                                <select id="schoolType" name="schoolType" class="form-input" required>
                                    <option value="">Select School Type</option>
                                    <option value="primary">Primary School</option>
                                    <option value="secondary">Secondary School</option>
                                    <option value="high_school">High School</option>
                                    <option value="college">College</option>
                                    <option value="university">University</option>
                                    <option value="mixed">Mixed Levels</option>
                                </select>
                                <div class="error-message" id="schoolTypeError"></div>
                            </div>
                            <div class="form-group">
                                <label for="curriculum" class="form-label required">Curriculum</label>
                                <select id="curriculum" name="curriculum" class="form-input" required>
                                    <option value="">Select Curriculum</option>
                                    <option value="national">National Curriculum</option>
                                    <option value="international">International Curriculum</option>
                                    <option value="montessori">Montessori</option>
                                    <option value="waldorf">Waldorf</option>
                                    <option value="british">British Curriculum</option>
                                    <option value="american">American Curriculum</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="error-message" id="curriculumError"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="schoolMotto" class="form-label">School Motto</label>
                            <input type="text" id="schoolMotto" name="schoolMotto" class="form-input" placeholder="Enter your school motto">
                        </div>
                    </div>
                </div>

                <!-- Step 3: System Configuration -->
                <div class="setup-step" id="step3">
                    <div class="step-header">
                        <div class="step-number">3</div>
                        <div class="step-title">System Configuration</div>
                    </div>
                    
                    <div class="form-section">
                        <div class="form-group">
                            <label class="form-label">Configure Selected Features</label>
                            <div class="checkbox-group" id="featuresConfig">
                                <!-- Features will be loaded dynamically -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="timezone" class="form-label required">Timezone</label>
                            <select id="timezone" name="timezone" class="form-input" required>
                                <option value="">Select Timezone</option>
                                <option value="UTC">UTC</option>
                                <option value="America/New_York">Eastern Time (US)</option>
                                <option value="America/Chicago">Central Time (US)</option>
                                <option value="America/Denver">Mountain Time (US)</option>
                                <option value="America/Los_Angeles">Pacific Time (US)</option>
                                <option value="Europe/London">London (GMT)</option>
                                <option value="Europe/Paris">Paris (CET)</option>
                                <option value="Asia/Tokyo">Tokyo (JST)</option>
                                <option value="Asia/Shanghai">Shanghai (CST)</option>
                                <option value="Asia/Kolkata">Mumbai (IST)</option>
                                <option value="Africa/Lagos">Lagos (WAT)</option>
                            </select>
                            <div class="error-message" id="timezoneError"></div>
                        </div>

                        <div class="form-group">
                            <label for="language" class="form-label required">Default Language</label>
                            <select id="language" name="language" class="form-input" required>
                                <option value="">Select Language</option>
                                <option value="en">English</option>
                                <option value="es">Spanish</option>
                                <option value="fr">French</option>
                                <option value="de">German</option>
                                <option value="it">Italian</option>
                                <option value="pt">Portuguese</option>
                                <option value="zh">Chinese</option>
                                <option value="ja">Japanese</option>
                                <option value="ko">Korean</option>
                                <option value="ar">Arabic</option>
                                <option value="hi">Hindi</option>
                            </select>
                            <div class="error-message" id="languageError"></div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Admin Account -->
                <div class="setup-step" id="step4">
                    <div class="step-header">
                        <div class="step-number">4</div>
                        <div class="step-title">Create Admin Account</div>
                    </div>
                    
                    <div class="form-section">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="adminFirstName" class="form-label required">First Name</label>
                                <input type="text" id="adminFirstName" name="adminFirstName" class="form-input" placeholder="Enter first name" required>
                                <div class="error-message" id="adminFirstNameError"></div>
                            </div>
                            <div class="form-group">
                                <label for="adminLastName" class="form-label required">Last Name</label>
                                <input type="text" id="adminLastName" name="adminLastName" class="form-input" placeholder="Enter last name" required>
                                <div class="error-message" id="adminLastNameError"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="adminUsername" class="form-label required">Username</label>
                            <input type="text" id="adminUsername" name="adminUsername" class="form-input" placeholder="Choose a username" required>
                            <div class="error-message" id="adminUsernameError"></div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="adminPassword" class="form-label required">Password</label>
                                <input type="password" id="adminPassword" name="adminPassword" class="form-input" placeholder="Create a strong password" required>
                                <div class="error-message" id="adminPasswordError"></div>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword" class="form-label required">Confirm Password</label>
                                <input type="password" id="confirmPassword" name="confirmPassword" class="form-input" placeholder="Confirm your password" required>
                                <div class="error-message" id="confirmPasswordError"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password Requirements:</label>
                            <ul style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">
                                <li>At least 8 characters long</li>
                                <li>Contains uppercase and lowercase letters</li>
                                <li>Contains at least one number</li>
                                <li>Contains at least one special character</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="navigation-buttons">
                    <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)" style="display: none;">
                        <i class="fas fa-arrow-left"></i>
                        Previous
                    </button>
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">
                        Next
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">
                        <span class="loading" id="loadingSpinner"></span>
                        Complete Setup
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="asset/main.js"></script>
    <script>
        let currentStep = 1;
        const totalSteps = 4;
        let schoolData = {};

        // Initialize setup page
        document.addEventListener('DOMContentLoaded', function() {
            loadSchoolData();
            updateProgress();
        });

        // Load school data from URL parameter
        function loadSchoolData() {
            const urlParams = new URLSearchParams(window.location.search);
            const schoolId = urlParams.get('school_id');
            
            if (!schoolId) {
                showErrorMessage('No school ID provided. Please register first.');
                return;
            }

            fetch(`../backend/api/school-data.php?id=${schoolId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        schoolData = data.school;
                        updateSchoolInfo();
                        loadFeatures();
                    } else {
                        showErrorMessage(data.message || 'Failed to load school data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorMessage('Network error loading school data');
                });
        }

        // Update school information display
        function updateSchoolInfo() {
            document.getElementById('schoolName').textContent = schoolData.school_name || 'N/A';
            document.getElementById('schoolEmail').textContent = schoolData.school_email || 'N/A';
            document.getElementById('schoolStatus').textContent = schoolData.status || 'N/A';
        }

        // Load features configuration
        function loadFeatures() {
            const featuresContainer = document.getElementById('featuresConfig');
            const features = schoolData.features || [];
            
            const featureConfigs = {
                'student_management': 'Student Management System',
                'teacher_portal': 'Teacher Portal',
                'academic_calendar': 'Academic Calendar',
                'analytics_reports': 'Analytics & Reports',
                'mobile_access': 'Mobile Access',
                'cbt_system': 'CBT System',
                'payment_system': 'Payment System',
                'security_reliable': 'Security & Reliability'
            };

            featuresContainer.innerHTML = features.map(feature => `
                <div class="checkbox-item">
                    <input type="checkbox" id="config_${feature}" name="featureConfigs[]" value="${feature}" checked>
                    <label for="config_${feature}">${featureConfigs[feature] || feature}</label>
                </div>
            `).join('');
        }

        // Change step
        function changeStep(direction) {
            if (direction === 1 && !validateCurrentStep()) {
                return;
            }

            const steps = document.querySelectorAll('.setup-step');
            steps[currentStep - 1].classList.remove('active');
            
            currentStep += direction;
            
            if (currentStep < 1) currentStep = 1;
            if (currentStep > totalSteps) currentStep = totalSteps;
            
            steps[currentStep - 1].classList.add('active');
            
            updateProgress();
            updateNavigationButtons();
        }

        // Update progress bar
        function updateProgress() {
            const progress = (currentStep / totalSteps) * 100;
            document.getElementById('progressFill').style.width = progress + '%';
            document.getElementById('progressText').textContent = `Step ${currentStep} of ${totalSteps}`;
        }

        // Update navigation buttons
        function updateNavigationButtons() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');

            prevBtn.style.display = currentStep > 1 ? 'block' : 'none';
            
            if (currentStep === totalSteps) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'block';
            } else {
                nextBtn.style.display = 'block';
                submitBtn.style.display = 'none';
            }
        }

        // Validate current step
        function validateCurrentStep() {
            const currentStepElement = document.querySelector('.setup-step.active');
            const requiredFields = currentStepElement.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                const errorElement = document.getElementById(field.id + 'Error');
                
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

            // Additional validation for step 4 (password confirmation)
            if (currentStep === 4) {
                const password = document.getElementById('adminPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                
                if (password !== confirmPassword) {
                    document.getElementById('confirmPassword').classList.add('error');
                    document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
                    document.getElementById('confirmPasswordError').style.display = 'block';
                    isValid = false;
                }

                // Password strength validation
                if (password && !isPasswordStrong(password)) {
                    document.getElementById('adminPassword').classList.add('error');
                    document.getElementById('adminPasswordError').textContent = 'Password does not meet requirements';
                    document.getElementById('adminPasswordError').style.display = 'block';
                    isValid = false;
                }
            }

            return isValid;
        }

        // Check password strength
        function isPasswordStrong(password) {
            const minLength = 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);
            const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

            return password.length >= minLength && hasUpperCase && hasLowerCase && hasNumbers && hasSpecialChar;
        }

        // Form submission
        document.getElementById('setupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!validateCurrentStep()) {
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            const loadingSpinner = document.getElementById('loadingSpinner');

            // Show loading state
            submitBtn.disabled = true;
            loadingSpinner.style.display = 'inline-block';
            submitBtn.innerHTML = '<span class="loading"></span>Setting up...';

            // Prepare form data
            const formData = new FormData();
            formData.append('school_id', schoolData.id);
            formData.append('academic_year', document.getElementById('academicYear').value);
            formData.append('school_type', document.getElementById('schoolType').value);
            formData.append('curriculum', document.getElementById('curriculum').value);
            formData.append('school_motto', document.getElementById('schoolMotto').value);
            formData.append('timezone', document.getElementById('timezone').value);
            formData.append('language', document.getElementById('language').value);
            formData.append('admin_first_name', document.getElementById('adminFirstName').value);
            formData.append('admin_last_name', document.getElementById('adminLastName').value);
            formData.append('admin_username', document.getElementById('adminUsername').value);
            formData.append('admin_password', document.getElementById('adminPassword').value);

            // Add selected features
            const selectedFeatures = document.querySelectorAll('input[name="featureConfigs[]"]:checked');
            selectedFeatures.forEach(feature => {
                formData.append('features[]', feature.value);
            });

            // Submit to backend
            fetch('../backend/api/setup.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessMessage('School setup completed successfully! Redirecting to dashboard...');
                    setTimeout(() => {
                        window.location.href = '../backend/admin/dashboard.php';
                    }, 2000);
                } else {
                    showErrorMessage(data.message || 'Setup failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorMessage('Network error. Please check your connection and try again.');
            })
            .finally(() => {
                // Reset button
                submitBtn.disabled = false;
                loadingSpinner.style.display = 'none';
                submitBtn.innerHTML = 'Complete Setup';
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
            const messageDiv = document.createElement('div');
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

            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => {
                        messageDiv.remove();
                    }, 300);
                }
            }, 5000);
        }
    </script>

    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    </style>
</body>
</html>
