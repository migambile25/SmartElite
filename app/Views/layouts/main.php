<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title><?= $title ?? 'SmartElite' ?></title>
    
    <!-- Progressive Web App Meta Tags -->
    <meta name="theme-color" content="#1e3a8a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="SmartElite">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="SmartElite">
    
    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/favicon.ico') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/favicon-16x16.png') ?>">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            /* SmartElite Brand Colors - Extracted from Logo */
            --smartelite-primary: #00A652;        /* Primary Green */
            --smartelite-secondary: #40BC7D;      /* Secondary Green */
            --smartelite-accent: #00ADEF;         /* Accent Blue */
            --smartelite-mint: #93D9B5;           /* Mint Green */
            --smartelite-pale-mint: #B6E7DB;      /* Pale Mint */
            --smartelite-cyan: #56C7C8;           /* Cyan */
            
            /* Neutral Colors for Liquid Glass */
            --smartelite-white: #FFFFFF;
            --smartelite-black: #000000;
            --smartelite-dark: #1d1d1f;
            --smartelite-gray-100: #f5f5f7;
            --smartelite-gray-200: #e5e5e7;
            --smartelite-gray-300: #d2d2d7;
            --smartelite-gray-400: #a1a1a6;
            --smartelite-gray-500: #86868b;
            --smartelite-gray-600: #6e6e73;
            --smartelite-gray-700: #424245;
            --smartelite-gray-800: #1d1d1f;
            
            /* Glass Effect Colors */
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --glass-shadow: rgba(0, 0, 0, 0.1);
            --glass-blur: 20px;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Inter', 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--smartelite-gray-100) 0%, var(--smartelite-white) 50%, var(--smartelite-pale-mint) 100%);
            color: var(--smartelite-dark);
            line-height: 1.6;
            overflow-x: hidden;
            padding-top: 80px; /* Space for floating navbar */
        }
        
        /* Enhanced Liquid Glass Foundation */
        .glass-effect {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(35px);
            -webkit-backdrop-filter: blur(35px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 28px;
            box-shadow: 0 16px 64px rgba(0, 0, 0, 0.12);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .glass-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.18);
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(45px);
            -webkit-backdrop-filter: blur(45px);
        }
        
        /* Enhanced Apple-Style Floating Navigation */
        .navbar {
            position: fixed !important;
            top: 20px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            width: calc(100% - 40px) !important;
            max-width: 1200px !important;
            background: rgba(255, 255, 255, 0.15) !important;
            backdrop-filter: blur(50px) !important;
            -webkit-backdrop-filter: blur(50px) !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            border-radius: 24px !important;
            box-shadow: 0 16px 64px rgba(0, 0, 0, 0.15) !important;
            z-index: 1000 !important;
            padding: 16px 28px !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        
        .navbar:hover {
            background: rgba(255, 255, 255, 0.22) !important;
            backdrop-filter: blur(60px) !important;
            -webkit-backdrop-filter: blur(60px) !important;
            box-shadow: 0 20px 80px rgba(0, 0, 0, 0.2) !important;
            transform: translateX(-50%) translateY(-4px) !important;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: var(--smartelite-dark) !important;
            font-size: 1.25rem;
            letter-spacing: -0.02em;
            margin: 0 !important;
            display: flex;
            align-items: center;
        }
        
        .navbar-logo {
            height: 32px;
            width: auto;
            border-radius: 6px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .navbar-logo:hover {
            transform: scale(1.05);
        }
        
        /* Floating Action Buttons */
        .navbar-nav {
            margin-left: auto !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
        }
        
        .navbar-nav .nav-link {
            padding: 8px 16px !important;
            border-radius: 12px !important;
            font-weight: 500 !important;
            font-size: 0.95rem !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            border: 1px solid transparent !important;
            background: transparent !important;
            color: var(--smartelite-dark) !important;
        }
        
        .navbar-nav .nav-link:hover {
            background: rgba(0, 166, 82, 0.1) !important;
            border-color: rgba(0, 166, 82, 0.2) !important;
            transform: translateY(-1px) !important;
        }
        
        .navbar-nav .btn-primary {
            background: var(--smartelite-primary) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 8px 20px !important;
            font-weight: 500 !important;
            font-size: 0.95rem !important;
            color: white !important;
            box-shadow: 0 4px 16px rgba(0, 166, 82, 0.3) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        
        .navbar-nav .btn-primary:hover {
            background: var(--smartelite-secondary) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 24px rgba(0, 166, 82, 0.4) !important;
        }
        
        .bg-primary {
            background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-secondary) 100%) !important;
        }
        
        /* Apple-Style Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-secondary) 100%);
            border: none;
            border-radius: 12px;
            font-weight: 500;
            padding: 12px 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(0, 166, 82, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 166, 82, 0.4);
            background: linear-gradient(135deg, var(--smartelite-secondary) 0%, var(--smartelite-primary) 100%);
        }
        
        .btn-outline-primary {
            color: var(--smartelite-primary);
            border: 2px solid var(--smartelite-primary);
            background: transparent;
            border-radius: 12px;
            font-weight: 500;
            padding: 10px 22px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-outline-primary:hover {
            background: var(--smartelite-primary);
            border-color: var(--smartelite-primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 166, 82, 0.3);
        }
        
        .text-primary {
            color: var(--smartelite-primary) !important;
        }
        
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: var(--smartelite-light);
        }
        
        .sidebar .nav-link {
            color: var(--smartelite-gray);
            padding: 0.75rem 1rem;
            font-weight: 500;
        }
        
        .sidebar .nav-link:hover {
            background-color: #e2e8f0;
            color: var(--smartelite-primary);
        }
        
        .sidebar .nav-link.active {
            background-color: var(--smartelite-primary);
            color: white;
        }
        
        .main-content {
            padding: 2rem;
        }
        
        /* Apple-Style Cards with Stronger Liquid Glass */
        .card {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 24px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
        }
        
        .card:focus-within {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            box-shadow: 0 16px 50px rgba(0, 0, 0, 0.15);
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: var(--smartelite-dark);
        }
        
        .badge {
            font-size: 0.75em;
            font-weight: 500;
        }
        
        /* Enhanced Apple-Style Form Controls with Dramatic Glass Effects */
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 2px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            padding: 14px 18px;
            font-size: 16px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--smartelite-primary);
            box-shadow: 0 0 0 4px rgba(0, 166, 82, 0.3), 0 16px 64px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(50px);
            -webkit-backdrop-filter: blur(50px);
            outline: none;
            transform: translateY(-2px);
        }
        
        .alert {
            border: none;
            border-radius: 0.75rem;
        }
        
        /* Apple-Style Typography */
        .display-4 {
            font-weight: 700;
            color: var(--smartelite-dark);
            letter-spacing: -0.02em;
            line-height: 1.1;
        }
        
        .h1, .h2, .h3, .h4, .h5, .h6 {
            font-weight: 600;
            color: var(--smartelite-dark);
            letter-spacing: -0.01em;
            line-height: 1.2;
        }
        
        .lead {
            color: var(--smartelite-gray-600);
            font-weight: 400;
            font-size: 1.25rem;
            line-height: 1.5;
        }
        
        /* Apple-Style Alerts */
        .alert {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }
        
        /* Enhanced Mobile-Specific Improvements */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            
            /* Enhanced Mobile Navbar with iOS Glass Effect */
            .navbar {
                top: 15px !important;
                width: calc(100% - 30px) !important;
                padding: 12px 20px !important;
                border-radius: 20px !important;
                background: rgba(255, 255, 255, 0.12) !important;
                backdrop-filter: blur(45px) !important;
                -webkit-backdrop-filter: blur(45px) !important;
                border: 1px solid rgba(255, 255, 255, 0.2) !important;
                box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15) !important;
            }
            
            .navbar:hover {
                background: rgba(255, 255, 255, 0.18) !important;
                backdrop-filter: blur(55px) !important;
                -webkit-backdrop-filter: blur(55px) !important;
                box-shadow: 0 16px 64px rgba(0, 0, 0, 0.2) !important;
            }
            
            .navbar-brand {
                font-size: 1.2rem;
                color: var(--smartelite-dark) !important;
            }
            
            .navbar-logo {
                height: 28px;
            }
            
            .navbar-nav {
                gap: 10px !important;
            }
            
            .navbar-nav .nav-link {
                padding: 8px 14px !important;
                font-size: 0.95rem !important;
                background: rgba(255, 255, 255, 0.1) !important;
                backdrop-filter: blur(20px) !important;
                -webkit-backdrop-filter: blur(20px) !important;
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
                border-radius: 12px !important;
                color: var(--smartelite-dark) !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            
            .navbar-nav .nav-link:hover {
                background: rgba(0, 166, 82, 0.15) !important;
                border-color: rgba(0, 166, 82, 0.25) !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 4px 16px rgba(0, 166, 82, 0.2) !important;
            }
            
            .navbar-nav .btn-primary {
                padding: 8px 18px !important;
                font-size: 0.95rem !important;
                background: var(--smartelite-primary) !important;
                border: none !important;
                border-radius: 12px !important;
                box-shadow: 0 4px 16px rgba(0, 166, 82, 0.3) !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            
            .navbar-nav .btn-primary:hover {
                background: var(--smartelite-secondary) !important;
                transform: translateY(-2px) !important;
                box-shadow: 0 8px 24px rgba(0, 166, 82, 0.4) !important;
            }
            
            /* Mobile Navbar Toggle Button */
            .navbar-toggler {
                background: rgba(255, 255, 255, 0.1) !important;
                backdrop-filter: blur(20px) !important;
                -webkit-backdrop-filter: blur(20px) !important;
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
                border-radius: 12px !important;
                padding: 8px 12px !important;
            }
            
            .navbar-toggler:focus {
                box-shadow: 0 0 0 4px rgba(0, 166, 82, 0.25) !important;
            }
            
            .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2833, 37, 41, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
            }
            
            /* Mobile Navbar Collapse with Glass Effect */
            .navbar-collapse {
                background: rgba(255, 255, 255, 0.1) !important;
                backdrop-filter: blur(30px) !important;
                -webkit-backdrop-filter: blur(30px) !important;
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
                border-radius: 16px !important;
                margin-top: 10px !important;
                padding: 15px !important;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15) !important;
            }
            
            .navbar-collapse.show {
                background: rgba(255, 255, 255, 0.15) !important;
                backdrop-filter: blur(40px) !important;
                -webkit-backdrop-filter: blur(40px) !important;
            }
            
            .container-fluid {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
            
            /* Prevent horizontal scrolling */
            body {
                overflow-x: hidden;
                padding-top: 80px; /* Adjusted for enhanced navbar */
            }
            
            /* Touch-friendly button sizing */
            .btn {
                min-height: 44px;
                touch-action: manipulation;
            }
            
            /* Better form spacing on mobile */
            .form-control, .form-select {
                font-size: 16px; /* Prevents zoom on iOS */
                min-height: 44px;
            }
        }
        
        /* Very Small Mobile Screens */
        @media (max-width: 480px) {
            .navbar {
                top: 10px !important;
                width: calc(100% - 20px) !important;
                padding: 10px 16px !important;
                border-radius: 18px !important;
            }
            
            .navbar-brand {
                font-size: 1.1rem;
            }
            
            .navbar-logo {
                height: 24px;
            }
            
            .navbar-nav .nav-link {
                padding: 6px 12px !important;
                font-size: 0.9rem !important;
            }
            
            .navbar-nav .btn-primary {
                padding: 6px 14px !important;
                font-size: 0.9rem !important;
            }
            
            body {
                padding-top: 75px;
            }
        }
        
        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .btn:hover {
                transform: none; /* Disable hover effects on touch devices */
            }
            
            .card:hover {
                transform: none; /* Disable hover effects on touch devices */
            }
            
            .navbar:hover {
                transform: translateX(-50%) !important; /* Keep navbar centered on touch */
            }
        }
        
        /* Performance optimizations */
        * {
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Improved accessibility */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        
        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .mobile-form-control {
                border-width: 2px;
            }
            
            .btn {
                border-width: 2px;
            }
        }
        
    </style>
