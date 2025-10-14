<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

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

.success-container {
    min-height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.success-card {
    border-radius: 2rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    background: linear-gradient(135deg, var(--smartelite-light) 0%, #ffffff 100%);
}

.success-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--smartelite-success) 0%, #34d399 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    animation: successPulse 2s ease-in-out infinite;
}

@keyframes successPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.btn-primary {
    background-color: var(--smartelite-primary);
    border-color: var(--smartelite-primary);
    font-weight: 600;
    border-radius: 0.75rem;
    padding: 0.75rem 2rem;
}

.btn-primary:hover {
    background-color: var(--smartelite-secondary);
    border-color: var(--smartelite-secondary);
    transform: translateY(-1px);
}

.btn-outline-primary {
    color: var(--smartelite-primary);
    border-color: var(--smartelite-primary);
    font-weight: 600;
    border-radius: 0.75rem;
    padding: 0.75rem 2rem;
}

.btn-outline-primary:hover {
    background-color: var(--smartelite-primary);
    border-color: var(--smartelite-primary);
    transform: translateY(-1px);
}

.text-primary {
    color: var(--smartelite-primary) !important;
}

.h1, .h2, .h3, .h4, .h5, .h6 {
    font-weight: 700;
    color: var(--smartelite-dark);
}

.lead {
    color: var(--smartelite-gray);
    font-weight: 400;
    font-size: 1.25rem;
    line-height: 1.6;
}
</style>

<div class="success-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-card">
                    <div class="card-body text-center p-5">
                        <div class="success-icon">
                            <i class="bi bi-check-lg text-white" style="font-size: 2.5rem;"></i>
                        </div>
                        
                        <h1 class="h2 mb-3 text-primary">
                            Application Submitted Successfully!
                        </h1>
                        
                        <p class="lead mb-4">
                            Thank you for your <?= esc($form['title']) ?> submission. We have received your application and our team will review it carefully.
                        </p>
                        
                        <?php if (isset($form) && $form['success_message']): ?>
                        <div class="alert alert-success border-0" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                            <i class="bi bi-info-circle me-2"></i>
                            <?= esc($form['success_message']) ?>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-success border-0" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                            <i class="bi bi-info-circle me-2"></i>
                            We will contact you within 5-7 business days with further instructions regarding your application.
                        </div>
                        <?php endif; ?>
                        
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <div class="card border-0" style="background: rgba(30, 58, 138, 0.05);">
                                    <div class="card-body p-3">
                                        <i class="bi bi-clock text-primary me-2"></i>
                                        <strong>Processing Time</strong>
                                        <p class="small mb-0 text-muted">5-7 business days</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-0" style="background: rgba(30, 58, 138, 0.05);">
                                    <div class="card-body p-3">
                                        <i class="bi bi-envelope text-primary me-2"></i>
                                        <strong>Next Steps</strong>
                                        <p class="small mb-0 text-muted">Email notification</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                            <a href="<?= base_url('/') ?>" class="btn btn-primary">
                                <i class="bi bi-house me-2"></i>Return to Homepage
                            </a>
                            <?php if (isset($formsCount) && $formsCount > 1): ?>
                                <a href="<?= base_url('forms') ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-file-earmark-text me-2"></i>View Other Forms
                                </a>
                            <?php endif; ?>
                            <a href="<?= base_url('register/' . $form['slug']) ?>" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-clockwise me-2"></i>Submit Another Application
                            </a>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="row text-center">
                            <div class="col-md-4">
                                <h6 class="text-primary">Need Help?</h6>
                                <p class="small text-muted">
                                    Contact our support team if you have any questions about your application.
                                </p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-primary">Stay Updated</h6>
                                <p class="small text-muted">
                                    Follow us for the latest updates on the SmartElite Initiative.
                                </p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-primary">Share the Program</h6>
                                <p class="small text-muted">
                                    Help other students learn about this opportunity.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Add some interactive elements
document.addEventListener('DOMContentLoaded', function() {
    // Add a subtle animation to the success message
    const successCard = document.querySelector('.success-card');
    successCard.style.opacity = '0';
    successCard.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        successCard.style.transition = 'all 0.6s ease';
        successCard.style.opacity = '1';
        successCard.style.transform = 'translateY(0)';
    }, 100);
});
</script>
<?= $this->endSection() ?>
