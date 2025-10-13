<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Apple-Style Navigation -->
<nav class="apple-nav">
    <div class="nav-container">
        <div class="nav-logo">
            <img src="<?= base_url('assets/SMARTELITE PACKAGE LOGOS/SMARTELITE1@2x-100.jpg') ?>" 
                 alt="SmartElite" 
                 class="logo-img">
        </div>
        <div class="nav-links">
            <a href="#about" class="nav-link">About</a>
            <a href="#features" class="nav-link">Features</a>
            <a href="#partners" class="nav-link">Partners</a>
        </div>
        <div class="nav-actions">
            <?php if ($primaryForm): ?>
                <a href="<?= base_url('register/' . $primaryForm['slug']) ?>" class="btn-explore">Explore</a>
                <a href="<?= base_url('register/' . $primaryForm['slug']) ?>" class="btn-buy">Buy</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container-fluid px-0">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">SmartElite Initiative</h1>
            <div class="hero-actions">
                <a href="#about" class="btn-explore">Explore</a>
                <a href="<?= base_url('register/' . $primaryForm['slug']) ?>" class="btn-buy">Apply</a>
            </div>
        </div>
        
        <div class="hero-visual">
            <div class="laptop-showcase">
                <div class="laptop-container">
                    <div class="laptop">
                        <div class="laptop-screen">
                            <div class="screen-content">
                                <div class="screen-header">
                                    <div class="screen-dots">
                                        <span></span><span></span><span></span>
                                    </div>
                                </div>
                                <div class="screen-body">
                                    <div class="app-grid">
                                        <div class="app-icon app-1"></div>
                                        <div class="app-icon app-2"></div>
                                        <div class="app-icon app-3"></div>
                                        <div class="app-icon app-4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="laptop-base"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hero-bottom">
            <a href="#features" class="btn-compare">
                Learn More About SmartElite
                <i class="bi bi-arrow-down"></i>
            </a>
        </div>
    </div>

    <!-- About Section -->
    <div id="about" class="about-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Empowering Tanzania's Digital Future</h2>
                <p class="section-description">
                    SmartElite bridges the gap between higher education and digital inclusion. 
                    We provide affordable laptop access, comprehensive training, and ongoing support 
                    for academic success and innovation.
                </p>
            </div>
            
            <div class="about-cards">
                <div class="about-card">
                    <div class="card-icon">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <h3>Affordable Access</h3>
                    <p>Laptops at TZS 300,000 with flexible payment plans through HESLB and CRDB Bank Foundation partnerships.</p>
                </div>
                
                <div class="about-card">
                    <div class="card-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3>5,000+ Students</h3>
                    <p>Targeting undergraduate students across 20 universities in Tanzania for the 2025/26 academic year.</p>
                </div>
                
                <div class="about-card">
                    <div class="card-icon">
                        <i class="bi bi-graduation-cap"></i>
                    </div>
                    <h3>Digital Literacy</h3>
                    <p>Comprehensive training in research, online learning platforms, and productivity tools for academic excellence.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="features-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">How SmartElite Works</h2>
                <p class="section-description">
                    A simple three-step process to get your laptop and start your digital learning journey.
                </p>
            </div>
            
            <div class="features-grid">
                <div class="feature-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Apply Online</h3>
                        <p>Submit your application through our secure online portal with your HESLB details and university information.</p>
                    </div>
                </div>
                
                <div class="feature-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Get Approved</h3>
                        <p>Our team reviews your application and partners with HESLB to verify your loan beneficiary status.</p>
                    </div>
                </div>
                
                <div class="feature-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Receive Your Laptop</h3>
                        <p>Pay TZS 300,000 in two installments and receive your laptop with comprehensive digital literacy training.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Partners Section -->
    <div id="partners" class="partners-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Trusted Partners</h2>
                <p class="section-description">
                    Working together with leading institutions to make digital education accessible to all Tanzanian students.
                </p>
            </div>
            
            <div class="partners-grid">
                <div class="partner-card">
                    <div class="partner-logo">
                        <i class="bi bi-bank"></i>
                    </div>
                    <h3>CRDB Bank Foundation</h3>
                    <p>Providing affordable financing solutions and secure payment processing for student laptop purchases.</p>
                </div>
                
                <div class="partner-card">
                    <div class="partner-logo">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <h3>HESLB</h3>
                    <p>Higher Education Students' Loans Board supporting loan beneficiaries with flexible payment options.</p>
                </div>
                
                <div class="partner-card">
                    <div class="partner-logo">
                        <i class="bi bi-building"></i>
                    </div>
                    <h3>Basil Link</h3>
                    <p>Leading the SmartElite initiative to bridge the gap between higher education and digital inclusion.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Get Your Laptop?</h2>
                <p class="cta-description">
                    Join thousands of students across Tanzania. Apply now for the SmartElite program 
                    and get your laptop at an affordable price with flexible payment options.
                </p>
                
                <div class="cta-stats">
                    <div class="stat-item">
                        <div class="stat-number">5,000+</div>
                        <div class="stat-label">Students</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">20</div>
                        <div class="stat-label">Universities</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">TZS 300K</div>
                        <div class="stat-label">Affordable Price</div>
                    </div>
                </div>
                
                <div class="cta-actions">
                    <?php if ($primaryForm): ?>
                        <a href="<?= base_url('register/' . $primaryForm['slug']) ?>" class="btn-apply">
                            Apply Now
                        </a>
                    <?php endif; ?>
                    <a href="#about" class="btn-learn">
                        Learn More
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
    /* SmartElite Logo Color Palette */
    --smartelite-primary: #00A652;        /* Dark Green */
    --smartelite-secondary: #40BC7D;      /* Medium Green */
    --smartelite-accent: #00ADEF;         /* Bright Blue */
    --smartelite-light-blue: #56C7C8;     /* Cyan */
    --smartelite-mint: #93D9B5;           /* Mint Green */
    --smartelite-pale-mint: #B6E7DB;      /* Pale Mint */
    --smartelite-white: #FFFFFF;          /* White */
    
    /* Additional colors for UI */
    --smartelite-dark: #002010;           /* Dark from logo */
    --smartelite-light: #f8fafc;
    --smartelite-gray: #6b7280;
    --smartelite-warning: #f59e0b;
    --smartelite-danger: #ef4444;
}

