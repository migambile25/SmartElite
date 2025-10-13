<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-3 px-md-4">
    <!-- Mobile-Optimized Breadcrumb Navigation -->
    <div class="row mb-3 mb-md-4">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mobile-breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/') ?>" class="text-decoration-none">
                            <i class="bi bi-house me-1"></i><span class="d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('forms') ?>" class="text-decoration-none">
                            <i class="bi bi-file-earmark-text me-1"></i><span class="d-none d-sm-inline">Forms</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <span class="d-none d-md-inline"><?= esc($form['title']) ?></span>
                        <span class="d-md-none">Form</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7">
            <div class="card glass-card mobile-form-card">
                <div class="card-header glass-effect text-center py-3 py-md-4" style="background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-secondary) 100%); color: white;">
                    <h1 class="h3 h2-md mb-2 mobile-form-title">
                        <i class="bi bi-lightning-charge-fill me-2"></i><?= esc($form['title']) ?>
                    </h1>
                    <?php if (!empty($form['description'])): ?>
                        <p class="mb-0 opacity-75 mobile-form-description"><?= esc($form['description']) ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="card-body p-3 p-md-5">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger text-center">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $err): ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success text-center">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php else: ?>
                        <form method="POST" action="<?= base_url('register/' . $form['slug']) ?>" novalidate id="mobileForm" class="mobile-optimized-form">
                            <?= csrf_field() ?>
                            
                            <!-- Progress Indicator -->
                            <div class="mobile-progress-container mb-4">
                                <div class="mobile-progress-bar">
                                    <div class="mobile-progress-fill" id="progressFill"></div>
                                </div>
                                <small class="text-muted mobile-progress-text" id="progressText">Step 1 of 1</small>
                            </div>
                            
                            <?php foreach ($form['fields'] as $field): ?>
                                <div class="mb-3 mb-md-4 mobile-form-field">
                                    <label for="<?= esc($field['field_name']) ?>" class="form-label mobile-form-label">
                                        <?= esc($field['field_label']) ?>
                                        <?php if ($field['is_required']): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    
                                    <?php
                                    $fieldValue = old($field['field_name']);
                                    $fieldOptions = !empty($field['field_options']) ? json_decode($field['field_options'], true) : [];
                                    $hasError = $validation->hasError($field['field_name']);
                                    $errorClass = $hasError ? 'is-invalid' : '';
                                    ?>
                                    
                                    <?php switch ($field['field_type']): 
                                        case 'text': ?>
                                            <input type="text" 
                                                   class="form-control mobile-form-control <?= $errorClass ?>" 
                                                   id="<?= esc($field['field_name']) ?>" 
                                                   name="<?= esc($field['field_name']) ?>" 
                                                   value="<?= esc($fieldValue) ?>"
                                                   autocomplete="off"
                                                   <?= $field['is_required'] ? 'required' : '' ?>>
                                            <?php break; ?>
                                            
                                        <?php case 'email': ?>
                                            <input type="email" 
                                                   class="form-control mobile-form-control <?= $errorClass ?>" 
                                                   id="<?= esc($field['field_name']) ?>" 
                                                   name="<?= esc($field['field_name']) ?>" 
                                                   value="<?= esc($fieldValue) ?>"
                                                   autocomplete="email"
                                                   inputmode="email"
                                                   <?= $field['is_required'] ? 'required' : '' ?>>
                                            <?php break; ?>
                                            
                                        <?php case 'tel': ?>
                                            <input type="tel" 
                                                   class="form-control mobile-form-control <?= $errorClass ?>" 
                                                   id="<?= esc($field['field_name']) ?>" 
                                                   name="<?= esc($field['field_name']) ?>" 
                                                   value="<?= esc($fieldValue) ?>"
                                                   autocomplete="tel"
                                                   inputmode="tel"
                                                   <?= $field['is_required'] ? 'required' : '' ?>>
                                            <?php break; ?>
                                            
                                        <?php case 'number': ?>
                                            <input type="number" 
                                                   class="form-control mobile-form-control <?= $errorClass ?>" 
                                                   id="<?= esc($field['field_name']) ?>" 
                                                   name="<?= esc($field['field_name']) ?>" 
                                                   value="<?= esc($fieldValue) ?>"
                                                   autocomplete="off"
                                                   <?= $field['is_required'] ? 'required' : '' ?>>
                                            <?php break; ?>
                                            
                                        <?php case 'date': ?>
                                            <input type="date" 
                                                   class="form-control mobile-form-control <?= $errorClass ?>" 
                                                   id="<?= esc($field['field_name']) ?>" 
                                                   name="<?= esc($field['field_name']) ?>" 
                                                   value="<?= esc($fieldValue) ?>"
                                                   autocomplete="off"
                                                   <?= $field['is_required'] ? 'required' : '' ?>>
                                            <?php break; ?>
                                            
                                        <?php case 'textarea': ?>
                                            <textarea class="form-control mobile-form-control <?= $errorClass ?>" 
                                                      id="<?= esc($field['field_name']) ?>" 
                                                      name="<?= esc($field['field_name']) ?>" 
                                                      rows="3"
                                                      autocomplete="off"
                                                      <?= $field['is_required'] ? 'required' : '' ?>><?= esc($fieldValue) ?></textarea>
                                            <?php break; ?>
                                            
                                        <?php case 'select': ?>
                                            <select class="form-select mobile-form-control <?= $errorClass ?>" 
                                                    id="<?= esc($field['field_name']) ?>" 
                                                    name="<?= esc($field['field_name']) ?>"
                                                    <?= $field['is_required'] ? 'required' : '' ?>>
                                                <option value="">Choose an option...</option>
                                                <?php foreach ($fieldOptions as $option): ?>
                                                    <option value="<?= esc($option) ?>" 
                                                            <?= $fieldValue === $option ? 'selected' : '' ?>>
                                                        <?= esc($option) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php break; ?>
                                            
                                        <?php case 'radio': ?>
                                            <div class="form-check-group">
                                                <?php foreach ($fieldOptions as $index => $option): ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" 
                                                               type="radio" 
                                                               id="<?= esc($field['field_name'] . '_' . $index) ?>" 
                                                               name="<?= esc($field['field_name']) ?>" 
                                                               value="<?= esc($option) ?>"
                                                               <?= $fieldValue === $option ? 'checked' : '' ?>
                                                               <?= $field['is_required'] ? 'required' : '' ?>>
                                                        <label class="form-check-label" for="<?= esc($field['field_name'] . '_' . $index) ?>">
                                                            <?= esc($option) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php break; ?>
                                            
                                        <?php case 'checkbox': ?>
                                            <div class="form-check-group">
                                                <?php 
                                                $checkboxValues = is_array($fieldValue) ? $fieldValue : [];
                                                foreach ($fieldOptions as $index => $option): ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               id="<?= esc($field['field_name'] . '_' . $index) ?>" 
                                                               name="<?= esc($field['field_name']) ?>[]" 
                                                               value="<?= esc($option) ?>"
                                                               <?= in_array($option, $checkboxValues) ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="<?= esc($field['field_name'] . '_' . $index) ?>">
                                                            <?= esc($option) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php break; ?>
                                            
                                        <?php case 'file': ?>
                                            <input type="file" 
                                                   class="form-control mobile-form-control <?= $errorClass ?>" 
                                                   id="<?= esc($field['field_name']) ?>" 
                                                   name="<?= esc($field['field_name']) ?>"
                                                   accept="image/*,.pdf,.doc,.docx"
                                                   <?= $field['is_required'] ? 'required' : '' ?>>
                                            <?php break; ?>
                                    <?php endswitch; ?>
                                    
                                    <?php if ($hasError): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError($field['field_name']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                            
                            <div class="d-grid gap-2 mobile-form-actions">
                                <button type="submit" class="btn btn-primary btn-lg mobile-submit-btn" id="submitBtn">
                                    <span class="btn-content">
                                        <i class="bi bi-send me-2"></i>Submit Registration
                                    </span>
                                    <span class="btn-loading d-none">
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Submitting...
                                    </span>
                                </button>
                                <a href="<?= base_url('forms') ?>" class="btn btn-outline-secondary mobile-back-btn">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Forms
                                </a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
                
                <div class="card-footer text-center text-muted py-3">
                    <small>
                        <i class="bi bi-shield-check me-1"></i>
                        Your information is secure and will only be used for registration purposes.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Form Specific Styles - Inherits brand colors from main layout */

.form-check-group .form-check {
    margin-bottom: 0.5rem;
}

.form-check-group .form-check:last-child {
    margin-bottom: 0;
}

/* Form card inherits glass-card from main layout */

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 0.75rem;
}

