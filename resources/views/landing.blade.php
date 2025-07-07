<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raqib - Modern HR/ERP Solution</title>
    <meta name="description" content="Raqib is a comprehensive Laravel-based HR/ERP system designed to manage core business operations including employee lifecycle management, financial transactions, project management, and client collaboration.">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #3b82f6;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f8fafc;
            --bg-gradient: linear-gradient(135deg, #3b82f6 0%, #10b981 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            padding: 0.75rem 0;
        }
        
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
            margin: 0;
        }
        
        .navbar-brand img {
            height: 50px;
            width: auto;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: scale(1.05);
        }
        
        .hero-section {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 120px 0 80px 0;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" style="stop-color:rgba(59,130,246,0.15)"/><stop offset="100%" style="stop-color:rgba(16,185,129,0.05)"/></radialGradient><radialGradient id="b" cx="50%" cy="50%"><stop offset="0%" style="stop-color:rgba(16,185,129,0.15)"/><stop offset="100%" style="stop-color:rgba(59,130,246,0.05)"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23b)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>') center/cover;
            opacity: 0.6;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            max-width: 600px;
        }
        
        .btn-primary-custom {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .btn-primary-custom:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-secondary-custom {
            background: white;
            border: 2px solid white;
            color: var(--primary-color);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-secondary-custom:hover {
            background: transparent;
            border-color: white;
            color: white;
            transform: translateY(-2px);
        }
        
        .features-section {
            padding: 80px 0;
            background: var(--bg-light);
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--bg-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }
        
        .section-subtitle {
            font-size: 1.1rem;
            color: var(--text-light);
            text-align: center;
            margin-bottom: 4rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .stats-section {
            padding: 80px 0;
            background: var(--primary-color);
            color: white;
        }
        
        .stat-item {
            text-align: center;
            padding: 2rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .cta-section {
            padding: 80px 0;
            background: var(--bg-gradient);
            text-align: center;
        }
        
        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
        }
        
        .cta-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
        }
        
        .contact-section {
            padding: 80px 0;
            background: white;
        }
        
        .contact-info {
            padding-right: 2rem;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: var(--bg-light);
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        
        .contact-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .contact-icon {
            width: 60px;
            height: 60px;
            background: var(--bg-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.5rem;
            flex-shrink: 0;
        }
        
        .contact-icon i {
            font-size: 1.5rem;
            color: white;
        }
        
        .contact-details h5 {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .contact-details p {
            color: var(--text-light);
            margin: 0;
            line-height: 1.6;
        }
        
        .contact-form {
            background: var(--bg-light);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
            outline: none;
        }
        
        .btn-primary-custom.btn-lg {
            padding: 15px 30px;
            font-size: 1.1rem;
            background: var(--bg-gradient);
            border: none;
            color: white;
        }
        
        .btn-primary-custom.btn-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }
        
        .about-section {
            padding: 80px 0;
            background: var(--bg-light);
        }
        
        .about-content {
            padding-right: 2rem;
        }
        
        .about-text {
            margin-bottom: 2rem;
        }
        
        .about-text p {
            color: var(--text-light);
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }
        
        .about-features {
            margin-top: 2rem;
        }
        
        .about-feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }
        
        .about-feature-icon {
            width: 50px;
            height: 50px;
            background: var(--bg-gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .about-feature-icon i {
            font-size: 1.2rem;
            color: white;
        }
        
        .about-feature-content h5 {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        
        .about-feature-content p {
            color: var(--text-light);
            margin: 0;
            font-size: 0.95rem;
        }
        
        .about-image-container {
            position: relative;
            padding: 2rem;
        }
        
        .about-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .about-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }
        
        .about-card-header h6 {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        
        .about-card-content p {
            color: var(--text-light);
            margin: 0;
            line-height: 1.6;
        }
        
        .about-stats {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .about-stat {
            flex: 1;
            text-align: center;
            padding: 1rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
        }
        
        .about-stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }
        
        .about-stat-label {
            font-size: 0.8rem;
            color: var(--text-light);
            font-weight: 500;
        }
        
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        
        .footer a {
            color: var(--accent-color);
            text-decoration: none;
        }
        
        .footer a:hover {
            color: white;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .feature-card {
                padding: 2rem;
            }
            
            .navbar-brand img {
                height: 50px;
            }
            
            .navbar {
                padding: 0.5rem 0;
            }
            
            .hero-section {
                padding: 100px 0 60px 0;
            }
            
            .hero-content .d-flex {
                padding-bottom: 3rem;
            }
            
            .contact-info {
                padding-right: 0;
                margin-bottom: 2rem;
            }
            
            .contact-form {
                padding: 2rem;
            }
            
            .about-content {
                padding-right: 0;
                margin-bottom: 2rem;
            }
            
            .about-stats {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .navbar-brand img {
                height: 40px;
            }
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .dashboard-mockup {
            max-width: 90%;
            margin: 0 auto;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.2));
        }
        
        .mockup-container {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .mockup-header {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .mockup-dots {
            display: flex;
            gap: 0.5rem;
        }
        
        .mockup-dots span {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #cbd5e1;
        }
        
        .mockup-dots span:nth-child(1) { background: #ef4444; }
        .mockup-dots span:nth-child(2) { background: #f59e0b; }
        .mockup-dots span:nth-child(3) { background: #10b981; }
        
        .mockup-title {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 600;
        }
        
        .mockup-content {
            display: flex;
            min-height: 300px;
        }
        
        .mockup-sidebar {
            width: 240px;
            background: #f8fafc;
            border-right: 1px solid #e2e8f0;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .sidebar-item {
            height: 40px;
            background: var(--bg-gradient);
            border-radius: 10px;
            opacity: 0.7;
        }
        
        .sidebar-item:nth-child(1) { opacity: 1; }
        
        .mockup-main {
            flex: 1;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .chart-area {
            height: 150px;
            background: var(--bg-gradient);
            border-radius: 15px;
            position: relative;
            overflow: hidden;
        }
        
        .chart-area::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .stat-box {
            height: 80px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        
        @media (max-width: 768px) {
            .mockup-content {
                flex-direction: column;
                min-height: 200px;
            }
            
            .mockup-sidebar {
                width: 100%;
                padding: 1rem;
                flex-direction: row;
                min-height: auto;
            }
            
            .sidebar-item {
                flex: 1;
                height: 30px;
            }
            
            .mockup-main {
                padding: 1rem;
            }
            
            .chart-area {
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/images/raqib.png') }}" alt="Raqib" height="60">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="btn btn-primary px-4 py-2" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title fade-in">Transform Your Business with Raqib</h1>
                        <p class="hero-subtitle fade-in">A comprehensive HR/ERP solution that streamlines employee management, financial operations, project tracking, and client collaboration - all in one powerful platform.</p>
                        <div class="d-flex gap-3 flex-wrap fade-in">
                            <a href="{{ route('login') }}" class="btn btn-secondary-custom">
                                <i class="fas fa-rocket me-2"></i>Get Started
                            </a>
                            <a href="#features" class="btn btn-primary-custom">
                                <i class="fas fa-play me-2"></i>Learn More
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center fade-in">
                        <div class="dashboard-mockup">
                            <div class="mockup-container">
                                <div class="mockup-header">
                                    <div class="mockup-dots">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <div class="mockup-title">Raqib Dashboard</div>
                                </div>
                                <div class="mockup-content">
                                    <div class="mockup-sidebar">
                                        <div class="sidebar-item"></div>
                                        <div class="sidebar-item"></div>
                                        <div class="sidebar-item"></div>
                                        <div class="sidebar-item"></div>
                                    </div>
                                    <div class="mockup-main">
                                        <div class="chart-area"></div>
                                        <div class="stats-grid">
                                            <div class="stat-box"></div>
                                            <div class="stat-box"></div>
                                            <div class="stat-box"></div>
                                            <div class="stat-box"></div>
                                        </div>
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
    <section id="features" class="features-section">
        <div class="container">
            <h2 class="section-title fade-in">Powerful Features for Modern Business</h2>
            <p class="section-subtitle fade-in">Everything you need to manage your business operations efficiently and effectively</p>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>HR Management</h4>
                        <p>Complete employee lifecycle management from recruitment to retirement with automated workflows and comprehensive reporting.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h4>Financial Control</h4>
                        <p>Track expenses, manage budgets, generate invoices, and maintain complete financial transparency across all operations.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h4>Project Management</h4>
                        <p>Plan, execute, and monitor projects with advanced tracking, resource allocation, and team collaboration tools.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Client Collaboration</h4>
                        <p>Seamless client communication, project sharing, and feedback collection to ensure exceptional service delivery.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-content">
                        <h2 class="section-title text-start fade-in">About Raqib</h2>
                        <p class="section-subtitle text-start fade-in">Empowering businesses with innovative HR/ERP solutions since 2020.</p>
                        
                        <div class="about-text fade-in">
                            <p>Raqib was founded with a simple mission: to streamline business operations and empower organizations to focus on what matters most - their people and growth. Our comprehensive HR/ERP platform combines cutting-edge technology with intuitive design to deliver solutions that actually work.</p>
                            
                            <p>With years of experience in enterprise software development, our team understands the challenges businesses face in managing complex operations. That's why we've built Raqib to be more than just software - it's a complete business transformation platform.</p>
                        </div>
                        
                        <div class="about-features fade-in">
                            <div class="about-feature-item">
                                <div class="about-feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="about-feature-content">
                                    <h5>Enterprise Security</h5>
                                    <p>Bank-level encryption and security protocols to protect your sensitive business data.</p>
                                </div>
                            </div>
                            
                            <div class="about-feature-item">
                                <div class="about-feature-icon">
                                    <i class="fas fa-cloud"></i>
                                </div>
                                <div class="about-feature-content">
                                    <h5>Cloud-First Approach</h5>
                                    <p>Access your data anywhere, anytime with our robust cloud infrastructure.</p>
                                </div>
                            </div>
                            
                            <div class="about-feature-item">
                                <div class="about-feature-icon">
                                    <i class="fas fa-users-cog"></i>
                                </div>
                                <div class="about-feature-content">
                                    <h5>Expert Support</h5>
                                    <p>Dedicated support team to help you maximize your investment in Raqib.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="about-image fade-in">
                        <div class="about-image-container">
                            <div class="about-card">
                                <div class="about-card-header">
                                    <h6>Our Mission</h6>
                                </div>
                                <div class="about-card-content">
                                    <p>To revolutionize how businesses manage their operations by providing intuitive, powerful, and scalable solutions that grow with your organization.</p>
                                </div>
                            </div>
                            
                            <div class="about-card">
                                <div class="about-card-header">
                                    <h6>Our Vision</h6>
                                </div>
                                <div class="about-card-content">
                                    <p>To become the world's most trusted business management platform, empowering organizations of all sizes to achieve their full potential.</p>
                                </div>
                            </div>
                            
                            <div class="about-stats">
                                <div class="about-stat">
                                    <div class="about-stat-number">5+</div>
                                    <div class="about-stat-label">Years Experience</div>
                                </div>
                                <div class="about-stat">
                                    <div class="about-stat-number">50+</div>
                                    <div class="about-stat-label">Team Members</div>
                                </div>
                                <div class="about-stat">
                                    <div class="about-stat-number">99.9%</div>
                                    <div class="about-stat-label">Satisfaction Rate</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Companies Trust Us</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Active Users</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in">
                        <div class="stat-number">99.9%</div>
                        <div class="stat-label">Uptime</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title fade-in">Ready to Transform Your Business?</h2>
            <p class="cta-subtitle fade-in">Join thousands of companies that have streamlined their operations with Raqib</p>
            <div class="fade-in">
                <a href="{{ route('login') }}" class="btn btn-secondary-custom btn-lg">
                    <i class="fas fa-rocket me-2"></i>Start Your Journey
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-info">
                        <h2 class="section-title text-start fade-in">Get in Touch</h2>
                        <p class="section-subtitle text-start fade-in">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                        
                        <div class="contact-item fade-in">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h5>Office Address</h5>
                                <p>123 Business District<br>Technology Park, Suite 400<br>Your City, State 12345</p>
                            </div>
                        </div>
                        
                        <div class="contact-item fade-in">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h5>Phone Number</h5>
                                <p>+1 (555) 123-4567<br>Mon - Fri, 9:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                        
                        <div class="contact-item fade-in">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h5>Email Address</h5>
                                <p>support@raqib.com<br>sales@raqib.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="contact-form fade-in">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstName">First Name</label>
                                        <input type="text" class="form-control" id="firstName" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="company">Company Name</label>
                                <input type="text" class="form-control" id="company">
                            </div>
                            
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <select class="form-control" id="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="demo">Request Demo</option>
                                    <option value="pricing">Pricing Inquiry</option>
                                    <option value="support">Technical Support</option>
                                    <option value="partnership">Partnership</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" rows="5" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary-custom btn-lg w-100">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; {{ date('Y') }} Raqib. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="me-3" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a>
                    <a href="#" class="me-3" data-bs-toggle="modal" data-bs-target="#termsModal">Terms of Service</a>
                    <a href="#contact">Support</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Privacy Policy Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="privacy-content">
                        <h6>1. Information We Collect</h6>
                        <p>We collect information you provide directly to us, such as when you create an account, use our services, or contact us for support. This may include your name, email address, company information, and usage data.</p>
                        
                        <h6>2. How We Use Your Information</h6>
                        <p>We use the information we collect to provide, maintain, and improve our services, process transactions, send technical notices and support messages, and communicate with you about products and services.</p>
                        
                        <h6>3. Information Sharing</h6>
                        <p>We do not sell, trade, or rent your personal information to third parties. We may share your information only in specific circumstances such as with your consent, for legal compliance, or to protect our rights.</p>
                        
                        <h6>4. Data Security</h6>
                        <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>
                        
                        <h6>5. Data Retention</h6>
                        <p>We retain your information for as long as necessary to provide our services and fulfill the purposes outlined in this policy, unless a longer retention period is required by law.</p>
                        
                        <h6>6. Your Rights</h6>
                        <p>You have the right to access, update, or delete your personal information. You may also opt out of certain communications from us.</p>
                        
                        <h6>7. Contact Us</h6>
                        <p>If you have any questions about this Privacy Policy, please contact us at privacy@raqib.com or through our contact form.</p>
                        
                        <p class="text-muted mt-4"><small>Last updated: {{ date('F Y') }}</small></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms of Service Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms of Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="terms-content">
                        <h6>1. Acceptance of Terms</h6>
                        <p>By accessing and using Raqib services, you accept and agree to be bound by the terms and provision of this agreement.</p>
                        
                        <h6>2. Use License</h6>
                        <p>Permission is granted to temporarily use Raqib for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title.</p>
                        
                        <h6>3. Service Availability</h6>
                        <p>We strive to maintain high availability of our services but cannot guarantee 100% uptime. We reserve the right to modify or discontinue services with notice.</p>
                        
                        <h6>4. User Responsibilities</h6>
                        <p>You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.</p>
                        
                        <h6>5. Prohibited Uses</h6>
                        <p>You may not use our services for any illegal purpose or to violate any laws, including but not limited to copyright laws and privacy regulations.</p>
                        
                        <h6>6. Limitation of Liability</h6>
                        <p>Raqib shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of the service.</p>
                        
                        <h6>7. Governing Law</h6>
                        <p>These terms shall be governed by and construed in accordance with applicable laws, without regard to conflict of law provisions.</p>
                        
                        <p class="text-muted mt-4"><small>Last updated: {{ date('F Y') }}</small></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Fade in animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                
                // Handle modal links
                if (targetId === 'privacy') {
                    const privacyModal = new bootstrap.Modal(document.getElementById('privacyModal'));
                    privacyModal.show();
                    return;
                }
                
                if (targetId === 'terms') {
                    const termsModal = new bootstrap.Modal(document.getElementById('termsModal'));
                    termsModal.show();
                    return;
                }
                
                // Handle regular scroll links
                const target = document.getElementById(targetId);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Contact form handling
        document.querySelector('.contact-form form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Simple validation
            if (!data.firstName || !data.lastName || !data.email || !data.subject || !data.message) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Simulate form submission
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                alert('Thank you for your message! We\'ll get back to you soon.');
                this.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    </script>
</body>
</html>
