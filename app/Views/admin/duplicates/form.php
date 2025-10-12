<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-bar-chart me-2"></i>Duplicate Analysis - <?= esc($form['title']) ?>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/duplicates') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Overview
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Submissions
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $stats['total_submissions'] ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-file-earmark-text fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Unique Emails
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $stats['unique_emails'] ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-envelope fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Unique Phones
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $stats['unique_phones'] ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="bi bi-phone fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Duplicates Prevented
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $stats['duplicate_emails'] + $stats['duplicate_phones'] + $stats['duplicate_names'] ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-shield-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Breakdown -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-pie-chart me-2"></i>Duplicate Breakdown
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="text-center p-3 border rounded">
                            <h4 class="text-danger"><?= $stats['duplicate_emails'] ?></h4>
                            <p class="mb-0">Duplicate Emails</p>
                            <small class="text-muted">Prevented</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center p-3 border rounded">
                            <h4 class="text-warning"><?= $stats['duplicate_phones'] ?></h4>
                            <p class="mb-0">Duplicate Phones</p>
                            <small class="text-muted">Prevented</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center p-3 border rounded">
                            <h4 class="text-info"><?= $stats['duplicate_names'] ?></h4>
                            <p class="mb-0">Duplicate Names</p>
                            <small class="text-muted">Prevented</small>
                        </div>
                    </div>
                </div>

                <?php if ($stats['total_submissions'] > 0): ?>
                    <?php 
                    $duplicateRate = (($stats['duplicate_emails'] + $stats['duplicate_phones'] + $stats['duplicate_names']) / $stats['total_submissions']) * 100;
                    $duplicateRate = round($duplicateRate, 2);
                    ?>
                    <div class="mt-4">
                        <h6>Duplicate Prevention Rate</h6>
                        <div class="progress mb-2">
                            <div class="progress-bar <?= $duplicateRate > 10 ? 'bg-warning' : 'bg-success' ?>" 
                                 role="progressbar" 
                                 style="width: <?= min($duplicateRate, 100) ?>%">
                                <?= $duplicateRate ?>%
                            </div>
                        </div>
                        <small class="text-muted">
                            <?= $duplicateRate ?>% of submissions were duplicates and prevented
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>How It Works
                </h5>
            </div>
            <div class="card-body">
                <h6>Duplicate Detection Fields:</h6>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle text-success me-2"></i>Email addresses</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Phone numbers</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Student/Registration numbers</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>National ID/Passport numbers</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Full name + email combinations</li>
                </ul>

                <div class="alert alert-info mt-3">
                    <small>
                        <i class="bi bi-lightbulb me-2"></i>
                        <strong>Smart Detection:</strong> The system normalizes phone numbers and email addresses to catch variations in formatting.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-gear me-2"></i>Form Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" class="btn btn-primary">
                        <i class="bi bi-inbox me-2"></i>View All Submissions
                    </a>
                    <a href="<?= base_url('admin/forms/edit/' . $form['id']) ?>" class="btn btn-outline-warning">
                        <i class="bi bi-pencil me-2"></i>Edit Form
                    </a>
                    <a href="<?= base_url('register/' . $form['slug']) ?>" target="_blank" class="btn btn-outline-info">
                        <i class="bi bi-eye me-2"></i>Preview Form
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
</style>

<?= $this->endSection() ?>
