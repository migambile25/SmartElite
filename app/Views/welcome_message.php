<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="mb-4">
                    <img src="<?= base_url('assets/SMARTELITE PACKAGE LOGOS/SMARTELITE1@2x-100.jpg') ?>" 
                         alt="SmartElite Initiative" 
                         class="img-fluid mb-3" 
                         style="max-height: 80px;">
                </div>
                <h1 class="display-4 mb-4">
                    SmartElite Initiative
                </h1>
                <p class="lead mb-4">
                    Bridging the gap between higher education and digital inclusion in Tanzania. 
                    Empowering undergraduate students with affordable access to essential digital tools, 
                    training, and support for academic success, innovation, and employability.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <?php if ($primaryForm): ?>
                        <a href="<?= base_url('register/' . $primaryForm['slug']) ?>" class="btn btn-primary btn-lg">
                            <i class="bi bi-laptop me-2"></i><?= esc($primaryForm['title']) ?>
                        </a>
                    <?php endif; ?>
                    <a href="<?= base_url('forms') ?>" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-file-earmark-text me-2"></i>View All Forms
                    </a>
                    <a href="#about" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-info-circle me-2"></i>Learn More
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-image">
                    <img src="<?= base_url('assets/SMARTELITE PACKAGE LOGOS/SMARTELITE2@2x-100.jpg') ?>" 
                         alt="SmartElite Laptop Program" 
                         class="img-fluid" 
                         style="max-height: 400px;">
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div id="about" class="row py-5">
        <div class="col-12 text-center mb-5">
            <h2 class="h1 fw-bold">About SmartElite Initiative</h2>
            <p class="lead text-muted">Empowering Tanzania's future through digital inclusion</p>
        </div>
        
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h4 class="card-title mb-4">The Challenge</h4>
                    <p class="card-text">
                        With over <strong>201,000 undergraduate students</strong> enrolled in 2023/24, only a fraction 
                        can afford personal computers, despite their necessity for learning, research, innovation, 
                        and access to online resources. The Higher Education Students' Loans Board (HESLB) supported 
                        more than <strong>76,000 loan beneficiaries</strong>, but the current loan package doesn't 
                        cover laptop costs.
                    </p>
                    
                    <h4 class="card-title mb-4 mt-5">Our Solution</h4>
                    <p class="card-text">
                        SmartElite provides students with <strong>affordable laptops at TZS 300,000</strong>, 
                        payable in two structured installments per semester directly from their allowances. 
                        Starting with a target of <strong>5,000 beneficiaries across 20 universities</strong> 
                        in 2025/26.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="row py-5">
        <div class="col-12 text-center mb-5">
            <h2 class="h1 fw-bold">What SmartElite Offers</h2>
            <p class="lead text-muted">Comprehensive empowerment platform</p>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-laptop text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="card-title">Affordable Digital Access</h4>
                    <p class="card-text text-muted">
                        Access to digital devices through affordable financing models in partnership with 
                        CRDB Bank Foundation and HESLB.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-book text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="card-title">Digital Literacy</h4>
                    <p class="card-text text-muted">
                        Equipping students with skills in research, online learning platforms, 
                        and productivity tools for academic excellence.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-lightbulb text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="card-title">Innovation & Entrepreneurship</h4>
                    <p class="card-text text-muted">
                        Enabling students to use technology for startups, projects, 
                        and problem-solving initiatives.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Partners Section -->
    <div class="partners-section">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="h1">Our Partners</h2>
                <p class="lead">Working together for Tanzania's digital future</p>
            </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-bank text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="card-title">CRDB Bank Foundation</h4>
                    <p class="card-text text-muted">
                        Financial partner providing affordable financing models for student laptop acquisition.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-mortarboard text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="card-title">HESLB</h4>
                    <p class="card-text text-muted">
                        Higher Education Students' Loans Board providing guidance and support for loan beneficiaries.
                    </p>
                </div>
            </div>
</div>

        <div class="col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-building text-info" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="card-title">Basil Link</h4>
                    <p class="card-text text-muted">
                        Leading the initiative to bridge the gap between higher education and digital inclusion.
                    </p>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section text-white">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="h1 mb-3 text-white">Ready to Apply?</h2>
                <p class="lead mb-4 text-white-50">
                    Join 5,000 students across 20 universities in Tanzania. Get your affordable laptop 
                    and unlock your academic potential.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <?php if ($primaryForm): ?>
                        <a href="<?= base_url('register/' . $primaryForm['slug']) ?>" class="btn btn-light btn-lg">
                            <i class="bi bi-laptop me-2"></i><?= esc($primaryForm['title']) ?>
                        </a>
                    <?php endif; ?>
                    <a href="#about" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-info-circle me-2"></i>Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Access -->
    <?php if (!session()->get('user_id')): ?>
    <div class="row py-4">
        <div class="col-12 text-center">
            <div class="card border-secondary">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-gear me-2"></i>Administrator Access
                    </h5>
                    <p class="card-text text-muted">
                        Manage forms and view submissions through our admin panel.
                    </p>
                    <a href="<?= base_url('admin/login') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Admin Login
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

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

.min-vh-50 {
    min-height: 50vh;
}

.hero-image {
    position: relative;
}

.feature-icon {
    transition: transform 0.3s ease;
}

.card:hover .feature-icon {
    transform: scale(1.1);
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e5e7eb;
    border-radius: 1rem;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
}

.btn-primary {
    background-color: var(--smartelite-primary);
    border-color: var(--smartelite-primary);
    font-weight: 600;
    padding: 0.75rem 2rem;
    border-radius: 0.75rem;
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
    padding: 0.75rem 2rem;
    border-radius: 0.75rem;
}

.btn-outline-primary:hover {
    background-color: var(--smartelite-primary);
    border-color: var(--smartelite-primary);
    transform: translateY(-1px);
}

.text-primary {
    color: var(--smartelite-primary) !important;
}

.bg-primary {
    background-color: var(--smartelite-primary) !important;
}

.display-4 {
    font-weight: 800;
    color: var(--smartelite-primary);
    line-height: 1.2;
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

.card-title {
    font-weight: 600;
    color: var(--smartelite-dark);
}

.card-text {
    color: var(--smartelite-gray);
    line-height: 1.6;
}

.hero-section {
    background: linear-gradient(135deg, var(--smartelite-light) 0%, #ffffff 100%);
    border-radius: 2rem;
    padding: 3rem;
    margin: 2rem 0;
}

.partners-section {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 2rem;
    padding: 3rem;
    margin: 2rem 0;
}

.cta-section {
    background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-secondary) 100%);
    border-radius: 2rem;
    padding: 4rem 3rem;
    margin: 2rem 0;
}

@media (max-width: 768px) {
    .hero-section, .partners-section, .cta-section {
        padding: 2rem 1.5rem;
        margin: 1rem 0;
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
}
</style>
<?= $this->endSection() ?>
