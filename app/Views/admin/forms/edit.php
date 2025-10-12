<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-pencil me-2"></i>Edit Form
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
                <form method="POST" action="<?= base_url('admin/forms/update/' . $form['id']) ?>">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Form Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= $validation->hasError('title') ? 'is-invalid' : '' ?>" 
                               id="title" 
                               name="title" 
                               value="<?= old('title', $form['title']) ?>"
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
                               value="<?= old('slug', $form['slug']) ?>"
                               placeholder="e.g., student-registration">
                        <?php if ($validation->hasError('slug')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('slug') ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-text">URL-friendly identifier for your form. Used in the form URL: /register/{slug}</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control <?= $validation->hasError('description') ? 'is-invalid' : '' ?>" 
                                  id="description" 
                                  name="description" 
                                  rows="3"
                                  placeholder="Enter form description (optional)"><?= old('description', $form['description']) ?></textarea>
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
                                  placeholder="Thank you for your submission!"><?= old('success_message', $form['success_message']) ?></textarea>
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
                                   <?= old('is_active', $form['is_active']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                Active Form
                            </label>
                        </div>
                        <div class="form-text">Only active forms can be accessed by the public.</div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_primary" 
                                   name="is_primary" 
                                   value="1"
                                   <?= old('is_primary', $form['is_primary']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_primary">
                                <strong>Primary Form</strong>
                            </label>
                        </div>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            The primary form will be featured prominently on the homepage. Only one form can be primary at a time.
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('admin/forms') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Form
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
                <h6>Form URL</h6>
                <p class="small">
                    <code><?= base_url('register/' . $form['slug']) ?></code>
                    <br>
                    <a href="<?= base_url('register/' . $form['slug']) ?>" target="_blank" class="text-decoration-none">
                        <i class="bi bi-box-arrow-up-right me-1"></i>View Form
                    </a>
                </p>

                <hr>

                <h6>Quick Actions</h6>
                <div class="d-grid gap-2">
                    <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields') ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-list-ul me-2"></i>Manage Fields
                    </a>
                    <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-inbox me-2"></i>View Submissions
                    </a>
                </div>

                <hr>

                <h6>Form Statistics</h6>
                <p class="small text-muted">
                    Created: <?= date('M j, Y g:i A', strtotime($form['created_at'])) ?><br>
                    Last Updated: <?= date('M j, Y g:i A', strtotime($form['updated_at'])) ?>
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
