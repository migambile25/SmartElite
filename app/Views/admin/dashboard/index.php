<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
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
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Forms
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $totalForms ?>
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
                            Active Forms
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $activeForms ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Submissions
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $totalSubmissions ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-inbox fa-2x text-gray-300"></i>
                    </div>
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
                            Today's Submissions
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_filter($recentSubmissions, function($sub) { 
                                return date('Y-m-d', strtotime($sub['submitted_at'])) === date('Y-m-d'); 
                            })) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-day fa-2x text-gray-300"></i>
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
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-clock-history me-2"></i>Recent Submissions
                </h6>
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
                                    <th>Submitted</th>
                                    <th>IP Address</th>
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
                                        <small class="text-muted">
                                            <?= date('M j, Y g:i A', strtotime($submission['submitted_at'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <code><?= esc($submission['ip_address']) ?></code>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/forms/' . $submission['form_id'] . '/submissions/' . $submission['id']) ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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
                    <?php foreach ($formsWithStats as $form): ?>
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">
                                <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" 
                                   class="text-decoration-none">
                                    <?= esc($form['title']) ?>
                                </a>
                            </h6>
                            <small class="text-muted">
                                <?= $form['submission_count'] ?> submissions
                                <?php if ($form['is_active']): ?>
                                    <span class="badge bg-success ms-2">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary ms-2">Inactive</span>
                                <?php endif; ?>
                            </small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                    type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/forms/edit/' . $form['id']) ?>">
                                        <i class="bi bi-pencil me-2"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/forms/' . $form['id'] . '/fields') ?>">
                                        <i class="bi bi-list-ul me-2"></i>Fields
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>">
                                        <i class="bi bi-inbox me-2"></i>Submissions
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="<?= base_url('admin/forms/delete/' . $form['id']) ?>">
                                        <i class="bi bi-trash me-2"></i>Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
