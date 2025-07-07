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
            --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" style="stop-color:rgba(255,255,255,0.1)"/><stop offset="100%" style="stop-color:rgba(255,255,255,0)"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>') center/cover;
            opacity: 0.5;
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
                        <img src="{{ asset('assets/images/dashboard-preview.svg') }}" alt="Raqib Dashboard" class="img-fluid" style="max-width: 90%; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.2));">
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

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; {{ date('Y') }} Raqib. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="me-3">Privacy Policy</a>
                    <a href="#" class="me-3">Terms of Service</a>
                    <a href="#">Support</a>
                </div>
            </div>
        </div>
    </footer>

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
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