</head>
<body>
    <!-- Apple-Style Floating Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/SMARTELITE PACKAGE LOGOS/SMARTELITE1@2x-100.jpg') ?>" 
                     alt="SmartElite" 
                     class="navbar-logo me-2">
                SmartElite
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="<?= base_url('forms') ?>">
                        <i class="bi bi-file-earmark-text me-1"></i>Forms
                    </a>
                    <a class="nav-link" href="#about">
                        <i class="bi bi-info-circle me-1"></i>About
                    </a>
                    
                    <?php if (session()->get('user_id')): ?>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i><?= session()->get('username') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= base_url('admin') ?>">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= base_url('admin/logout') ?>">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="btn btn-primary" href="<?= base_url('admin/login') ?>">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Admin
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <?php if (session()->get('user_id') && isset($showSidebar) && $showSidebar): ?>
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= (current_url() == base_url('admin') || current_url() == base_url('admin/dashboard')) ? 'active' : '' ?>" 
                               href="<?= base_url('admin') ?>">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), base_url('admin/forms')) !== false ? 'active' : '' ?>" 
                               href="<?= base_url('admin/forms') ?>">
                                <i class="bi bi-file-earmark-text me-2"></i>Forms
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url() ?>" target="_blank">
                                <i class="bi bi-eye me-2"></i>View Site
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <?php endif; ?>

            <!-- Main content -->
            <main class="<?= (session()->get('user_id') && isset($showSidebar) && $showSidebar) ? 'col-md-9 ms-sm-auto col-lg-10' : 'col-12' ?> px-md-4">
                <div class="main-content">
                    <!-- Flash Messages -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('warning')): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('warning') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('info')): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="bi bi-info-circle me-2"></i><?= session()->getFlashdata('info') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Page Content -->
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Confirm delete actions
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-delete') || e.target.closest('.btn-delete')) {
                if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                    e.preventDefault();
                }
            }
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
