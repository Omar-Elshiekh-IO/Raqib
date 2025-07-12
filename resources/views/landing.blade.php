<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raqib - Modern HR/ERP Solution</title>
    <meta name="description" content="Raqib is a comprehensive Laravel-based HR/ERP system designed to manage core business operations including employee lifecycle management, financial transactions, project management, and client collaboration.">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/erasebg-transformed (4).png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/erasebg-transformed (4).png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/erasebg-transformed (4).png') }}" type="image/x-icon">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    
    <style>
        :root {
            --primary-color: #042949;
            --secondary-color: #1ea46c;
            --accent-color: #068c42;
            --text-dark: #1f2937;
            --text-light: #59788d;
            --bg-light: #f8fafc;
            --bg-gradient: linear-gradient(135deg, #042949 0%, #1ea46c 100%);
            --mountain-meadow: #1ea46c;
            --blue-whale: #042949;
            --jet-stream: #aecdc4;
            --salem: #068c42;
            --smalt-blue: #59788d;
            --bali-hai: #7a94ae;
            --monte-carlo: #7cccbc;
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
            transition: all 0.3s ease;
        }
        
        [dir="rtl"] body {
            font-family: 'Tajawal', sans-serif;
        }
        
        /* RTL Support */
        [dir="rtl"] .navbar-brand {
            margin-left: 0;
            margin-right: auto;
        }
        
        [dir="rtl"] .navbar-nav {
            margin-left: auto !important;
            margin-right: 0 !important;
        }
        
        [dir="rtl"] .hero-subtitle {
            text-align: right;
        }
        
        [dir="rtl"] .section-subtitle {
            text-align: center;
        }
        
        [dir="rtl"] .contact-info {
            padding-left: 2rem;
            padding-right: 0;
        }
        
        [dir="rtl"] .about-content {
            padding-left: 2rem;
            padding-right: 0;
        }
        
        [dir="rtl"] .mobile-feature-icon,
        [dir="rtl"] .about-feature-icon {
            margin-left: 1rem;
            margin-right: 0;
        }
        
        [dir="rtl"] .contact-icon {
            margin-left: 1.5rem;
            margin-right: 0;
        }
        
        .language-switcher {
            position: relative;
            margin-left: 1rem;
        }
        
        .language-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            border: 2px solid #042b4b;
            border-radius: 25px;
            padding: 0.5rem 1rem;
            color: #042b4b;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(4, 43, 75, 0.1);
            text-decoration: none;
        }
        
        .language-toggle:hover {
            background: #042b4b;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(4, 43, 75, 0.2);
        }
        
        .language-toggle:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(4, 43, 75, 0.2);
        }
        
        .current-flag {
            font-size: 1.1rem;
            margin-right: 0.25rem;
        }
        
        .current-text {
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .language-toggle i {
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }
        
        .language-toggle[aria-expanded="true"] i {
            transform: rotate(180deg);
        }
        
        .dropdown-menu.language-menu {
            background: white;
            border: 2px solid #042b4b;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            min-width: 160px;
            padding: 0.5rem;
            margin-top: 0.5rem;
            backdrop-filter: blur(10px);
        }
        
        .lang-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
            font-weight: 500;
            border: none;
            background: none;
            width: 100%;
        }
        
        .lang-option:hover {
            background: linear-gradient(135deg, #042b4b, #034068);
            color: white;
            transform: translateX(3px);
            box-shadow: 0 2px 8px rgba(4, 43, 75, 0.2);
        }
        
        .lang-option:active {
            transform: translateX(1px);
        }
        
        .lang-option.active {
            background: #042b4b;
            color: white;
        }
        
        [dir="rtl"] .language-menu {
            right: auto;
            left: 0;
        }
        
        [dir="rtl"] .language-item {
            text-align: right;
        }
        
        [dir="rtl"] .language-switcher {
            margin-left: 0;
            margin-right: 1rem;
        }
        
        [dir="rtl"] .lang-option:hover {
            transform: translateX(-3px);
        }
        
        [dir="rtl"] .current-flag {
            margin-right: 0;
            margin-left: 0.25rem;
        }
        
        @media (max-width: 768px) {
            .language-switcher {
                margin-left: 0.5rem;
            }
            
            .language-toggle {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }
            
            .current-text {
                display: none;
            }
            
            .dropdown-menu.language-menu {
                min-width: 120px;
            }
            
            [dir="rtl"] .language-switcher {
                margin-right: 0.5rem;
                margin-left: 0;
            }
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
            color: var(--blue-whale) !important;
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" style="stop-color:rgba(4,41,73,0.15)"/><stop offset="100%" style="stop-color:rgba(30,164,108,0.05)"/></radialGradient><radialGradient id="b" cx="50%" cy="50%"><stop offset="0%" style="stop-color:rgba(30,164,108,0.15)"/><stop offset="100%" style="stop-color:rgba(4,41,73,0.05)"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23b)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>') center/cover;
            opacity: 0.6;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
         
        /* Dashboard Mockup Styling */
        .dashboard-mockup {
            position: relative;
            perspective: 1000px;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .mockup-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(4, 41, 73, 0.3);
            overflow: hidden;
            transform: rotateY(-10deg) rotateX(5deg);
            transition: all 0.5s ease;
            position: relative;
            z-index: 10;
        }
        
        .mockup-container:hover {
            transform: rotateY(-5deg) rotateX(2deg) scale(1.02);
            box-shadow: 0 30px 60px rgba(4, 41, 73, 0.4);
        }
        
        .mockup-header {
            background: linear-gradient(to right, #042949, #1ea46c);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .mockup-dots {
            display: flex;
            gap: 6px;
        }
        
        .mockup-dots span {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: white;
            opacity: 0.7;
        }
        
        .mockup-dots span:nth-child(1) {
            background: #ff5f57;
        }
        
        .mockup-dots span:nth-child(2) {
            background: #febc2e;
        }
        
        .mockup-dots span:nth-child(3) {
            background: #28c840;
        }
        
        .mockup-title {
            color: white;
            font-weight: 600;
            font-size: 14px;
            margin-left: auto;
            margin-right: auto;
            letter-spacing: 0.5px;
        }
        
        .mockup-content {
            display: flex;
            height: 400px;
        }
        
        .mockup-sidebar {
            width: 80px;
            background: #f5f8fa;
            border-right: 1px solid rgba(0, 0, 0, 0.05);
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 25px;
        }
        
        .sidebar-item {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            position: relative;
        }
        
        .sidebar-item:nth-child(1) {
            background: var(--mountain-meadow);
        }
        
        .sidebar-item:nth-child(1)::after {
            content: '';
            position: absolute;
            left: -8px;
            top: 8px;
            bottom: 8px;
            width: 4px;
            background: var(--mountain-meadow);
            border-radius: 10px;
        }
        
        .mockup-main {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background: #fff;
            position: relative;
            overflow: hidden;
        }
        
        .mockup-main::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="none"/><path d="M0,0 L100,100 M100,0 L0,100" stroke="rgba(0,0,0,0.02)" stroke-width="0.5"/></svg>') repeat;
            opacity: 0.5;
        }
        
        .chart-area {
            height: 200px;
            background: linear-gradient(180deg, rgba(30, 164, 108, 0.1) 0%, rgba(30, 164, 108, 0.05) 100%);
            border-radius: 15px;
            position: relative;
            overflow: hidden;
        }
        
        .chart-area::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,40 C150,100 350,0 500,80 C650,160 750,30 900,70 C1050,110 1150,40 1200,30 L1200,120 L0,120 Z" style="fill: %231ea46c; opacity: 0.2;"/><path d="M0,60 C150,120 350,20 500,100 C650,180 750,50 900,90 C1050,130 1150,60 1200,50 L1200,120 L0,120 Z" style="fill: %231ea46c; opacity: 0.1;"/></svg>') no-repeat bottom center;
            background-size: 100% 100%;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
        
        .stat-box {
            background: #f8fafc;
            border-radius: 12px;
            height: 90px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .stat-box::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--mountain-meadow);
            opacity: 0.8;
        }
        
        .stat-box:nth-child(2)::after {
            background: #4c6ef5;
        }
        
        .stat-box:nth-child(3)::after {
            background: #f59f00;
        }
        
        .stat-box:nth-child(4)::after {
            background: #fa5252;
        }
        
        /* Animation for dashboard mockup */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .dashboard-mockup {
            animation: fadeIn 1s ease-out forwards;
            animation-delay: 0.5s;
            opacity: 0;
        }
        
        /* Mobile App Section Styling */
        .mobile-app-section {
            padding: 80px 0;
            background: white;
            overflow: hidden;
        }
        
        .mobile-app-content {
            padding-right: 2rem;
        }
        
        .mobile-features {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        
        .mobile-feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: var(--bg-light);
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        
        .mobile-feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        .mobile-feature-icon {
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
        
        .mobile-feature-icon i {
            font-size: 1.2rem;
            color: white;
        }
        
        .mobile-feature-content h5 {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        
        .mobile-feature-content p {
            color: var(--text-light);
            margin: 0;
            font-size: 0.95rem;
        }
        
        .app-download-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .app-download-btn {
            transition: all 0.3s ease;
        }
        
        .app-download-btn:hover {
            transform: translateY(-5px);
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.1));
        }
        
        /* Mobile Mockup Styling */
        .mobile-mockup-container {
            position: relative;
            perspective: 1000px;
            max-width: 300px;
            margin: 0 auto;
        }
        
        .mobile-mockup {
            background: var(--text-dark);
            border-radius: 40px;
            padding: 12px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25);
            transform: rotateY(10deg) rotateX(5deg);
            transition: all 0.5s ease;
            position: relative;
            z-index: 1;
            border: 8px solid #1a1a1a;
        }
        
        .mobile-mockup::before {
            content: '';
            position: absolute;
            width: 60px;
            height: 8px;
            background: #1a1a1a;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 8px 8px 0 0;
            z-index: 2;
        }
        
        .mobile-mockup::after {
            content: '';
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.15);
            bottom: 6px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .mobile-mockup:hover {
            transform: rotateY(5deg) rotateX(2deg) scale(1.02);
            box-shadow: 0 40px 70px rgba(0, 0, 0, 0.3);
        }
        
        .mobile-screen {
            background: white;
            border-radius: 30px;
            overflow: hidden;
            position: relative;
            height: 580px;
        }
        
        .mobile-header {
            background: var(--bg-gradient);
            padding-top: 8px;
        }
        
        .mobile-status-bar {
            padding: 0 16px 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        
        .mobile-time {
            font-size: 14px;
            font-weight: 600;
        }
        
        .mobile-indicators {
            display: flex;
            gap: 8px;
        }
        
        .mobile-indicators i {
            font-size: 12px;
        }
        
        .mobile-app-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 16px;
            color: white;
        }
        
        .mobile-app-header h4 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .mobile-profile {
            width: 32px;
            height: 32px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .mobile-avatar {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            border-radius: 50%;
        }
        
        .mobile-content {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            max-height: calc(580px - 90px);
            overflow-y: auto;
        }
        
        .mobile-attendance-card {
            background: white;
            border-radius: 20px;
            padding: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }
        
        .attendance-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        
        .attendance-header h6 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .attendance-date {
            font-size: 12px;
            color: var(--text-light);
        }
        
        .attendance-status {
            margin-bottom: 16px;
        }
        
        .attendance-time-block {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .time-entry {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .time-icon {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }
        
        .clock-in-icon {
            background: #4ade80;
        }
        
        .clock-out-icon {
            background: #f87171;
        }
        
        .time-info {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        
        .time-label {
            font-size: 12px;
            color: var(--text-light);
        }
        
        .time-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .time-separator {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 18px;
        }
        
        .separator-line {
            width: 2px;
            height: 30px;
            background: rgba(0, 0, 0, 0.1);
        }
        
        .work-duration {
            font-size: 12px;
            color: var(--text-light);
            font-weight: 500;
        }
        
        .clock-out-btn {
            border: none;
            background: #f1f5f9;
            color: var(--text-dark);
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .clock-out-btn:hover {
            background: #e2e8f0;
        }
        
        .attendance-footer {
            display: flex;
            justify-content: flex-start;
        }
        
        .status-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--text-light);
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #d1d5db;
        }
        
        .status-dot.active {
            background: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }
        
        .mobile-quick-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }
        
        .quick-action-item {
            background: white;
            border-radius: 15px;
            padding: 14px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .quick-action-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .quick-action-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }
        
        .leave-icon {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
        }
        
        .expense-icon {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }
        
        .task-icon {
            background: linear-gradient(135deg, #8b5cf6, #a78bfa);
        }
        
        .report-icon {
            background: linear-gradient(135deg, #ec4899, #f472b6);
        }
        
        .quick-action-item span {
            font-size: 12px;
            color: var(--text-dark);
            font-weight: 500;
        }
        
        /* Mobile responsiveness for mobile app section */
        @media (max-width: 991px) {
            .mobile-app-content {
                padding-right: 0;
                margin-bottom: 60px;
                text-align: center;
            }
            
            .mobile-feature-item {
                text-align: left;
            }
            
            .app-download-buttons {
                justify-content: center;
            }
        }
        
        @media (max-width: 768px) {
            .mobile-quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        /* RTL support for mobile app section */
        [dir="rtl"] .mobile-app-content {
            padding-right: 0;
            padding-left: 2rem;
        }
        
        [dir="rtl"] .mobile-feature-icon {
            margin-right: 0;
            margin-left: 1rem;
        }
        
        [dir="rtl"] .time-separator {
            margin-left: 0;
            margin-right: 18px;
        }
        
        [dir="rtl"] .mobile-mockup {
            transform: rotateY(-10deg) rotateX(5deg);
        }
        
        [dir="rtl"] .mobile-mockup:hover {
            transform: rotateY(-5deg) rotateX(2deg) scale(1.02);
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
            color: var(--blue-whale);
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
            background: var(--blue-whale);
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
            border-color: var(--mountain-meadow);
            box-shadow: 0 0 0 0.2rem rgba(30, 164, 108, 0.25);
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
            box-shadow: 0 10px 25px rgba(4, 41, 73, 0.3);
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
            color: var(--blue-whale);
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
            color: var(--blue-whale);
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
            color: var(--mountain-meadow);
            text-decoration: none;
        }
        
        .footer a:hover {
            color: white;
        }
        
        /* === FLOATING SOCIAL MEDIA ICONS === */
        .floating-social {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .floating-social .social-icon {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            font-size: 1.4rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            animation: float 3s ease-in-out infinite;
            cursor: pointer;
        }

        .floating-social .social-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .floating-social .social-icon:hover::before {
            left: 100%;
        }

        .floating-social .social-icon:hover {
            transform: translateX(-10px) scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        }

        .floating-social .social-icon.facebook {
            background: linear-gradient(135deg, #1877f2, #42a5f5);
            animation-delay: 0s;
        }

        .floating-social .social-icon.linkedin {
            background: linear-gradient(135deg, #0077b5, #00a0dc);
            animation-delay: 0.5s;
        }

        .floating-social .social-icon.whatsapp {
            background: linear-gradient(135deg, #25d366, #128c7e);
            animation-delay: 1s;
        }

        .floating-social .social-icon.facebook:hover {
            background: linear-gradient(135deg, #166fe5, #1877f2);
        }

        .floating-social .social-icon.linkedin:hover {
            background: linear-gradient(135deg, #005885, #0077b5);
        }

        .floating-social .social-icon.whatsapp:hover {
            background: linear-gradient(135deg, #128c7e, #075e54);
        }

        /* Tooltip for social icons */
        .floating-social .social-icon::after {
            content: attr(data-tooltip);
            position: absolute;
            right: 70px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .floating-social .social-icon:hover::after {
            opacity: 1;
            right: 65px;
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        /* Pulse animation for attention */
        @keyframes pulse {
            0% {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15), 0 0 0 0 rgba(24, 119, 242, 0.4);
            }
            70% {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15), 0 0 0 10px rgba(24, 119, 242, 0);
            }
            100% {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15), 0 0 0 0 rgba(24, 119, 242, 0);
            }
        }

        .floating-social .social-icon.facebook:nth-child(1) {
            animation: float 3s ease-in-out infinite, pulse 4s infinite;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .floating-social {
                right: 15px;
                gap: 12px;
            }
            
            .floating-social .social-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
            
            .floating-social .social-icon:hover {
                transform: translateX(-8px) scale(1.05);
            }
            
            .floating-social .social-icon::after {
                display: none; /* Hide tooltips on mobile */
            }
        }

        @media (max-width: 576px) {
            .floating-social {
                right: 10px;
                top: auto;
                bottom: 20px;
                transform: none;
                flex-direction: row;
                justify-content: center;
                gap: 10px;
                left: 50%;
                transform: translateX(-50%);
                background: rgba(255, 255, 255, 0.95);
                padding: 10px 15px;
                border-radius: 25px;
                backdrop-filter: blur(10px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            }
            
            .floating-social .social-icon {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }
            
            .floating-social .social-icon:hover {
                transform: scale(1.1);
            }
        }

        /* Additional entrance animation */
        .floating-social {
            animation: slideInRight 0.8s ease-out;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100px) translateY(-50%);
                opacity: 0;
            }
            to {
                transform: translateX(0) translateY(-50%);
                opacity: 1;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .floating-social .social-icon::after {
                background: rgba(255, 255, 255, 0.9);
                color: #1f2937;
            }
        }
        
        @media (max-width: 576px) {
            .floating-social {
                animation: slideInBottom 0.8s ease-out;
            }
        }

        @keyframes slideInBottom {
            from {
                transform: translateY(100px) translateX(-50%);
                opacity: 0;
            }
            to {
                transform: translateY(0) translateX(-50%);
                opacity: 1;
            }
        }

        /* All-in-One Solution Section */
        .all-in-one-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .solution-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .solution-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .solution-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .solution-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .solution-content h5 {
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .solution-content p {
            color: var(--text-light);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .platform-showcase {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }

        .showcase-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .showcase-header h4 {
            color: var(--text-dark);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .showcase-tabs {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .showcase-tabs .tab {
            padding: 0.5rem 1rem;
            background: #f1f5f9;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-light);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .showcase-tabs .tab.active {
            background: var(--secondary-color);
            color: white;
        }

        .feature-highlight {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .highlight-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 10px;
            border-left: 3px solid var(--secondary-color);
        }

        .highlight-icon {
            font-size: 1.5rem;
        }

        /* Benefits Section */
        .benefits-section {
            padding: 100px 0;
            background: white;
        }

        .benefit-card {
            text-align: center;
            padding: 2.5rem 2rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            height: 100%;
        }

        .benefit-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: var(--secondary-color);
        }

        .benefit-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }

        .benefit-card h4 {
            color: var(--text-dark);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .benefit-card p {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .benefit-stats {
            display: flex;
            justify-content: center;
        }

        .stat-highlight {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Industry Section */
        .industry-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        }

        .industry-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .industry-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .industry-image {
            text-align: center;
            margin-bottom: 2rem;
        }

        .industry-image i {
            font-size: 4rem;
            color: var(--secondary-color);
            background: linear-gradient(135deg, rgba(30, 164, 108, 0.1), rgba(6, 140, 66, 0.1));
            width: 100px;
            height: 100px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
        }

        .industry-content h4 {
            color: var(--text-dark);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .industry-content p {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .industry-features {
            list-style: none;
            padding: 0;
        }

        .industry-features li {
            padding: 0.5rem 0;
            color: var(--text-light);
            position: relative;
            padding-left: 1.5rem;
        }

        .industry-features li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--secondary-color);
            font-weight: bold;
        }

        /* Payment Section */
        .payment-section {
            padding: 100px 0;
            background: white;
        }

        .payment-features {
            margin-top: 2rem;
        }

        .payment-feature {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .payment-feature-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .payment-feature-content h5 {
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .payment-feature-content p {
            color: var(--text-light);
            line-height: 1.6;
        }

        .payment-gateways {
            text-align: center;
        }

        .gateway-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .gateway-item {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .gateway-item:hover {
            border-color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .gateway-logo {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        /* Testimonials Section */
        .testimonials-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .testimonial-stars {
            color: #fbbf24;
            margin-bottom: 1.5rem;
        }

        .testimonial-content p {
            color: var(--text-light);
            line-height: 1.6;
            font-style: italic;
            margin-bottom: 2rem;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .author-info h5 {
            color: var(--text-dark);
            margin-bottom: 0.25rem;
            font-weight: 600;
            font-size: 1rem;
        }

        .author-info span {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* Responsive Design for New Sections */
        @media (max-width: 768px) {
            .solution-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .solution-item {
                padding: 1.5rem;
            }

            .showcase-tabs {
                gap: 0.25rem;
            }

            .showcase-tabs .tab {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }

            .feature-highlight {
                grid-template-columns: 1fr;
            }

            .benefit-card {
                padding: 2rem 1.5rem;
            }

            .industry-card {
                padding: 2rem 1.5rem;
            }

            .payment-feature {
                align-items: center;
            }

            .gateway-grid {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
                gap: 0.75rem;
            }

            .gateway-item {
                padding: 1rem 0.75rem;
            }

            .testimonial-card {
                padding: 1.5rem;
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
                        <a class="nav-link" href="#features" data-translate="features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about" data-translate="about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact" data-translate="contact">Contact</a>
                    </li>
                    <li class="nav-item me-3">
                        <div class="language-switcher">
                            <button class="language-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="current-flag">🇺🇸</span>
                                <span class="current-text">English</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu language-menu">
                                <li><a class="dropdown-item lang-option" href="#" data-lang="en">🇺🇸 English</a></li>
                                <li><a class="dropdown-item lang-option" href="#" data-lang="ar">🇸🇦 العربية</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="btn px-4 py-2" style="background-color: var(--mountain-meadow); color: white; border: 1px solid var(--mountain-meadow); border-radius: 25px; font-weight: 600; transition: all 0.3s ease;" 
                           onmouseover="this.style.backgroundColor='transparent'; this.style.color='var(--mountain-meadow)';" 
                           onmouseout="this.style.backgroundColor='var(--mountain-meadow)'; this.style.color='white';" 
                           href="{{ route('login') }}" data-translate="login">Login</a>
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
                        <h1 class="hero-title fade-in" data-translate="heroTitle">Transform Your Business with Raqib</h1>
                        <p class="hero-subtitle fade-in" data-translate="heroSubtitle">A comprehensive HR/ERP solution that streamlines employee management, financial operations, project tracking, and client collaboration - all in one powerful platform.</p>
                        <div class="d-flex gap-3 flex-wrap fade-in">
                            <a href="{{ route('login') }}" class="btn btn-secondary-custom" data-translate="getStarted">
                                <i class="fas fa-rocket me-2"></i>Get Started
                            </a>
                            <a href="#features" class="btn btn-primary-custom" data-translate="features">
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
            <h2 class="section-title fade-in" data-translate="featuresTitle">Powerful Features for Modern Business</h2>
            <p class="section-subtitle fade-in" data-translate="featuresSubtitle">Everything you need to manage your business operations efficiently and effectively</p>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 data-translate="hrManagement">HR Management</h4>
                        <p data-translate="hrManagementDesc">Complete employee lifecycle management from recruitment to retirement with automated workflows and comprehensive reporting.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h4 data-translate="financialManagement">Financial Control</h4>
                        <p data-translate="financialManagementDesc">Track expenses, manage budgets, generate invoices, and maintain complete financial transparency across all operations.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h4 data-translate="projectManagement">Project Management</h4>
                        <p data-translate="projectManagementDesc">Plan, execute, and monitor projects with advanced tracking, resource allocation, and team collaboration tools.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4 data-translate="clientManagement">Client Collaboration</h4>
                        <p data-translate="clientManagementDesc">Seamless client communication, project sharing, and feedback collection to ensure exceptional service delivery.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile App Section -->
    <section class="mobile-app-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="mobile-app-content">
                        <h2 class="section-title text-start fade-in" data-translate="mobileAppTitle">Take Raqib Anywhere</h2>
                        <p class="section-subtitle text-start fade-in" data-translate="mobileAppSubtitle">Our powerful mobile application puts essential HR and business tools right in your pocket.</p>
                        
                        <div class="mobile-features fade-in">
                            <div class="mobile-feature-item">
                                <div class="mobile-feature-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="mobile-feature-content">
                                    <h5 data-translate="mobileAppFeature1">Smart Attendance</h5>
                                    <p data-translate="mobileAppFeature1Desc">Clock in/out with GPS tracking, facial recognition, and automatic location detection for accurate attendance management.</p>
                                </div>
                            </div>
                            
                            <div class="mobile-feature-item">
                                <div class="mobile-feature-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="mobile-feature-content">
                                    <h5 data-translate="mobileAppFeature2">Leave Management</h5>
                                    <p data-translate="mobileAppFeature2Desc">Apply for leave, check balances, and track approval status directly from your mobile device.</p>
                                </div>
                            </div>
                            
                            <div class="mobile-feature-item">
                                <div class="mobile-feature-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="mobile-feature-content">
                                    <h5 data-translate="mobileAppFeature3">Expense Tracking</h5>
                                    <p data-translate="mobileAppFeature3Desc">Capture receipts, submit expenses, and track reimbursements on the go with our intuitive mobile interface.</p>
                                </div>
                            </div>
                            
                            <div class="mobile-feature-item">
                                <div class="mobile-feature-icon">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="mobile-feature-content">
                                    <h5 data-translate="mobileAppFeature4">Real-time Notifications</h5>
                                    <p data-translate="mobileAppFeature4Desc">Stay updated with push notifications for approvals, deadlines, and important company announcements.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="app-download-buttons fade-in">
                            <a href="#" class="app-download-btn">
                                <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="Download on App Store" height="50">
                            </a>
                            <a href="#" class="app-download-btn">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Get it on Google Play" height="50">
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="mobile-mockup-container fade-in">
                        <div class="mobile-mockup">
                            <div class="mobile-screen">
                                <div class="mobile-header">
                                    <div class="mobile-status-bar">
                                        <span class="mobile-time">9:41</span>
                                        <div class="mobile-indicators">
                                            <i class="fas fa-signal"></i>
                                            <i class="fas fa-wifi"></i>
                                            <i class="fas fa-battery-full"></i>
                                        </div>
                                    </div>
                                    <div class="mobile-app-header">
                                        <h4>Raqib Mobile</h4>
                                        <div class="mobile-profile">
                                            <div class="mobile-avatar"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mobile-content">
                                    <div class="mobile-attendance-card">
                                        <div class="attendance-header">
                                            <h6 data-translate="attendanceTitle">Today's Attendance</h6>
                                            <span class="attendance-date" data-translate="today">Dec 15, 2024</span>
                                        </div>
                                        <div class="attendance-status">
                                            <div class="attendance-time-block">
                                                <div class="time-entry">
                                                    <div class="time-icon clock-in-icon">
                                                        <i class="fas fa-sign-in-alt"></i>
                                                    </div>
                                                    <div class="time-info">
                                                        <span class="time-label" data-translate="clockIn">Clock In</span>
                                                        <span class="time-value">9:00 AM</span>
                                                    </div>
                                                </div>
                                                <div class="time-separator">
                                                    <div class="separator-line"></div>
                                                    <span class="work-duration">7h 45m</span>
                                                </div>
                                                <div class="time-entry">
                                                    <div class="time-icon clock-out-icon">
                                                        <i class="fas fa-sign-out-alt"></i>
                                                    </div>
                                                    <div class="time-info">
                                                        <span class="time-label" data-translate="clockOut">Clock Out</span>
                                                        <button class="clock-out-btn">Tap to Clock Out</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="attendance-footer">
                                            <div class="status-indicator">
                                                <div class="status-dot active"></div>
                                                <span>Currently Working</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mobile-quick-actions">
                                        <div class="quick-action-item">
                                            <div class="quick-action-icon leave-icon">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <span>Leave</span>
                                        </div>
                                        <div class="quick-action-item">
                                            <div class="quick-action-icon expense-icon">
                                                <i class="fas fa-receipt"></i>
                                            </div>
                                            <span>Expense</span>
                                        </div>
                                        <div class="quick-action-item">
                                            <div class="quick-action-icon task-icon">
                                                <i class="fas fa-tasks"></i>
                                            </div>
                                            <span>Tasks</span>
                                        </div>
                                        <div class="quick-action-item">
                                            <div class="quick-action-icon report-icon">
                                                <i class="fas fa-chart-bar"></i>
                                            </div>
                                            <span>Reports</span>
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

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-content">
                        <h2 class="section-title text-start fade-in" data-translate="aboutTitle">About Raqib</h2>
                        <p class="section-subtitle text-start fade-in" data-translate="aboutSubtitle">Empowering businesses with innovative HR/ERP solutions since 2020.</p>
                        
                        <div class="about-text fade-in">
                            <p data-translate="aboutDesc">Raqib was founded with a simple mission: to streamline business operations and empower organizations to focus on what matters most - their people and growth. Our comprehensive HR/ERP platform combines cutting-edge technology with intuitive design to deliver solutions that actually work.</p>
                            
                            <p data-translate="aboutDesc2">With years of experience in enterprise software development, our team understands the challenges businesses face in managing complex operations. That's why we've built Raqib to be more than just software - it's a complete business transformation platform.</p>
                        </div>
                        
                        <div class="about-features fade-in">
                            <div class="about-feature-item">
                                <div class="about-feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="about-feature-content">
                                    <h5 data-translate="modernTech">Enterprise Security</h5>
                                    <p data-translate="modernTechDesc">Bank-level encryption and security protocols to protect your sensitive business data.</p>
                                </div>
                            </div>
                            
                            <div class="about-feature-item">
                                <div class="about-feature-icon">
                                    <i class="fas fa-cloud"></i>
                                </div>
                                <div class="about-feature-content">
                                    <h5 data-translate="scalable">Cloud-First Approach</h5>
                                    <p data-translate="scalableDesc">Access your data anywhere, anytime with our robust cloud infrastructure.</p>
                                </div>
                            </div>
                            
                            <div class="about-feature-item">
                                <div class="about-feature-icon">
                                    <i class="fas fa-users-cog"></i>
                                </div>
                                <div class="about-feature-content">
                                    <h5 data-translate="secure">Expert Support</h5>
                                    <p data-translate="secureDesc">Dedicated support team to help you maximize your investment in Raqib.</p>
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

    <!-- All-in-One Solution Section -->
    <section class="all-in-one-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="all-in-one-content">
                        <h2 class="section-title text-start fade-in" data-translate="allInOneTitle">One Platform, Endless Possibilities</h2>
                        <p class="section-subtitle text-start fade-in" data-translate="allInOneSubtitle">Replace multiple expensive software subscriptions with one comprehensive platform that grows with your business.</p>
                        
                        <div class="solution-grid fade-in">
                            <div class="solution-item">
                                <div class="solution-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                <div class="solution-content">
                                    <h5 data-translate="dashboardAnalytics">Dashboard & Analytics</h5>
                                    <p data-translate="dashboardAnalyticsDesc">Smart overview dashboard with real-time reports and multiple specialized views for different departments.</p>
                                </div>
                            </div>
                            
                            <div class="solution-item">
                                <div class="solution-icon">
                                    <i class="fas fa-cash-register"></i>
                                </div>
                                <div class="solution-content">
                                    <h5 data-translate="posInventory">POS & Inventory</h5>
                                    <p data-translate="posInventoryDesc">Complete point-of-sale system with inventory management, barcode support, and multi-location tracking.</p>
                                </div>
                            </div>
                            
                            <div class="solution-item">
                                <div class="solution-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="solution-content">
                                    <h5 data-translate="crmLeads">CRM & Lead Management</h5>
                                    <p data-translate="crmLeadsDesc">Capture leads, track sales pipelines, manage customer relationships, and boost conversion rates.</p>
                                </div>
                            </div>
                            
                            <div class="solution-item">
                                <div class="solution-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div class="solution-content">
                                    <h5 data-translate="collaboration">Team Collaboration</h5>
                                    <p data-translate="collaborationDesc">Built-in messenger, video meetings, document sharing, and real-time notifications for seamless teamwork.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="all-in-one-visual fade-in">
                        <div class="platform-showcase">
                            <div class="showcase-header">
                                <h4>Raqib Business Platform</h4>
                                <div class="showcase-tabs">
                                    <span class="tab active">HRM</span>
                                    <span class="tab">Accounting</span>
                                    <span class="tab">CRM</span>
                                    <span class="tab">POS</span>
                                    <span class="tab">Projects</span>
                                </div>
                            </div>
                            <div class="showcase-content">
                                <div class="feature-highlight">
                                    <div class="highlight-item">
                                        <div class="highlight-icon">💼</div>
                                        <span>Employee Management</span>
                                    </div>
                                    <div class="highlight-item">
                                        <div class="highlight-icon">📊</div>
                                        <span>Financial Reports</span>
                                    </div>
                                    <div class="highlight-item">
                                        <div class="highlight-icon">🎯</div>
                                        <span>Sales Pipeline</span>
                                    </div>
                                    <div class="highlight-item">
                                        <div class="highlight-icon">🛒</div>
                                        <span>Point of Sale</span>
                                    </div>
                                    <div class="highlight-item">
                                        <div class="highlight-icon">📋</div>
                                        <span>Project Tracking</span>
                                    </div>
                                    <div class="highlight-item">
                                        <div class="highlight-icon">💳</div>
                                        <span>Payment Gateway</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Business Benefits Section -->
    <section class="benefits-section">
        <div class="container">
            <h2 class="section-title fade-in" data-translate="benefitsTitle">Why Businesses Choose Raqib</h2>
            <p class="section-subtitle fade-in" data-translate="benefitsSubtitle">Discover how Raqib transforms business operations and drives growth</p>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="benefit-card fade-in">
                        <div class="benefit-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h4 data-translate="costEffective">Cost-Effective Solution</h4>
                        <p data-translate="costEffectiveDesc">Save up to 70% compared to using multiple software solutions. One platform, one price, unlimited possibilities.</p>
                        <div class="benefit-stats">
                            <span class="stat-highlight">70% Cost Savings</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="benefit-card fade-in">
                        <div class="benefit-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h4 data-translate="quickImplementation">Quick Implementation</h4>
                        <p data-translate="quickImplementationDesc">Get your business up and running in days, not months. Our intuitive design requires minimal training.</p>
                        <div class="benefit-stats">
                            <span class="stat-highlight">3 Days Setup</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="benefit-card fade-in">
                        <div class="benefit-icon">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </div>
                        <h4 data-translate="scalableGrowth">Scalable Growth</h4>
                        <p data-translate="scalableGrowthDesc">From startup to enterprise, Raqib grows with your business. Add users, features, and modules as needed.</p>
                        <div class="benefit-stats">
                            <span class="stat-highlight">Unlimited Scale</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="benefit-card fade-in">
                        <div class="benefit-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 data-translate="enterpriseSecurity">Enterprise Security</h4>
                        <p data-translate="enterpriseSecurityDesc">Bank-level encryption, secure cloud hosting, and compliance with international security standards.</p>
                        <div class="benefit-stats">
                            <span class="stat-highlight">99.9% Secure</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="benefit-card fade-in">
                        <div class="benefit-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4 data-translate="mobileFirst">Mobile-First Design</h4>
                        <p data-translate="mobileFirstDesc">Access your business data anywhere, anytime. Fully responsive design optimized for all devices.</p>
                        <div class="benefit-stats">
                            <span class="stat-highlight">100% Mobile</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="benefit-card fade-in">
                        <div class="benefit-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4 data-translate="dedicatedSupport">Expert Support</h4>
                        <p data-translate="dedicatedSupportDesc">24/7 customer support, comprehensive documentation, and training resources to ensure your success.</p>
                        <div class="benefit-stats">
                            <span class="stat-highlight">24/7 Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Industry Solutions Section -->
    <section class="industry-section">
        <div class="container">
            <h2 class="section-title fade-in" data-translate="industryTitle">Perfect for Every Industry</h2>
            <p class="section-subtitle fade-in" data-translate="industrySubtitle">Raqib adapts to your business needs, regardless of your industry</p>
            
            <div class="row g-4">
                <div class="col-lg-6 col-md-6">
                    <div class="industry-card fade-in">
                        <div class="industry-image">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="industry-content">
                            <h4 data-translate="retailBusiness">Retail Businesses</h4>
                            <p data-translate="retailBusinessDesc">Complete POS system, inventory management, customer tracking, and sales analytics for retail success.</p>
                            <ul class="industry-features">
                                <li>Multi-location inventory</li>
                                <li>Barcode scanning</li>
                                <li>Customer loyalty programs</li>
                                <li>Sales reporting</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6">
                    <div class="industry-card fade-in">
                        <div class="industry-image">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="industry-content">
                            <h4 data-translate="serviceBusiness">Service Companies</h4>
                            <p data-translate="serviceBusinessDesc">Project management, time tracking, client collaboration, and service delivery optimization tools.</p>
                            <ul class="industry-features">
                                <li>Project timelines</li>
                                <li>Resource allocation</li>
                                <li>Client portals</li>
                                <li>Time billing</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6">
                    <div class="industry-card fade-in">
                        <div class="industry-image">
                            <i class="fas fa-industry"></i>
                        </div>
                        <div class="industry-content">
                            <h4 data-translate="manufacturing">Manufacturing</h4>
                            <p data-translate="manufacturingDesc">Supply chain management, production planning, quality control, and operational efficiency tools.</p>
                            <ul class="industry-features">
                                <li>Production tracking</li>
                                <li>Quality management</li>
                                <li>Supplier management</li>
                                <li>Cost analysis</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6">
                    <div class="industry-card fade-in">
                        <div class="industry-image">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <div class="industry-content">
                            <h4 data-translate="techStartups">Tech Startups</h4>
                            <p data-translate="techStartupsDesc">Agile project management, team collaboration, rapid scaling tools, and investor reporting capabilities.</p>
                            <ul class="industry-features">
                                <li>Agile workflows</li>
                                <li>Team collaboration</li>
                                <li>Growth analytics</li>
                                <li>Investor dashboards</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Integration Section -->
    <section class="payment-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="payment-content">
                        <h2 class="section-title text-start fade-in" data-translate="paymentTitle">Global Payment Solutions</h2>
                        <p class="section-subtitle text-start fade-in" data-translate="paymentSubtitle">Accept payments from customers worldwide with our extensive payment gateway integrations.</p>
                        
                        <div class="payment-features fade-in">
                            <div class="payment-feature">
                                <div class="payment-feature-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div class="payment-feature-content">
                                    <h5 data-translate="globalPayments">Global Coverage</h5>
                                    <p data-translate="globalPaymentsDesc">Support for 150+ currencies and payment methods across all major regions.</p>
                                </div>
                            </div>
                            
                            <div class="payment-feature">
                                <div class="payment-feature-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div class="payment-feature-content">
                                    <h5 data-translate="secureTransactions">Secure Transactions</h5>
                                    <p data-translate="secureTransactionsDesc">PCI DSS compliant with end-to-end encryption for maximum security.</p>
                                </div>
                            </div>
                            
                            <div class="payment-feature">
                                <div class="payment-feature-icon">
                                    <i class="fas fa-zap"></i>
                                </div>
                                <div class="payment-feature-content">
                                    <h5 data-translate="instantProcessing">Instant Processing</h5>
                                    <p data-translate="instantProcessingDesc">Real-time payment processing with instant notifications and updates.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="payment-gateways fade-in">
                        <h4 class="text-center mb-4" data-translate="supportedGateways">Supported Payment Gateways</h4>
                        <div class="gateway-grid">
                            <div class="gateway-item">
                                <div class="gateway-logo">PayPal</div>
                            </div>
                            <div class="gateway-item">
                                <div class="gateway-logo">Stripe</div>
                            </div>
                            <div class="gateway-item">
                                <div class="gateway-logo">Razorpay</div>
                            </div>
                            <div class="gateway-item">
                                <div class="gateway-logo">PayTabs</div>
                            </div>
                            <div class="gateway-item">
                                <div class="gateway-logo">Mollie</div>
                            </div>
                            <div class="gateway-item">
                                <div class="gateway-logo">PayStack</div>
                            </div>
                            <div class="gateway-item">
                                <div class="gateway-logo">FedaPay</div>
                            </div>
                            <div class="gateway-item">
                                <div class="gateway-logo">PayHere</div>
                            </div>
                            <div class="gateway-item">
                                <div class="gateway-logo">Midtrans</div>
                            </div>
                            <div class="gateway-item">
                                <div class="gateway-logo">Bank Transfer</div>
                            </div>
                            <div class="gateway-item">
                                <div class="gateway-logo">Cash</div>
                            </div>
                            <div class="gateway-item">
                                <div class="gateway-logo">+ More</div>
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
                        <div class="stat-label" data-translate="companiesTrust">Companies Trust Us</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label" data-translate="activeUsers">Active Users</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in">
                        <div class="stat-number">99.9%</div>
                        <div class="stat-label" data-translate="uptime">Uptime</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label" data-translate="support">Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <h2 class="section-title fade-in" data-translate="testimonialsTitle">What Our Customers Say</h2>
            <p class="section-subtitle fade-in" data-translate="testimonialsSubtitle">Real stories from businesses that transformed with Raqib</p>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card fade-in">
                        <div class="testimonial-content">
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p data-translate="testimonial1">"Raqib transformed our business operations completely. We eliminated 5 different software subscriptions and saved thousands while improving efficiency."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="author-info">
                                <h5>Sarah Johnson</h5>
                                <span>CEO, TechFlow Solutions</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card fade-in">
                        <div class="testimonial-content">
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p data-translate="testimonial2">"The POS system and inventory management features are incredible. Our retail operations have never been smoother, and the reports help us make better decisions."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="author-info">
                                <h5>Ahmed Al-Rashid</h5>
                                <span>Owner, Modern Retail Chain</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card fade-in">
                        <div class="testimonial-content">
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p data-translate="testimonial3">"Project management and team collaboration features are outstanding. Our remote team is more productive than ever, and clients love the transparency."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="author-info">
                                <h5>Maria Rodriguez</h5>
                                <span>Project Manager, Digital Agency</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title fade-in" data-translate="ctaTitle">Ready to Transform Your Business?</h2>
            <p class="cta-subtitle fade-in" data-translate="ctaSubtitle">Join thousands of companies that have streamlined their operations with Raqib</p>
            <div class="fade-in">
                <a href="{{ route('login') }}" class="btn btn-secondary-custom btn-lg" data-translate="ctaButton">
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
                        <h2 class="section-title text-start fade-in" data-translate="contactTitle">Get in Touch</h2>
                        <p class="section-subtitle text-start fade-in" data-translate="contactSubtitle">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                        
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
                    <p>&copy; {{ date('Y') }} Raqib. <span data-translate="allRightsReserved">All rights reserved.</span></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="me-3" data-bs-toggle="modal" data-bs-target="#privacyModal" data-translate="privacyPolicy">Privacy Policy</a>
                    <a href="#" class="me-3" data-bs-toggle="modal" data-bs-target="#termsModal" data-translate="termsConditions">Terms of Service</a>
                    <a href="#contact" data-translate="support">Support</a>
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

        // Language switching functionality
        const translations = {
            en: {
                // Navigation
                features: 'Features',
                pricing: 'Pricing',
                about: 'About',
                contact: 'Contact',
                login: 'Login',
                getStarted: 'Get Started',
                
                // Hero Section
                heroTitle: 'Transform Your Business with Raqib',
                heroSubtitle: 'A comprehensive HR/ERP solution that streamlines employee management, financial operations, project tracking, and client collaboration - all in one powerful platform.',
                
                // Features Section
                featuresTitle: 'Powerful Features for Modern Business',
                featuresSubtitle: 'Everything you need to manage your business operations efficiently and effectively',
                
                // Feature Cards
                hrManagement: 'HR Management',
                hrManagementDesc: 'Complete employee lifecycle management from recruitment to retirement with automated workflows and comprehensive reporting.',
                
                financialManagement: 'Financial Control',
                financialManagementDesc: 'Track expenses, manage budgets, generate invoices, and maintain complete financial transparency across all operations.',
                
                projectManagement: 'Project Management',
                projectManagementDesc: 'Plan, execute, and monitor projects with advanced tracking, resource allocation, and team collaboration tools.',
                
                clientManagement: 'Client Collaboration',
                clientManagementDesc: 'Seamless client communication, project sharing, and feedback collection to ensure exceptional service delivery.',

                // All-in-One Section
                allInOneTitle: 'One Platform, Endless Possibilities',
                allInOneSubtitle: 'Replace multiple expensive software subscriptions with one comprehensive platform that grows with your business.',
                dashboardAnalytics: 'Dashboard & Analytics',
                dashboardAnalyticsDesc: 'Smart overview dashboard with real-time reports and multiple specialized views for different departments.',
                posInventory: 'POS & Inventory',
                posInventoryDesc: 'Complete point-of-sale system with inventory management, barcode support, and multi-location tracking.',
                crmLeads: 'CRM & Lead Management',
                crmLeadsDesc: 'Capture leads, track sales pipelines, manage customer relationships, and boost conversion rates.',
                collaboration: 'Team Collaboration',
                collaborationDesc: 'Built-in messenger, video meetings, document sharing, and real-time notifications for seamless teamwork.',

                // Benefits Section
                benefitsTitle: 'Why Businesses Choose Raqib',
                benefitsSubtitle: 'Discover how Raqib transforms business operations and drives growth',
                costEffective: 'Cost-Effective Solution',
                costEffectiveDesc: 'Save up to 70% compared to using multiple software solutions. One platform, one price, unlimited possibilities.',
                quickImplementation: 'Quick Implementation',
                quickImplementationDesc: 'Get your business up and running in days, not months. Our intuitive design requires minimal training.',
                scalableGrowth: 'Scalable Growth',
                scalableGrowthDesc: 'From startup to enterprise, Raqib grows with your business. Add users, features, and modules as needed.',
                enterpriseSecurity: 'Enterprise Security',
                enterpriseSecurityDesc: 'Bank-level encryption, secure cloud hosting, and compliance with international security standards.',
                mobileFirst: 'Mobile-First Design',
                mobileFirstDesc: 'Access your business data anywhere, anytime. Fully responsive design optimized for all devices.',
                dedicatedSupport: 'Expert Support',
                dedicatedSupportDesc: '24/7 customer support, comprehensive documentation, and training resources to ensure your success.',

                // Industry Section
                industryTitle: 'Perfect for Every Industry',
                industrySubtitle: 'Raqib adapts to your business needs, regardless of your industry',
                retailBusiness: 'Retail Businesses',
                retailBusinessDesc: 'Complete POS system, inventory management, customer tracking, and sales analytics for retail success.',
                serviceBusiness: 'Service Companies',
                serviceBusinessDesc: 'Project management, time tracking, client collaboration, and service delivery optimization tools.',
                manufacturing: 'Manufacturing',
                manufacturingDesc: 'Supply chain management, production planning, quality control, and operational efficiency tools.',
                techStartups: 'Tech Startups',
                techStartupsDesc: 'Agile project management, team collaboration, rapid scaling tools, and investor reporting capabilities.',

                // Payment Section
                paymentTitle: 'Global Payment Solutions',
                paymentSubtitle: 'Accept payments from customers worldwide with our extensive payment gateway integrations.',
                globalPayments: 'Global Coverage',
                globalPaymentsDesc: 'Support for 150+ currencies and payment methods across all major regions.',
                secureTransactions: 'Secure Transactions',
                secureTransactionsDesc: 'PCI DSS compliant with end-to-end encryption for maximum security.',
                instantProcessing: 'Instant Processing',
                instantProcessingDesc: 'Real-time payment processing with instant notifications and updates.',
                supportedGateways: 'Supported Payment Gateways',

                // Testimonials Section
                testimonialsTitle: 'What Our Customers Say',
                testimonialsSubtitle: 'Real stories from businesses that transformed with Raqib',
                testimonial1: '"Raqib transformed our business operations completely. We eliminated 5 different software subscriptions and saved thousands while improving efficiency."',
                testimonial2: '"The POS system and inventory management features are incredible. Our retail operations have never been smoother, and the reports help us make better decisions."',
                testimonial3: '"Project management and team collaboration features are outstanding. Our remote team is more productive than ever, and clients love the transparency."',
                
                // Mobile App Section
                mobileAppTitle: 'Take Raqib Anywhere',
                mobileAppSubtitle: 'Our powerful mobile application puts essential HR and business tools right in your pocket.',
                mobileAppFeature1: 'Smart Attendance',
                mobileAppFeature1Desc: 'Clock in/out with GPS tracking, facial recognition, and automatic location detection for accurate attendance management.',
                mobileAppFeature2: 'Leave Management',
                mobileAppFeature2Desc: 'Apply for leave, check balances, and track approval status directly from your mobile device.',
                mobileAppFeature3: 'Expense Tracking',
                mobileAppFeature3Desc: 'Capture receipts, submit expenses, and track reimbursements on the go with our intuitive mobile interface.',
                mobileAppFeature4: 'Real-time Notifications',
                mobileAppFeature4Desc: 'Stay updated with push notifications for approvals, deadlines, and important company announcements.',
                downloadApp: 'Download App',
                
                // Mobile UI
                attendanceTitle: 'Today\'s Attendance',
                today: 'Today',
                clockIn: 'Clock In',
                clockOut: 'Clock Out',
                currentStatus: 'Current Status',
                workingHours: 'Working Hours',
                
                // Stats
                companiesTrust: 'Companies Trust Us',
                activeUsers: 'Active Users',
                uptime: 'Uptime',
                support: 'Support',
                
                // CTA Section
                ctaTitle: 'Ready to Transform Your Business?',
                ctaSubtitle: 'Join thousands of companies that have streamlined their operations with Raqib',
                ctaButton: 'Start Your Journey',
                
                // About Section
                aboutTitle: 'About Raqib',
                aboutSubtitle: 'Built with modern technology for tomorrow\'s businesses',
                aboutDesc: 'Raqib is a comprehensive Laravel-based HR/ERP system designed to manage core business operations including employee lifecycle management, financial transactions, project management, and client collaboration.',
                aboutDesc2: 'With years of experience in enterprise software development, our team understands the challenges businesses face in managing complex operations. That\'s why we\'ve built Raqib to be more than just software - it\'s a complete business transformation platform.',
                
                // About Features
                modernTech: 'Enterprise Security',
                modernTechDesc: 'Bank-level encryption and security protocols to protect your sensitive business data.',
                
                scalable: 'Cloud-First Approach',
                scalableDesc: 'Access your data anywhere, anytime with our robust cloud infrastructure.',
                
                secure: 'Expert Support',
                secureDesc: 'Dedicated support team to help you maximize your investment in Raqib.',
                
                // Contact Section
                contactTitle: 'Get in Touch',
                contactSubtitle: 'Ready to transform your business operations?',
                firstName: 'First Name',
                lastName: 'Last Name',
                email: 'Email',
                subject: 'Subject',
                message: 'Message',
                sendMessage: 'Send Message',
                
                // Footer
                quickLinks: 'Quick Links',
                resources: 'Resources',
                support: 'Support',
                allRightsReserved: 'All rights reserved.',
                privacyPolicy: 'Privacy Policy',
                termsConditions: 'Terms & Conditions',
                documentation: 'Documentation',
                apiReference: 'API Reference',
                helpCenter: 'Help Center',
                technicalSupport: 'Technical Support'
            },
            ar: {
                // Navigation
                features: 'الميزات',
                pricing: 'التسعير',
                about: 'حول',
                contact: 'اتصل بنا',
                login: 'تسجيل الدخول',
                getStarted: 'ابدأ الآن',
                
                // Hero Section
                heroTitle: 'حوّل عملك مع رقيب',
                heroSubtitle: 'حل شامل لإدارة الموارد البشرية وتخطيط موارد المؤسسة يبسط إدارة الموظفين والعمليات المالية وتتبع المشاريع والتعاون مع العملاء - كل ذلك في منصة واحدة قوية.',
                
                // Features Section
                featuresTitle: 'ميزات قوية للأعمال الحديثة',
                featuresSubtitle: 'كل ما تحتاجه لإدارة عمليات عملك بكفاءة وفعالية',
                
                // Feature Cards
                hrManagement: 'إدارة الموارد البشرية',
                hrManagementDesc: 'إدارة كاملة لدورة حياة الموظفين من التوظيف إلى التقاعد مع سير عمل آلي وتقارير شاملة.',
                
                financialManagement: 'السيطرة المالية',
                financialManagementDesc: 'تتبع المصروفات وإدارة الميزانيات وإنشاء الفواتير والحفاظ على الشفافية المالية الكاملة عبر جميع العمليات.',
                
                projectManagement: 'إدارة المشاريع',
                projectManagementDesc: 'خطط ونفذ وراقب المشاريع بتتبع متقدم وتخصيص الموارد وأدوات التعاون الجماعي.',
                
                clientManagement: 'التعاون مع العملاء',
                clientManagementDesc: 'تواصل سلس مع العملاء ومشاركة المشاريع وجمع التعليقات لضمان تقديم خدمة استثنائية.',

                // All-in-One Section
                allInOneTitle: 'منصة واحدة، إمكانيات لا محدودة',
                allInOneSubtitle: 'استبدل اشتراكات البرامج المتعددة والمكلفة بمنصة شاملة واحدة تنمو مع عملك.',
                dashboardAnalytics: 'لوحة المعلومات والتحليلات',
                dashboardAnalyticsDesc: 'لوحة معلومات ذكية مع تقارير في الوقت الفعلي ومناظر متخصصة متعددة للأقسام المختلفة.',
                posInventory: 'نقطة البيع والمخزون',
                posInventoryDesc: 'نظام نقطة بيع كامل مع إدارة المخزون ودعم الباركود وتتبع المواقع المتعددة.',
                crmLeads: 'إدارة العملاء والعملاء المحتملين',
                crmLeadsDesc: 'التقط العملاء المحتملين وتتبع خطوط المبيعات وإدارة علاقات العملاء وزيادة معدلات التحويل.',
                collaboration: 'التعاون الجماعي',
                collaborationDesc: 'مراسل مدمج واجتماعات فيديو ومشاركة المستندات والإشعارات في الوقت الفعلي للعمل الجماعي السلس.',

                // Benefits Section
                benefitsTitle: 'لماذا تختار الشركات رقيب',
                benefitsSubtitle: 'اكتشف كيف يحول رقيب عمليات الأعمال ويدفع النمو',
                costEffective: 'حل فعال من حيث التكلفة',
                costEffectiveDesc: 'وفر حتى 70% مقارنة باستخدام حلول برمجية متعددة. منصة واحدة، سعر واحد، إمكانيات لا محدودة.',
                quickImplementation: 'تنفيذ سريع',
                quickImplementationDesc: 'اجعل عملك يعمل في أيام وليس شهور. تصميمنا البديهي يتطلب تدريبًا أدنى.',
                scalableGrowth: 'نمو قابل للتوسع',
                scalableGrowthDesc: 'من الشركة الناشئة إلى المؤسسة، ينمو رقيب مع عملك. أضف المستخدمين والميزات والوحدات حسب الحاجة.',
                enterpriseSecurity: 'أمان المؤسسة',
                enterpriseSecurityDesc: 'تشفير على مستوى البنوك واستضافة سحابية آمنة والامتثال لمعايير الأمان الدولية.',
                mobileFirst: 'تصميم يركز على الهاتف المحمول',
                mobileFirstDesc: 'اصل إلى بيانات عملك في أي مكان وأي وقت. تصميم متجاوب بالكامل محسن لجميع الأجهزة.',
                dedicatedSupport: 'دعم خبير',
                dedicatedSupportDesc: 'دعم عملاء على مدار الساعة وتوثيق شامل وموارد تدريبية لضمان نجاحك.',

                // Industry Section
                industryTitle: 'مثالي لكل صناعة',
                industrySubtitle: 'رقيب يتكيف مع احتياجات عملك، بغض النظر عن صناعتك',
                retailBusiness: 'الأعمال التجارية',
                retailBusinessDesc: 'نظام نقطة بيع كامل وإدارة المخزون وتتبع العملاء وتحليلات المبيعات لنجاح التجارة.',
                serviceBusiness: 'شركات الخدمات',
                serviceBusinessDesc: 'إدارة المشاريع وتتبع الوقت وتعاون العملاء وأدوات تحسين تقديم الخدمات.',
                manufacturing: 'التصنيع',
                manufacturingDesc: 'إدارة سلسلة التوريد وتخطيط الإنتاج ومراقبة الجودة وأدوات الكفاءة التشغيلية.',
                techStartups: 'الشركات التقنية الناشئة',
                techStartupsDesc: 'إدارة المشاريع المرنة وتعاون الفريق وأدوات التوسع السريع وقدرات تقارير المستثمرين.',

                // Payment Section
                paymentTitle: 'حلول الدفع العالمية',
                paymentSubtitle: 'اقبل المدفوعات من العملاء في جميع أنحاء العالم مع تكاملات بوابات الدفع الواسعة لدينا.',
                globalPayments: 'تغطية عالمية',
                globalPaymentsDesc: 'دعم لأكثر من 150 عملة وطريقة دفع عبر جميع المناطق الرئيسية.',
                secureTransactions: 'معاملات آمنة',
                secureTransactionsDesc: 'متوافق مع PCI DSS مع تشفير من النهاية إلى النهاية لأقصى أمان.',
                instantProcessing: 'معالجة فورية',
                instantProcessingDesc: 'معالجة دفع في الوقت الفعلي مع إشعارات وتحديثات فورية.',
                supportedGateways: 'بوابات الدفع المدعومة',

                // Testimonials Section
                testimonialsTitle: 'ماذا يقول عملاؤنا',
                testimonialsSubtitle: 'قصص حقيقية من الشركات التي تحولت مع رقيب',
                testimonial1: '"رقيب حول عمليات أعمالنا بالكامل. ألغينا 5 اشتراكات برمجية مختلفة ووفرنا آلاف الدولارات مع تحسين الكفاءة."',
                testimonial2: '"نظام نقاط البيع وميزات إدارة المخزون مذهلة. عملياتنا التجارية لم تكن أبدًا أكثر سلاسة، والتقارير تساعدنا على اتخاذ قرارات أفضل."',
                testimonial3: '"ميزات إدارة المشاريع والتعاون الجماعي متميزة. فريقنا البعيد أكثر إنتاجية من أي وقت مضى، والعملاء يحبون الشفافية."',
                
                // Mobile App Section
                mobileAppTitle: 'اصطحب رقيب معك',
                mobileAppSubtitle: 'تطبيق الهاتف المحمول القوي يضع أدوات الموارد البشرية والأعمال الأساسية في متناول يدك.',
                mobileAppFeature1: 'حضور ذكي',
                mobileAppFeature1Desc: 'تسجيل الدخول/الخروج مع تتبع نظام تحديد المواقع العالمي وتقنية التعرف على الوجه والكشف التلقائي عن المواقع لإدارة الحضور بدقة.',
                mobileAppFeature2: 'إدارة الإجازات',
                mobileAppFeature2Desc: 'تقدم للحصول على إجازة، تحقق من الأرصدة، وتتبع حالة الموافقة مباشرة من جهازك المحمول.',
                mobileAppFeature3: 'تتبع المصروفات',
                mobileAppFeature3Desc: 'التقط الإيصالات، أرسل المصروفات، وتتبع المبالغ المستردة أثناء التنقل باستخدام واجهة الهاتف المحمول البديهية.',
                mobileAppFeature4: 'إشعارات في الوقت الفعلي',
                mobileAppFeature4Desc: 'ابق على اطلاع مع الإشعارات الفورية للموافقات والمواعيد النهائية والإعلانات المهمة للشركة.',
                downloadApp: 'تحميل التطبيق',
                
                // Mobile UI
                attendanceTitle: 'حضور اليوم',
                today: 'اليوم',
                clockIn: 'تسجيل الحضور',
                clockOut: 'تسجيل الانصراف',
                currentStatus: 'الحالة الحالية',
                workingHours: 'ساعات العمل',
                
                // Stats
                companiesTrust: 'الشركات التي تثق بنا',
                activeUsers: 'المستخدمون النشطون',
                uptime: 'وقت التشغيل',
                support: 'الدعم',
                
                // CTA Section
                ctaTitle: 'هل أنت مستعد لتحويل عملك؟',
                ctaSubtitle: 'انضم إلى آلاف الشركات التي قامت بتبسيط عملياتها مع رقيب',
                ctaButton: 'ابدأ رحلتك',
                
                // About Section
                aboutTitle: 'حول رقيب',
                aboutSubtitle: 'تمكين الشركات بحلول مبتكرة لإدارة الموارد البشرية منذ عام 2020.',
                aboutDesc: 'تأسس رقيب بمهمة بسيطة: تبسيط عمليات الأعمال وتمكين المنظمات من التركيز على ما يهم أكثر - أشخاصهم ونموهم. منصة الموارد البشرية/تخطيط موارد المؤسسة الشاملة تجمع بين التكنولوجيا المتطورة والتصميم البديهي لتقديم حلول تعمل فعلاً.',
                aboutDesc2: 'مع سنوات من الخبرة في تطوير برامج المؤسسات، يفهم فريقنا التحديات التي تواجهها الشركات في إدارة العمليات المعقدة. لهذا السبب قمنا ببناء رقيب ليكون أكثر من مجرد برنامج - إنه منصة تحول تجاري كاملة.',
                
                // About Features
                modernTech: 'أمان المؤسسة',
                modernTechDesc: 'تشفير على مستوى البنوك وبروتوكولات الأمان لحماية بيانات عملك الحساسة.',
                
                scalable: 'نهج الحوسبة السحابية',
                scalableDesc: 'اصل إلى بياناتك في أي مكان وأي وقت مع بنيتنا السحابية القوية.',
                
                secure: 'دعم خبير',
                secureDesc: 'فريق دعم مخصص لمساعدتك في تحقيق أقصى استفادة من استثمارك في رقيب.',
                
                // Contact Section
                contactTitle: 'تواصل معنا',
                contactSubtitle: 'مستعد لتحويل عمليات عملك؟',
                firstName: 'الاسم الأول',
                lastName: 'اسم العائلة',
                email: 'البريد الإلكتروني',
                subject: 'الموضوع',
                message: 'الرسالة',
                sendMessage: 'إرسال الرسالة',
                
                // Footer
                quickLinks: 'روابط سريعة',
                resources: 'الموارد',
                support: 'الدعم',
                allRightsReserved: 'جميع الحقوق محفوظة.',
                privacyPolicy: 'سياسة الخصوصية',
                termsConditions: 'الشروط والأحكام',
                documentation: 'التوثيق',
                apiReference: 'مرجع API',
                helpCenter: 'مركز المساعدة',
                technicalSupport: 'الدعم التقني'
            }
        };

        // Current language state
        let currentLanguage = localStorage.getItem('language') || 'en';
        
        // Initialize language on page load
        document.addEventListener('DOMContentLoaded', function() {
            setLanguage(currentLanguage);
        });

        // Language switching function
        function setLanguage(lang) {
            currentLanguage = lang;
            localStorage.setItem('language', lang);
            
            // Update HTML attributes
            document.documentElement.lang = lang;
            document.documentElement.dir = lang === 'ar' ? 'rtl' : 'ltr';
            
            // Update body class for font switching
            document.body.classList.toggle('arabic', lang === 'ar');
            
            // Update language switcher display
            updateLanguageSwitcher(lang);
            
            // Update all translatable elements
            updateTranslations(lang);
        }

        // Update language switcher display
        function updateLanguageSwitcher(lang) {
            const currentFlag = document.querySelector('.language-switcher .current-flag');
            const currentText = document.querySelector('.language-switcher .current-text');
            
            if (currentFlag && currentText) {
                if (lang === 'en') {
                    currentFlag.textContent = '🇺🇸';
                    currentText.textContent = 'English';
                } else {
                    currentFlag.textContent = '🇸🇦';
                    currentText.textContent = 'العربية';
                }
            }
        }

        // Update all translatable elements
        function updateTranslations(lang) {
            const t = translations[lang];
            
            // Update elements with data-translate attribute
            document.querySelectorAll('[data-translate]').forEach(element => {
                const key = element.getAttribute('data-translate');
                if (t[key]) {
                    if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                        element.placeholder = t[key];
                    } else {
                        element.textContent = t[key];
                    }
                }
            });

            // Update complex elements that need special handling
            updateComplexElements(lang);
        }

        // Update complex elements with mixed content
        function updateComplexElements(lang) {
            const t = translations[lang];
            
            // Update send message button
            const sendBtn = document.querySelector('.contact-form button[type="submit"]');
            if (sendBtn && t.sendMessage) {
                sendBtn.innerHTML = `<i class="fas fa-paper-plane me-2"></i>${t.sendMessage}`;
            }

            // Update download buttons
            const downloadBtns = document.querySelectorAll('.download-btn');
            downloadBtns.forEach(btn => {
                if (t.downloadApp) {
                    btn.innerHTML = `<i class="fab fa-apple me-2"></i>${t.downloadApp}`;
                }
            });
        }

        // Language switcher click handlers
        document.addEventListener('click', function(e) {
            if (e.target.closest('.lang-option[data-lang]')) {
                const lang = e.target.closest('.lang-option').getAttribute('data-lang');
                setLanguage(lang);
            }
        });

        // Enhanced floating social icons interactions
        document.addEventListener('DOMContentLoaded', function() {
            const socialIcons = document.querySelectorAll('.floating-social .social-icon');
            
            // Add click effect
            socialIcons.forEach(icon => {
                icon.addEventListener('click', function(e) {
                    // Create ripple effect
                    const ripple = document.createElement('span');
                    ripple.style.position = 'absolute';
                    ripple.style.borderRadius = '50%';
                    ripple.style.background = 'rgba(255, 255, 255, 0.6)';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'ripple 0.6s linear';
                    ripple.style.left = '50%';
                    ripple.style.top = '50%';
                    ripple.style.width = '20px';
                    ripple.style.height = '20px';
                    ripple.style.marginLeft = '-10px';
                    ripple.style.marginTop = '-10px';
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
                
                // Add subtle bounce on hover
                icon.addEventListener('mouseenter', function() {
                    this.style.animation = 'bounce 0.5s ease';
                });
                
                icon.addEventListener('mouseleave', function() {
                    this.style.animation = 'float 3s ease-in-out infinite';
                });
            });
        });

        // Add CSS for ripple effect
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            @keyframes bounce {
                0%, 20%, 60%, 100% {
                    transform: translateY(0);
                }
                40% {
                    transform: translateY(-10px);
                }
                80% {
                    transform: translateY(-5px);
                }
            }
        `;
        document.head.appendChild(style);
    </script>

    <!-- Floating Social Media Icons -->
    <div class="floating-social">
        <a href="https://www.facebook.com/YourCompanyPage" class="social-icon facebook" target="_blank" rel="noopener noreferrer" data-tooltip="Follow us on Facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://www.linkedin.com/company/YourCompany" class="social-icon linkedin" target="_blank" rel="noopener noreferrer" data-tooltip="Connect on LinkedIn">
            <i class="fab fa-linkedin-in"></i>
        </a>
        <a href="https://wa.me/1234567890?text=Hello!%20I'm%20interested%20in%20Raqib%20ERP%20system" class="social-icon whatsapp" target="_blank" rel="noopener noreferrer" data-tooltip="Chat on WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
</body>
</html>