/* ===== GLOBAL STYLES ===== */
* {
    scroll-behavior: smooth;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', Roboto, sans-serif;
    line-height: 1.6;
    color: #1d1d1f;
    background: #000000;
    overflow-x: hidden;
    margin: 0;
    padding: 0;
}

/* ===== APPLE-STYLE NAVIGATION ===== */
.apple-nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 1rem 0;
}

.nav-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
}

.nav-logo .logo-img {
    height: 32px;
    width: auto;
    filter: brightness(0) invert(1);
}

.nav-links {
    display: flex;
    gap: 2.5rem;
}

.nav-link {
    color: #ffffff;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 400;
    transition: opacity 0.3s ease;
}

.nav-link:hover {
    opacity: 0.7;
}

.nav-actions {
    display: flex;
    gap: 1rem;
}

.btn-explore {
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 400;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-explore:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
}

.btn-buy {
    background: #007AFF;
    color: #ffffff;
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 400;
    transition: all 0.3s ease;
}

.btn-buy:hover {
    background: #0056CC;
    color: #ffffff;
}

/* ===== HERO SECTION ===== */
.hero-section {
    min-height: 100vh;
    background: #000000;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 8rem 2rem 4rem;
    position: relative;
}

.hero-content {
    margin-bottom: 4rem;
}

