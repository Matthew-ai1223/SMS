<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduManage Pro - School Management System</title>
    <link rel="stylesheet" href="asset/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <i class="fas fa-graduation-cap"></i>
                <span>EduManage Pro</span>
            </div>
            <ul class="nav-menu">
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#pricing">Pricing</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="signup.php" class="btn-login">Get Started</a></li>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1 class="hero-title">
                    Transform Your School with
                    <span class="gradient-text">Smart Management</span>
                </h1>
                <p class="hero-description">
                    The ultimate multi-tenant school management system that streamlines operations, 
                    enhances communication, and empowers educators to focus on what matters most - teaching.
                </p>
                <div class="hero-buttons">
                    <a href="signup.php" class="btn-primary">Get Started</a>
                    <a href="#features" class="btn-secondary">
                        <i class="fas fa-info-circle"></i>
                        Learn More
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Schools</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">50K+</span>
                        <span class="stat-label">Students</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">99.9%</span>
                        <span class="stat-label">Uptime</span>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <div class="dashboard-mockup">
                    <div class="mockup-header">
                        <div class="mockup-dots">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <span class="mockup-title">Dashboard</span>
                    </div>
                    <div class="mockup-content">
                        <div class="mockup-sidebar">
                            <div class="sidebar-item active">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </div>
                            <div class="sidebar-item">
                                <i class="fas fa-users"></i>
                                <span>Students</span>
                            </div>
                            <div class="sidebar-item">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>Teachers</span>
                            </div>
                            <div class="sidebar-item">
                                <i class="fas fa-book"></i>
                                <span>Classes</span>
                            </div>
                        </div>
                        <div class="mockup-main">
                            <div class="stats-grid">
                                <div class="stat-card">
                                    <i class="fas fa-users"></i>
                                    <div>
                                        <h3>1,250</h3>
                                        <p>Total Students</p>
                                    </div>
                                </div>
                                <div class="stat-card">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <div>
                                        <h3>85</h3>
                                        <p>Teachers</p>
                                    </div>
                                </div>
                                <div class="stat-card">
                                    <i class="fas fa-book"></i>
                                    <div>
                                        <h3>42</h3>
                                        <p>Classes</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-header">
                <h2>Everything You Need to Manage Your School</h2>
                <p>Comprehensive tools designed for modern educational institutions</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Student Management</h3>
                    <p>Complete student lifecycle management from enrollment to graduation with detailed academic records.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>Teacher Portal</h3>
                    <p>Empower teachers with tools for attendance, grading, lesson planning, and parent communication.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>Academic Calendar</h3>
                    <p>Manage schedules, events, holidays, and academic terms with our intuitive calendar system.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Analytics & Reports</h3>
                    <p>Get insights with comprehensive reports on attendance, performance, and school operations.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile Access</h3>
                    <p>Access your school management system anywhere with our responsive mobile-friendly interface.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Secure & Reliable</h3>
                    <p>Enterprise-grade security with data encryption, backup, and multi-tenant architecture.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>CBT System</h3>
                    <p>Computer-Based Testing platform with automated grading, question banks, and real-time exam monitoring.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3>Payment System</h3>
                    <p>Integrated payment gateway for school fees, online transactions, and automated billing with receipt generation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <!-- <section id="pricing" class="pricing">
        <div class="container">
            <div class="section-header">
                <h2>Simple, Transparent Pricing</h2>
                <p>Choose the plan that fits your school's needs</p>
            </div>
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Starter</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">29</span>
                            <span class="period">/month</span>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Up to 100 students</li>
                        <li><i class="fas fa-check"></i> Basic student management</li>
                        <li><i class="fas fa-check"></i> Attendance tracking</li>
                        <li><i class="fas fa-check"></i> Email support</li>
                    </ul>
                    <a href="#" class="btn-outline">Get Started</a>
                </div>
                <div class="pricing-card featured">
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricing-header">
                        <h3>Professional</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">79</span>
                            <span class="period">/month</span>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Up to 500 students</li>
                        <li><i class="fas fa-check"></i> Complete SMS features</li>
                        <li><i class="fas fa-check"></i> Advanced analytics</li>
                        <li><i class="fas fa-check"></i> Mobile app access</li>
                        <li><i class="fas fa-check"></i> Priority support</li>
                    </ul>
                    <a href="#" class="btn-primary">Get Started</a>
                </div>
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Enterprise</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">149</span>
                            <span class="period">/month</span>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Unlimited students</li>
                        <li><i class="fas fa-check"></i> Custom integrations</li>
                        <li><i class="fas fa-check"></i> Advanced security</li>
                        <li><i class="fas fa-check"></i> Dedicated support</li>
                        <li><i class="fas fa-check"></i> Custom training</li>
                    </ul>
                    <a href="#" class="btn-outline">Contact Sales</a>
                </div>
            </div>
        </div>
    </section> -->

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Transform Your School?</h2>
                <p>Join thousands of schools already using EduManage Pro to streamline their operations.</p>
                <a href="signup.php" class="btn-primary btn-large">Start Your Free Trial</a>
                <p class="cta-note">No credit card required • 30-day free trial</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <i class="fas fa-graduation-cap"></i>
                        <span>EduManage Pro</span>
                    </div>
                    <p>Empowering schools with modern management solutions for better education outcomes.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Product</h4>
                    <ul>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#">Integrations</a></li>
                        <li><a href="#">API</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Training</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 EduManage Pro. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="asset/main.js"></script>
</body>
</html>
