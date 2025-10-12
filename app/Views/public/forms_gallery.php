<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <div class="mb-4">
                <img src="<?= base_url('assets/SMARTELITE PACKAGE LOGOS/SMARTELITE1@2x-100.jpg') ?>" 
                     alt="SmartElite Initiative" 
                     class="img-fluid mb-3" 
                     style="max-height: 80px;">
            </div>
            <h1 class="display-5 fw-bold mb-3">Available Forms</h1>
            <p class="lead text-muted mb-4">
                Choose from our available forms to get started with your application or registration
            </p>
            <a href="<?= base_url('/') ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Back to Home
            </a>
        </div>
    </div>

    <!-- Forms Grid -->
    <?php if (empty($forms)): ?>
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-file-earmark-plus text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 text-muted">No Forms Available</h4>
                    <p class="text-muted">There are currently no active forms available. Please check back later.</p>
                    <a href="<?= base_url('/') ?>" class="btn btn-primary">
                        <i class="bi bi-house me-2"></i>Return Home
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($forms as $form): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0 form-card">
                    <div class="card-body d-flex flex-column">
                        <!-- Form Icon -->
                        <div class="text-center mb-3">
                            <div class="form-icon bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-file-earmark-text-fill text-primary" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>

                        <!-- Form Title -->
                        <h5 class="card-title text-center mb-3 fw-bold">
                            <?= esc($form['title']) ?>
                        </h5>

                        <!-- Form Description -->
                        <?php if (!empty($form['description'])): ?>
                            <p class="card-text text-muted text-center mb-4 flex-grow-1">
                                <?= esc($form['description']) ?>
                            </p>
                        <?php else: ?>
                            <p class="card-text text-muted text-center mb-4 flex-grow-1">
                                Complete this form to proceed with your application.
                            </p>
                        <?php endif; ?>

                        <!-- Form Status -->
                        <div class="text-center mb-3">
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>Active
                            </span>
                        </div>

                        <!-- Action Button -->
                        <div class="text-center">
                            <a href="<?= base_url('register/' . $form['slug']) ?>" 
                               class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-arrow-right-circle me-2"></i>Start Application
                            </a>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer bg-transparent border-0 text-center">
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>
                            Created <?= date('M j, Y', strtotime($form['created_at'])) ?>
                        </small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Call to Action Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body text-center py-5">
                    <h3 class="card-title mb-3">
                        <i class="bi bi-question-circle me-2"></i>Need Help?
                    </h3>
                    <p class="card-text mb-4">
                        If you have any questions about our forms or need assistance with your application, 
                        please don't hesitate to contact us.
                    </p>
                    <a href="<?= base_url('/') ?>#contact" class="btn btn-light btn-lg">
                        <i class="bi bi-envelope me-2"></i>Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
}

.form-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.form-icon {
    transition: transform 0.3s ease;
}

.form-card:hover .form-icon {
    transform: scale(1.1);
}

.card-title {
    color: #2c3e50;
    font-size: 1.25rem;
}

.btn-primary {
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.3);
}

.badge {
    border-radius: 20px;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .display-5 {
        font-size: 2rem;
    }
    
    .form-card {
        margin-bottom: 1.5rem;
    }
}
</style>

<?= $this->endSection() ?>
