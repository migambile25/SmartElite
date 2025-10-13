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

.card {
    border-radius: 1.5rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.btn-primary {
    background-color: var(--smartelite-primary);
    border-color: var(--smartelite-primary);
    font-weight: 600;
    border-radius: 0.75rem;
}

.btn-primary:hover {
    background-color: var(--smartelite-secondary);
    border-color: var(--smartelite-secondary);
    transform: translateY(-1px);
}

.form-control:focus {
    border-color: var(--smartelite-primary);
    box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
}

.text-primary {
    color: var(--smartelite-primary) !important;
}

.alert {
    border-radius: 1rem;
    border: none;
}

.input-group-text {
    background-color: var(--smartelite-light);
    border-color: #e5e7eb;
    color: var(--smartelite-gray);
}
</style>
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-lightning-charge-fill text-primary" style="font-size: 3rem;"></i>
                    <h2 class="mt-3 mb-1">SmartElite</h2>
                    <p class="text-muted">Admin Login</p>
                </div>

                <?php if ($validation->hasError('username') || $validation->hasError('password')): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Please check your credentials and try again.
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= base_url('admin/login') ?>">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Username or Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" 
                                   class="form-control <?= $validation->hasError('username') ? 'is-invalid' : '' ?>" 
                                   id="username" 
                                   name="username" 
                                   value="<?= old('username') ?>"
                                   placeholder="Enter username or email"
                                   required>
                            <?php if ($validation->hasError('username')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('username') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" 
                                   class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter password"
                                   required>
                            <?php if ($validation->hasError('password')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        <i class="bi bi-shield-check me-1"></i>
                        Secure admin access
                    </small>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="text-muted">
                <small>
                    Default credentials: <strong>Contact System Admin</strong><br>
                    <em>Please change the default password after first login!</em>
                </small>
            </p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
