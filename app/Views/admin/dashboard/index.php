<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="d-flex gap-2 me-2">
            <a href="<?= base_url('admin/notifications') ?>" class="btn btn-outline-info">
                <i class="bi bi-bell me-2"></i>Notifications
            </a>
            <a href="<?= base_url('admin/duplicates') ?>" class="btn btn-outline-warning">
                <i class="bi bi-shield-check me-2"></i>Duplicates
            </a>
        </div>
        <a href="<?= base_url('admin/forms/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Create New Form
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="text-muted small text-uppercase fw-bold mb-1">
                            Total Forms
                        </div>
                        <div class="h4 mb-0 fw-bold text-primary">
                            <?= $totalForms ?>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="text-muted small text-uppercase fw-bold mb-1">
                            Active Forms
                        </div>
                        <div class="h4 mb-0 fw-bold text-success">
                            <?= $activeForms ?>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="text-muted small text-uppercase fw-bold mb-1">
                            Total Submissions
                        </div>
                        <div class="h4 mb-0 fw-bold text-info">
                            <?= $totalSubmissions ?>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-inbox text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="text-muted small text-uppercase fw-bold mb-1">
                            Today's Submissions
                        </div>
                        <div class="h4 mb-0 fw-bold text-warning">
                            <?= count(array_filter($recentSubmissions, function($sub) { 
                                return date('Y-m-d', strtotime($sub['submitted_at'])) === date('Y-m-d'); 
                            })) ?>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-calendar-day text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Submissions -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-clock-history me-2"></i>Recent Submissions
                    </h6>
                    <div class="d-flex align-items-center gap-2">
                        <small class="text-muted">Showing <?= $submissionLimit ?> most recent</small>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-gear"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><h6 class="dropdown-header">Show Submissions</h6></li>
                                <li><a class="dropdown-item <?= $submissionLimit == 5 ? 'active' : '' ?>" href="?limit=5">5 most recent</a></li>
                                <li><a class="dropdown-item <?= $submissionLimit == 10 ? 'active' : '' ?>" href="?limit=10">10 most recent</a></li>
                                <li><a class="dropdown-item <?= $submissionLimit == 20 ? 'active' : '' ?>" href="?limit=20">20 most recent</a></li>
                                <li><a class="dropdown-item <?= $submissionLimit == 50 ? 'active' : '' ?>" href="?limit=50">50 most recent</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($recentSubmissions)): ?>
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">No submissions yet</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Form</th>
                                    <th>Data Preview</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentSubmissions as $submission): ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($submission['form_title']) ?></strong>
                                    </td>
                                    <td>
                                        <?php 
                                        $submissionData = $submission['submission_data'] ?? '';
                                        if (is_string($submissionData)) {
                                            $submissionData = json_decode($submissionData, true) ?? [];
                                        }
                                        if (!empty($submissionData) && is_array($submissionData)): 
                                            $previewData = array_slice($submissionData, 0, 1, true);
                                        ?>
                                            <div class="small">
                                                <?php foreach ($previewData as $key => $value): ?>
                                                    <div class="mb-1">
                                                        <strong><?= esc(ucwords(str_replace('_', ' ', $key))) ?>:</strong>
                                                        <span class="text-muted">
                                                            <?= esc(strlen($value) > 25 ? substr($value, 0, 25) . '...' : $value) ?>
                                                        </span>
                                                    </div>
                                                <?php endforeach; ?>
                                                <?php if (count($submissionData) > 1): ?>
                                                    <small class="text-muted">
                                                        <i class="bi bi-three-dots"></i> +<?= count($submissionData) - 1 ?> more fields
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted small">No data</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?= date('M j, Y', strtotime($submission['submitted_at'])) ?></strong>
                                            <br><small class="text-muted"><?= date('g:i A', strtotime($submission['submitted_at'])) ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="<?= base_url('admin/forms/' . $submission['form_id'] . '/submissions/' . $submission['id']) ?>" 
                                               class="btn btn-sm btn-outline-primary" title="View Submission">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/forms/' . $submission['form_id'] . '/submissions') ?>" 
                                               class="btn btn-sm btn-outline-secondary" title="View All Submissions">
                                                <i class="bi bi-inbox"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (count($recentSubmissions) >= $submissionLimit): ?>
                    <div class="card-footer bg-light">
                        <div class="text-center">
                            <a href="<?= base_url('admin/forms') ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-2"></i>View All Forms & Submissions
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Forms Overview -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-file-earmark-text me-2"></i>Forms Overview
                </h6>
            </div>
            <div class="card-body">
                <?php if (empty($formsWithStats)): ?>
                    <div class="text-center py-4">
                        <i class="bi bi-file-earmark-plus text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">No forms created yet</p>
                        <a href="<?= base_url('admin/forms/create') ?>" class="btn btn-primary btn-sm">
                            Create Your First Form
                        </a>
                    </div>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach ($formsWithStats as $form): ?>
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" 
                                                   class="text-decoration-none text-dark">
                                                    <?= esc($form['title']) ?>
                                                </a>
                                            </h6>
                                            <div class="d-flex align-items-center gap-2">
                                                <small class="text-muted">
                                                    <i class="bi bi-inbox me-1"></i><?= $form['submission_count'] ?> submissions
                                                </small>
                                                <?php if ($form['is_active']): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Inactive</span>
                                                <?php endif; ?>
                                                <?php if ($form['is_primary']): ?>
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="bi bi-star-fill me-1"></i>Primary
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" 
                                               class="btn btn-sm btn-outline-primary" title="View Submissions">
                                                <i class="bi bi-inbox"></i>
                                            </a>
                                            <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields') ?>" 
                                               class="btn btn-sm btn-outline-info" title="Manage Fields">
                                                <i class="bi bi-list-ul"></i>
                                            </a>
                                            <a href="<?= base_url('admin/forms/edit/' . $form['id']) ?>" 
                                               class="btn btn-sm btn-outline-warning" title="Edit Form">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
