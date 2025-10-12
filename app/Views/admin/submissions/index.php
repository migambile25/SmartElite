<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-inbox me-2"></i>Submissions - <?= esc($form['title']) ?>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions/export') ?>" class="btn btn-success">
            <i class="bi bi-download me-2"></i>Export CSV
        </a>
        <a href="<?= base_url('admin/forms') ?>" class="btn btn-outline-secondary ms-2">
            <i class="bi bi-arrow-left me-2"></i>Back to Forms
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
                            <?= $stats['total'] ?>
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
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Today
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $stats['today'] ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-day fa-2x text-gray-300"></i>
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
                            This Week
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $stats['this_week'] ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-week fa-2x text-gray-300"></i>
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
                            This Month
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $stats['this_month'] ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-month fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-inbox me-2"></i>All Submissions
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($submissions)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3 text-muted">No Submissions Yet</h4>
                        <p class="text-muted">Submissions will appear here once users start filling out your form.</p>
                        <a href="<?= base_url('register/' . $form['slug']) ?>" target="_blank" class="btn btn-primary">
                            <i class="bi bi-eye me-2"></i>View Form
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Submitted</th>
                                    <th>IP Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($submissions as $submission): ?>
                                <tr>
                                    <td>
                                        <strong>#<?= $submission['id'] ?></strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?= date('M j, Y', strtotime($submission['submitted_at'])) ?></strong>
                                            <br><small class="text-muted"><?= date('g:i A', strtotime($submission['submitted_at'])) ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <code><?= esc($submission['ip_address']) ?></code>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions/' . $submission['id']) ?>" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="View Submission">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions/delete/' . $submission['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger btn-delete" 
                                               title="Delete Submission">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
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
</div>
<?= $this->endSection() ?>