.hero-title {
    font-size: 4.5rem;
    font-weight: 600;
    color: #ffffff;
    line-height: 1.1;
    margin-bottom: 2rem;
    letter-spacing: -0.02em;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    align-items: center;
}

/* ===== LAPTOP SHOWCASE ===== */
.hero-visual {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    max-width: 800px;
}

.laptop-showcase {
    position: relative;
    display: inline-block;
}

.laptop-container {
    position: relative;
    transform: perspective(1000px) rotateY(-5deg) rotateX(2deg);
    transition: transform 0.6s ease;
}

.laptop-container:hover {
    transform: perspective(1000px) rotateY(-2deg) rotateX(1deg);
}

.laptop {
    width: 500px;
    height: 320px;
    background: #2c2c2e;
    border-radius: 20px 20px 8px 8px;
    position: relative;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.laptop-screen {
    width: 100%;
    height: 90%;
    background: #000;
    border-radius: 16px 16px 0 0;
    position: relative;
    overflow: hidden;
}

.screen-content {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
    position: relative;
}

.screen-header {
    height: 40px;
    background: rgba(255, 255, 255, 0.05);
    display: flex;
    align-items: center;
    padding: 0 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.screen-dots {
    display: flex;
    gap: 8px;
}

.screen-dots span {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
}

.screen-body {
    padding: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.app-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.app-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    transition: transform 0.3s ease;
}

.app-1 {
    background: linear-gradient(135deg, #ff6b6b, #ee5a24);
}

.app-2 {
    background: linear-gradient(135deg, #4ecdc4, #44a08d);
}

.app-3 {
    background: linear-gradient(135deg, #45b7d1, #96c93d);
}

.app-4 {
    background: linear-gradient(135deg, #f093fb, #f5576c);
}

.laptop-base {
    width: 100%;
    height: 10%;
    background: #2c2c2e;
    border-radius: 0 0 8px 8px;
    position: relative;
}

.laptop-base::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: #1a1a1a;
    border-radius: 0 0 4px 4px;
}

.hero-bottom {
    margin-top: 4rem;
}

.btn-compare {
    color: #007AFF;
    text-decoration: none;
    font-size: 1rem;
    font-weight: 400;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: opacity 0.3s ease;
}

.btn-compare:hover {
    opacity: 0.7;
    color: #007AFF;
}

.btn-compare i {
    font-size: 1.2rem;
}

/* ===== SECTIONS ===== */
.about-section {
    padding: 8rem 0;
    background: #f8fafc;
}

.features-section {
    padding: 8rem 0;
    background: #ffffff;
}

.partners-section {
    padding: 8rem 0;
    background: #f8fafc;
}

.cta-section {
    padding: 8rem 0;
    background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-accent) 100%);
    color: #ffffff;
}

.section-header {
    text-align: center;
    margin-bottom: 4rem;
}

.section-title {
    font-size: 3rem;
    font-weight: 600;
    color: #1d1d1f;
    margin-bottom: 1.5rem;
    letter-spacing: -0.02em;
}

.section-description {
    font-size: 1.25rem;
    color: #86868b;
    line-height: 1.6;
    max-width: 700px;
    margin: 0 auto;
    font-weight: 400;
}

.cta-section .section-title,
.cta-section .section-description {
    color: #ffffff;
}

/* ===== ABOUT CARDS ===== */
.about-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.about-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 2.5rem 2rem;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 166, 82, 0.1);
    transition: all 0.3s ease;
}

.about-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 166, 82, 0.15);
}

.about-card .card-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-secondary) 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #ffffff;
    margin: 0 auto 1.5rem;
}

.about-card h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1d1d1f;
    margin-bottom: 1rem;
}

.about-card p {
    color: #86868b;
    line-height: 1.6;
    margin-bottom: 0;
}

/* ===== FEATURES GRID ===== */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 3rem;
    margin-top: 3rem;
}

.feature-step {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    background: #ffffff;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 166, 82, 0.1);
    transition: all 0.3s ease;
}