/* Button styles inherit from main layout */

.alert {
    border-radius: 1rem;
    border: none;
}

/* Form control styles inherit from main layout */

.text-danger {
    color: var(--smartelite-danger) !important;
}

.card-footer {
    background-color: var(--smartelite-light);
    border-top: 1px solid #e5e7eb;
    border-radius: 0 0 1.5rem 1.5rem !important;
}

/* Mobile-First Responsive Design */
@media (max-width: 768px) {
    .mobile-form-card {
        margin: 0.5rem;
        border-radius: 1rem;
    }
    
    .mobile-form-title {
        font-size: 1.5rem;
        line-height: 1.3;
    }
    
    .mobile-form-description {
        font-size: 0.9rem;
        line-height: 1.4;
    }
    
    .mobile-form-label {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .mobile-form-control {
        font-size: 16px; /* Prevents zoom on iOS */
        padding: 0.75rem;
        border-radius: 16px;
        min-height: 52px; /* Touch-friendly minimum height */
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(35px);
        -webkit-backdrop-filter: blur(35px);
        border: 2px solid rgba(255, 255, 255, 0.15);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    }
    
    .mobile-form-control:focus {
        border-color: var(--smartelite-primary);
        box-shadow: 0 0 0 4px rgba(0, 166, 82, 0.3), 0 16px 64px rgba(0, 0, 0, 0.2);
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(55px);
        -webkit-backdrop-filter: blur(55px);
        outline: none;
        transform: translateY(-2px);
    }
    
    .mobile-form-control.is-invalid {
        border-color: var(--smartelite-danger);
    }
    
    .mobile-form-field {
        margin-bottom: 1.5rem;
    }
    
    .mobile-form-actions {
        margin-top: 2rem;
    }
    
    .mobile-submit-btn {
        padding: 1rem;
        font-size: 1.1rem;
        font-weight: 600;
        min-height: 52px;
        border-radius: 0.75rem;
    }
    
    .mobile-back-btn {
        padding: 0.75rem;
        font-size: 1rem;
        min-height: 48px;
        border-radius: 0.75rem;
    }
    
    .mobile-breadcrumb .breadcrumb {
        font-size: 0.85rem;
        padding: 0.5rem 0;
    }
    
    .mobile-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        font-size: 1.2rem;
    }
    
    .form-check-group .form-check {
        margin-bottom: 0.75rem;
        padding: 0.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        background-color: #f8fafc;
    }
    
    .form-check-input {
        width: 1.2rem;
        height: 1.2rem;
        margin-top: 0.1rem;
    }
    
    .form-check-label {
        font-size: 0.95rem;
        margin-left: 0.5rem;
        line-height: 1.4;
    }
    
    .invalid-feedback {
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
    
    .alert {
        font-size: 0.9rem;
        padding: 0.75rem;
        margin-bottom: 1rem;
    }
}

/* Tablet and larger screens */
@media (min-width: 769px) {
    .h2-md {
        font-size: 2rem;
    }
    
    .mobile-form-control {
        font-size: 1rem;
        padding: 0.75rem 1rem;
    }
    
    .mobile-form-title {
        font-size: 2rem;
    }
}

/* Large screens */
@media (min-width: 1200px) {
    .mobile-form-card {
        max-width: 800px;
        margin: 0 auto;
    }
}

/* Touch device optimizations */
@media (hover: none) and (pointer: coarse) {
    .mobile-form-control {
        font-size: 16px; /* Prevents zoom on iOS */
    }
    
    .btn {
        min-height: 48px;
    }
    
    .form-check-input {
        min-width: 20px;
        min-height: 20px;
    }
}

/* High DPI displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .mobile-form-control {
        border-width: 1px;
    }
}

/* Enhanced Mobile Progress Container */
.mobile-progress-container {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(35px);
    -webkit-backdrop-filter: blur(35px);
    padding: 1.5rem;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
}

.mobile-progress-bar {
    width: 100%;
    height: 8px;
    background: #e5e7eb;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.mobile-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--smartelite-primary), var(--smartelite-secondary));
    border-radius: 4px;
    transition: width 0.3s ease;
    width: 0%;
    box-shadow: 0 2px 8px rgba(0, 166, 82, 0.3);
}

.mobile-optimized-form {
    position: relative;
}

/* Enhanced Button States */
.mobile-submit-btn {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.mobile-submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.mobile-submit-btn .btn-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.mobile-submit-btn:disabled .btn-content {
    opacity: 0;
}

.mobile-submit-btn:disabled .btn-loading {
    display: flex !important;
    align-items: center;
    justify-content: center;
}

/* Real-time Validation Feedback */
.mobile-form-control.is-valid {
    border-color: var(--smartelite-success);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='m2.3 6.73.94-.94 1.89-1.89-1.89-1.89-.94-.94L2.3 1.89l.94.94L5.13 4.72l-1.89 1.89-.94.94z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.mobile-form-control.is-invalid {
    border-color: var(--smartelite-danger);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23ef4444'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 1.4 1.4 1.4-1.4'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

/* Enhanced Mobile Animations */
@keyframes mobileSlideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mobile-form-field {
    animation: mobileSlideIn 0.3s ease-out;
}

/* Improved Focus States */
.mobile-form-control:focus {
    border-color: var(--smartelite-primary);
    box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.15);
    outline: none;
}

/* Better Error Messages */
.invalid-feedback {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: var(--smartelite-danger);
}

/* Success Messages */
.valid-feedback {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: var(--smartelite-success);
}

/* Mobile-specific improvements for very small screens */
@media (max-width: 480px) {
    .mobile-form-card {
        margin: 0.25rem;
        border-radius: 0.75rem;
    }
    
    .mobile-form-control {
        font-size: 16px;
        padding: 0.75rem;
        min-height: 48px;
    }
    
    .mobile-submit-btn {
        min-height: 52px;
        font-size: 1.1rem;
    }
}
</style>

<!-- Advanced Mobile JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('mobileForm');
    const submitBtn = document.getElementById('submitBtn');
    const progressFill = document.getElementById('progressFill');
    const progressText = document.getElementById('progressText');
    const formFields = form.querySelectorAll('.mobile-form-control');
    
    // Real-time validation
    formFields.forEach(field => {
        field.addEventListener('input', function() {
            validateField(this);
            updateProgress();
        });
        
        field.addEventListener('blur', function() {
            validateField(this);
        });
    });
    
    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.querySelector('.btn-content').classList.add('d-none');
        submitBtn.querySelector('.btn-loading').classList.remove('d-none');
        
        // Validate all fields before submission
        let isValid = true;
        formFields.forEach(field => {
            if (!validateField(field)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.querySelector('.btn-content').classList.remove('d-none');
            submitBtn.querySelector('.btn-loading').classList.add('d-none');
            
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
            return;
        }
        
        // Submit form
        setTimeout(() => {
            form.submit();
        }, 500);
    });
    
    function validateField(field) {
        const value = field.value.trim();
        const isRequired = field.hasAttribute('required');
        const fieldType = field.type;
        
        // Remove existing validation classes
        field.classList.remove('is-valid', 'is-invalid');
        
        // Check if field is empty and required
        if (isRequired && !value) {
            field.classList.add('is-invalid');
            return false;
        }
        
        // Skip validation for empty optional fields
        if (!value && !isRequired) {
            return true;
        }
        
        // Type-specific validation
        let isValid = true;
        
        switch (fieldType) {
            case 'email':
                isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
                break;
            case 'tel':
                isValid = /^[\+]?[0-9\s\-\(\)]{10,}$/.test(value);
                break;
            case 'number':
                isValid = !isNaN(value) && value !== '';
                break;
            case 'date':
                isValid = value !== '' && new Date(value) <= new Date();
                break;
        }
        
        if (isValid) {
            field.classList.add('is-valid');
        } else {
            field.classList.add('is-invalid');
        }
        
        return isValid;
    }
    
    function updateProgress() {
        const totalFields = formFields.length;
        const filledFields = Array.from(formFields).filter(field => {
            return field.value.trim() !== '' || !field.hasAttribute('required');
        }).length;
        
        const progress = (filledFields / totalFields) * 100;
        progressFill.style.width = progress + '%';
        progressText.textContent = `Step ${filledFields} of ${totalFields}`;
    }
    
    // Initialize progress
    updateProgress();
    
    // Add haptic feedback for mobile devices
    if ('vibrate' in navigator) {
        formFields.forEach(field => {
            field.addEventListener('focus', function() {
                navigator.vibrate(10);
            });
        });
        
        submitBtn.addEventListener('click', function() {
            navigator.vibrate(20);
        });
    }
    
    // Prevent zoom on input focus (iOS)
    if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
        formFields.forEach(field => {
            field.addEventListener('focus', function() {
                const viewport = document.querySelector('meta[name="viewport"]');
                viewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
            });
            
            field.addEventListener('blur', function() {
                const viewport = document.querySelector('meta[name="viewport"]');
                viewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes';
            });
        });
    }
    
    // Auto-resize textareas
    const textareas = form.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
    
    // Smooth scrolling for form navigation
    const labels = form.querySelectorAll('.mobile-form-label');
    labels.forEach(label => {
        label.addEventListener('click', function() {
            const field = document.getElementById(this.getAttribute('for'));
            if (field) {
                field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => field.focus(), 300);
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
