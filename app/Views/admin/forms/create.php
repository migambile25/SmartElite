<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-plus-circle me-2"></i>Create New Form
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/forms') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Forms
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-text me-2"></i>Form Details
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('admin/forms/store') ?>">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Form Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= $validation->hasError('title') ? 'is-invalid' : '' ?>" 
                               id="title" 
                               name="title" 
                               value="<?= old('title') ?>"
                               placeholder="Enter form title"
                               required>
                        <?php if ($validation->hasError('title')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('title') ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-text">This will be displayed as the main heading of your form.</div>
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Form Slug</label>
                        <input type="text" 
                               class="form-control <?= $validation->hasError('slug') ? 'is-invalid' : '' ?>" 
                               id="slug" 
                               name="slug" 
                               value="<?= old('slug') ?>"
                               placeholder="e.g., student-registration (auto-generated if empty)">
                        <?php if ($validation->hasError('slug')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('slug') ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-text">URL-friendly identifier for your form. Leave empty to auto-generate from title.</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control <?= $validation->hasError('description') ? 'is-invalid' : '' ?>" 
                                  id="description" 
                                  name="description" 
                                  rows="3"
                                  placeholder="Enter form description (optional)"><?= old('description') ?></textarea>
                        <?php if ($validation->hasError('description')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('description') ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-text">A brief description of what this form is for.</div>
                    </div>

                    <div class="mb-3">
                        <label for="success_message" class="form-label">Success Message</label>
                        <textarea class="form-control <?= $validation->hasError('success_message') ? 'is-invalid' : '' ?>" 
                                  id="success_message" 
                                  name="success_message" 
                                  rows="2"
                                  placeholder="Thank you for your submission!"><?= old('success_message') ?></textarea>
                        <?php if ($validation->hasError('success_message')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('success_message') ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-text">Message shown to users after successful submission.</div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   <?= old('is_active', true) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                Active Form
                            </label>
                        </div>
                        <div class="form-text">Only active forms can be accessed by the public.</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('admin/forms') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Create Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Form Information
                </h6>
            </div>
            <div class="card-body">
                <h6>What happens next?</h6>
                <ol class="small">
                    <li>Your form will be created with a unique slug</li>
                    <li>You can add fields to your form</li>
                    <li>Form will be accessible at <code>/register/{slug}</code></li>
                    <li>Submissions will be stored in the database</li>
                </ol>

                <hr>

                <h6>Form Slug</h6>
                <p class="small text-muted">
                    A URL-friendly version of your form title will be automatically generated. 
                    This will be used in the form's public URL.
                </p>

                <hr>

                <h6>Tips</h6>
                <ul class="small text-muted">
                    <li>Keep your title descriptive but concise</li>
                    <li>Add a clear description to help users understand the form's purpose</li>
                    <li>Write a friendly success message to thank users</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