.feature-step:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 166, 82, 0.15);
}

.step-number {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-secondary) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 600;
    color: #ffffff;
    flex-shrink: 0;
}

.step-content h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1d1d1f;
    margin-bottom: 0.75rem;
}

.step-content p {
    color: #86868b;
    line-height: 1.6;
    margin-bottom: 0;
}

/* ===== PARTNERS GRID ===== */
.partners-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.partner-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 2.5rem 2rem;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 166, 82, 0.1);
    transition: all 0.3s ease;
}

.partner-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 166, 82, 0.15);
}

.partner-logo {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-secondary) 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #ffffff;
    margin: 0 auto 1.5rem;
}

.partner-card h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1d1d1f;
    margin-bottom: 1rem;
}

.partner-card p {
    color: #86868b;
    line-height: 1.6;
    margin-bottom: 0;
}

/* ===== CTA SECTION ===== */
.cta-content {
    text-align: center;
}

.cta-title {
    font-size: 3rem;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 1.5rem;
    letter-spacing: -0.02em;
}

.cta-description {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
    max-width: 700px;
    margin: 0 auto 3rem;
    font-weight: 400;
}

.cta-stats {
    display: flex;
    justify-content: center;
    gap: 4rem;
    margin-bottom: 3rem;
}

.cta-stats .stat-item {
    text-align: center;
}

.cta-stats .stat-number {
    font-size: 2.5rem;
    font-weight: 600;
    color: #ffffff;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.cta-stats .stat-label {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 400;
}

.cta-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-apply {
    background: #ffffff;
    color: var(--smartelite-primary);
    padding: 1rem 2.5rem;
    border-radius: 16px;
    text-decoration: none;
    font-weight: 500;
    font-size: 1.125rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
}

.btn-apply:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
    color: var(--smartelite-primary);
}

.btn-learn {
    background: transparent;
    color: #ffffff;
    padding: 1rem 2.5rem;
    border: 2px solid #ffffff;
    border-radius: 16px;
    text-decoration: none;
    font-weight: 500;
    font-size: 1.125rem;
    transition: all 0.3s ease;
}

.btn-learn:hover {
    background: #ffffff;
    color: var(--smartelite-primary);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
}

/* ===== FEATURES SECTION ===== */
.features-section {
    padding: 8rem 0;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
}

.feature-card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 3rem 2.5rem;
    text-align: center;
    height: 100%;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0, 166, 82, 0.02) 0%, rgba(0, 173, 239, 0.02) 100%);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.feature-card:hover::before {
    opacity: 1;
}

.feature-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    border-color: rgba(0, 166, 82, 0.2);
}

.card-content {
    position: relative;
    z-index: 2;
}

.feature-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-secondary) 100%);
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #ffffff;
    margin: 0 auto 2rem;
    transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    position: relative;
    overflow: hidden;
}

.feature-icon::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, transparent 50%);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.feature-card:hover .feature-icon::before {
    transform: translateX(100%);
}

.feature-card:hover .feature-icon {
    transform: scale(1.1) rotate(5deg);
}

.feature-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #1d1d1f;
    margin-bottom: 1rem;
    letter-spacing: -0.02em;
}

.feature-description {
    color: #86868b;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-size: 1.125rem;
}

.feature-highlight {
    display: inline-block;
}

.highlight-text {
    background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-accent) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* ===== ABOUT SECTION ===== */
.about-section {
    padding: 8rem 0;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    position: relative;
}

.about-content {
    padding-right: 2rem;
}

.section-badge {
    display: inline-block;
    margin-bottom: 1.5rem;
}

.section-description {
    font-size: 1.25rem;
    color: #86868b;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.about-stats {
    display: flex;
    gap: 2rem;
    margin-top: 2rem;
}

.about-stats .stat-item {
    text-align: center;
}

