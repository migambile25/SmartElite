<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-exclamation-triangle me-2 text-danger"></i>Delete Form
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/forms') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Forms
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Warning!</strong> This action cannot be undone. Deleting this form will also delete all associated fields and submissions.
                </div>

                <h6>Form Details:</h6>
                <div class="card bg-light">
                    <div class="card-body">
                        <h5><?= esc($form['title']) ?></h5>
                        <?php if (!empty($form['description'])): ?>
                            <p class="text-muted"><?= esc($form['description']) ?></p>
                        <?php endif; ?>
                        <p class="mb-0">
                            <strong>Slug:</strong> <code><?= esc($form['slug']) ?></code><br>
                            <strong>Status:</strong> 
                            <?php if ($form['is_active']): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?><br>
                            <strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($form['created_at'])) ?>
                        </p>
                    </div>
                </div>

                <div class="mt-4">
                    <h6>What will be deleted:</h6>
                    <ul class="text-danger">
                        <li>This form and all its data</li>
                        <li>All form fields associated with this form</li>
                        <li>All form submissions for this form</li>
                        <li>The form will no longer be accessible at <code>/register/<?= esc($form['slug']) ?></code></li>
                    </ul>
                </div>

                <form method="POST" action="<?= base_url('admin/forms/delete/' . $form['id']) ?>" class="mt-4">
                    <?= csrf_field() ?>
                    
                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('admin/forms') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Yes, Delete Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
