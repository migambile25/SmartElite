<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SmartElite' ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --smartelite-primary: #1e3a8a;
            --smartelite-secondary: #3b82f6;
            --smartelite-accent: #06b6d4;
            --smartelite-success: #10b981;
            --smartelite-warning: #f59e0b;
            --smartelite-danger: #ef4444;
            --smartelite-dark: #1f2937;
            --smartelite-light: #f8fafc;
            --smartelite-gray: #6b7280;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--smartelite-primary) !important;
            font-size: 1.5rem;
        }
        
        .bg-primary {
            background-color: var(--smartelite-primary) !important;
        }
        
        .btn-primary {
            background-color: var(--smartelite-primary);
            border-color: var(--smartelite-primary);
        }
        
        .btn-primary:hover {
            background-color: var(--smartelite-secondary);
            border-color: var(--smartelite-secondary);
        }
        
        .btn-outline-primary {
            color: var(--smartelite-primary);
            border-color: var(--smartelite-primary);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--smartelite-primary);
            border-color: var(--smartelite-primary);
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
        
        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
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
        
        .form-control:focus {
            border-color: var(--smartelite-primary);
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
        }
        
        .alert {
            border: none;
            border-radius: 0.75rem;
        }
        
        .display-4 {
            font-weight: 700;
            color: var(--smartelite-primary);
        }
        
        .h1, .h2, .h3, .h4, .h5, .h6 {
            font-weight: 600;
            color: var(--smartelite-dark);
        }
        
        .lead {
            color: var(--smartelite-gray);
            font-weight: 400;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="bi bi-lightning-charge-fill me-2"></i>SmartElite
            </a>
            
            <?php if (session()->get('user_id')): ?>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
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
            </div>
            <?php endif; ?>
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