.about-stats .stat-number {
    font-size: 2rem;
    font-weight: 600;
    color: var(--smartelite-primary);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.about-stats .stat-label {
    font-size: 0.875rem;
    color: #86868b;
    font-weight: 500;
}

.about-visual {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 500px;
}

.about-cards {
    position: relative;
    width: 100%;
    max-width: 400px;
}

.about-card {
    position: absolute;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.4s ease;
}

.about-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.about-card .card-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-secondary) 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #ffffff;
    margin-bottom: 1rem;
}

.about-card h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1d1d1f;
    margin-bottom: 0.75rem;
}

.about-card p {
    color: #86868b;
    line-height: 1.5;
    margin-bottom: 0;
}

.about-card.card-1 {
    top: 0;
    left: 0;
    z-index: 3;
}

.about-card.card-2 {
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    z-index: 2;
}

.about-card.card-3 {
    bottom: 0;
    left: 20%;
    z-index: 1;
}

/* ===== PARTNERS SECTION ===== */
.partners-section {
    padding: 8rem 0;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
}

.partner-card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 3rem 2.5rem;
    text-align: center;
    height: 100%;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
}

.partner-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0, 166, 82, 0.02) 0%, rgba(0, 173, 239, 0.02) 100%);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.partner-card:hover::before {
    opacity: 1;
}

.partner-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    border-color: rgba(0, 166, 82, 0.2);
}

.partner-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-secondary) 100%);
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #ffffff;
    margin: 0 auto 2rem;
    transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    position: relative;
    overflow: hidden;
}

.partner-icon::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, transparent 50%);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.partner-card:hover .partner-icon::before {
    transform: translateX(100%);
}

.partner-card:hover .partner-icon {
    transform: scale(1.1) rotate(5deg);
}

.partner-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #1d1d1f;
    margin-bottom: 1rem;
    letter-spacing: -0.02em;
}

.partner-description {
    color: #86868b;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-size: 1.125rem;
}

.partner-highlight {
    display: inline-block;
}

/* ===== CTA SECTION ===== */
.cta-section {
    background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-accent) 100%);
    padding: 8rem 0;
    color: #ffffff;
    position: relative;
    overflow: hidden;
}

.cta-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
}

.cta-gradient-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(120px);
    opacity: 0.2;
    animation: float 25s ease-in-out infinite;
}

.cta-gradient-orb.orb-1 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
    top: -250px;
    right: -250px;
    animation-delay: 0s;
}

.cta-gradient-orb.orb-2 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
    bottom: -200px;
    left: -200px;
    animation-delay: 12s;
}

.cta-particles {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="80" cy="80" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.1"/></svg>');
    animation: float 30s linear infinite;
}

.cta-content {
    position: relative;
    z-index: 2;
}

.cta-badge {
    display: inline-block;
    margin-bottom: 2rem;
}

.cta-badge .badge-text {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
    border-color: rgba(255, 255, 255, 0.2);
}

.cta-title {
    font-size: 3.5rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    letter-spacing: -0.03em;
}

.cta-title .title-line {
    display: block;
}

.cta-title .title-highlight {
    background: linear-gradient(135deg, #ffffff 0%, rgba(255, 255, 255, 0.8) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: block;
}

.cta-description {
    font-size: 1.375rem;
    margin-bottom: 3rem;
    opacity: 0.9;
    max-width: 650px;
    margin-left: auto;
    margin-right: auto;
    font-weight: 400;
}

.cta-stats {
    display: flex;
    justify-content: center;
    gap: 5rem;
    margin-bottom: 3rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #ffffff;
}

.stat-content {
    text-align: left;
}

.stat-number {
    font-size: 2rem;
    font-weight: 600;
    line-height: 1;
    margin-bottom: 0.25rem;
    letter-spacing: -0.02em;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.8;
    font-weight: 400;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.cta-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 3rem;
}

.cta-guarantee {
    display: flex;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;
}

.guarantee-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    opacity: 0.8;
}

