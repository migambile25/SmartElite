<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-shield-check me-2"></i>Duplicate Detection
    </h1>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Duplicate Prevention Overview
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-3">
                    The SmartElite system automatically prevents duplicate submissions by checking for identical data across multiple fields. 
                    This ensures data integrity and prevents spam submissions.
                </p>
                
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Fields Checked for Duplicates:</strong>
                    <ul class="mb-0 mt-2">
                        <li><strong>Email addresses</strong> - Primary identifier</li>
                        <li><strong>Phone numbers</strong> - Mobile/telephone numbers</li>
                        <li><strong>Student/Registration numbers</strong> - Academic identifiers</li>
                        <li><strong>National ID/Passport numbers</strong> - Government identifiers</li>
                        <li><strong>Full name + email combinations</strong> - Name and email together</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <?php foreach ($formStats as $formId => $formData): ?>
        <?php $form = $formData['form']; ?>
        <?php $stats = $formData['stats']; ?>
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i><?= esc($form['title']) ?>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="text-primary mb-1"><?= $stats['total_submissions'] ?></h4>
                                <small class="text-muted">Total Submissions</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="text-success mb-1"><?= $stats['unique_emails'] ?></h4>
                                <small class="text-muted">Unique Emails</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="text-info mb-1"><?= $stats['unique_phones'] ?></h4>
                                <small class="text-muted">Unique Phones</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="text-warning mb-1"><?= $stats['duplicate_emails'] + $stats['duplicate_phones'] + $stats['duplicate_names'] ?></h4>
                                <small class="text-muted">Duplicates Prevented</small>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ($stats['duplicate_emails'] > 0 || $stats['duplicate_phones'] > 0 || $stats['duplicate_names'] > 0): ?>
                        <div class="alert alert-warning mt-3">
                            <h6><i class="bi bi-exclamation-triangle me-2"></i>Duplicate Breakdown:</h6>
                            <ul class="mb-0">
                                <?php if ($stats['duplicate_emails'] > 0): ?>
                                    <li><?= $stats['duplicate_emails'] ?> duplicate email(s) prevented</li>
                                <?php endif; ?>
                                <?php if ($stats['duplicate_phones'] > 0): ?>
                                    <li><?= $stats['duplicate_phones'] ?> duplicate phone(s) prevented</li>
                                <?php endif; ?>
                                <?php if ($stats['duplicate_names'] > 0): ?>
                                    <li><?= $stats['duplicate_names'] ?> duplicate name+email combination(s) prevented</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success mt-3">
                            <i class="bi bi-check-circle me-2"></i>
                            <strong>No duplicates detected!</strong> All submissions are unique.
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('admin/duplicates/form/' . $form['id']) ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-bar-chart me-2"></i>View Detailed Analysis
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if (empty($formStats)): ?>
    <div class="row">
        <div class="col-12">
            <div class="text-center py-5">
                <i class="bi bi-shield-check text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">No Forms Available</h4>
                <p class="text-muted">Create some forms to start tracking duplicate submissions.</p>
                <a href="<?= base_url('admin/forms/create') ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create Your First Form
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