.guarantee-item i {
    font-size: 1rem;
}

/* ===== BUTTONS ===== */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 1rem 2.5rem;
    border-radius: 16px;
    font-weight: 500;
    font-size: 1.125rem;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    border: none;
    cursor: pointer;
    letter-spacing: -0.01em;
    position: relative;
    overflow: hidden;
}

.btn-lg {
    padding: 1.25rem 3rem;
    font-size: 1.25rem;
}

.btn-content {
    position: relative;
    z-index: 2;
}

.btn-primary {
    background: var(--smartelite-primary);
    color: #ffffff;
    box-shadow: 0 8px 25px rgba(0, 166, 82, 0.3);
}

.btn-primary:hover {
    background: var(--smartelite-secondary);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0, 166, 82, 0.4);
    color: #ffffff;
}

.btn-outline {
    background: transparent;
    color: var(--smartelite-primary);
    border: 2px solid var(--smartelite-primary);
}

.btn-outline:hover {
    background: var(--smartelite-primary);
    color: #ffffff;
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0, 166, 82, 0.3);
}

.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.6s ease;
}

.btn-primary:hover .btn-shine {
    left: 100%;
}

.btn-cta-primary {
    background: #ffffff;
    color: var(--smartelite-primary);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
}

.btn-cta-primary:hover {
    background: rgba(255, 255, 255, 0.9);
    color: var(--smartelite-primary);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(255, 255, 255, 0.4);
}

.btn-cta-outline {
    color: #ffffff;
    border: 2px solid #ffffff;
    background: transparent;
}

.btn-cta-outline:hover {
    background: #ffffff;
    color: var(--smartelite-primary);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(255, 255, 255, 0.3);
}

/* ===== ANIMATIONS ===== */
@keyframes float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
    }
    33% {
        transform: translateY(-10px) rotate(1deg);
    }
    66% {
        transform: translateY(5px) rotate(-1deg);
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 0.3;
        transform: translate(-50%, -50%) scale(1);
    }
    50% {
        opacity: 0.6;
        transform: translate(-50%, -50%) scale(1.1);
    }
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1200px) {
    .hero-title {
        font-size: 3.5rem;
    }
    
    .cta-title {
        font-size: 3rem;
    }
    
    .cta-stats {
        gap: 3rem;
    }
}

@media (max-width: 992px) {
    .hero-section {
        padding: 6rem 0;
    }
    
    .hero-title {
        font-size: 3rem;
    }
    
    .laptop {
        width: 400px;
        height: 250px;
    }
    
    .cta-stats {
        flex-direction: column;
        gap: 1.5rem;
        align-items: center;
    }
    
    .stat-item {
        width: 100%;
        max-width: 300px;
    }
    
    .cta-guarantee {
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .apple-nav {
        padding: 0.75rem 0;
    }
    
    .nav-container {
        padding: 0 1rem;
    }
    
    .nav-links {
        gap: 1.5rem;
    }
    
    .nav-link {
        font-size: 0.85rem;
    }
    
    .hero-section, .features-section, .partners-section, .cta-section, .about-section {
        padding: 4rem 0;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .section-title {
        font-size: 2.5rem;
    }
    
    .cta-title {
        font-size: 2.5rem;
    }
    
    .laptop {
        width: 350px;
        height: 220px;
    }
    
    .about-cards,
    .features-grid,
    .partners-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .feature-step {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .cta-stats {
        flex-direction: column;
        gap: 2rem;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-apply,
    .btn-learn {
        width: 100%;
        max-width: 300px;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-logo {
        max-height: 80px;
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
    
    .cta-stats {
        gap: 1rem;
    }
    
    .stat-item {
        padding: 1rem 1.5rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
    
    .laptop {
        width: 300px;
        height: 190px;
    }
    
    .cta-guarantee {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
<?= $this->endSection() ?>
