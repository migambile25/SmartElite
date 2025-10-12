<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-eye me-2"></i>View Submission - <?= esc($form['title']) ?>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Submissions
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-person me-2"></i>Submission Details
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Submission Information</h6>
                        <p class="small">
                            <strong>Submission ID:</strong> #<?= $submission['id'] ?><br>
                            <strong>Submitted:</strong> <?= date('M j, Y g:i A', strtotime($submission['submitted_at'])) ?><br>
                            <strong>IP Address:</strong> <code><?= esc($submission['ip_address']) ?></code>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Form Information</h6>
                        <p class="small">
                            <strong>Form:</strong> <?= esc($form['title']) ?><br>
                            <strong>Form ID:</strong> #<?= $form['id'] ?><br>
                            <strong>Form Slug:</strong> <code><?= esc($form['slug']) ?></code>
                        </p>
                    </div>
                </div>

                <hr>

                <h6>Form Data</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($submission['submission_data'])): ?>
                                <?php foreach ($submission['submission_data'] as $fieldName => $value): ?>
                                <tr>
                                    <td>
                                        <strong><?= esc(ucwords(str_replace('_', ' ', $fieldName))) ?></strong>
                                    </td>
                                    <td>
                                        <?php if (is_array($value)): ?>
                                            <ul class="mb-0">
                                                <?php foreach ($value as $item): ?>
                                                    <li><?= esc($item) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php elseif (is_string($value) && strlen($value) > 100): ?>
                                            <div class="text-break">
                                                <?= esc($value) ?>
                                            </div>
                                        <?php else: ?>
                                            <?= esc($value) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="text-center text-muted">
                                        <i class="bi bi-inbox me-2"></i>No data available
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($submission['user_agent']): ?>
                <hr>
                <h6>Technical Information</h6>
                <p class="small">
                    <strong>User Agent:</strong><br>
                    <code class="small"><?= esc($submission['user_agent']) ?></code>
                </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Submission Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Submissions
                    </a>
                    <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions/export') ?>" class="btn btn-outline-success">
                        <i class="bi bi-download me-2"></i>Export All to CSV
                    </a>
                    <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions/delete/' . $submission['id']) ?>" class="btn btn-outline-danger">
                        <i class="bi bi-trash me-2"></i>Delete Submission
                    </a>
                </div>

                <hr>

                <h6>Quick Stats</h6>
                <p class="small text-muted">
                    <strong>Total Fields:</strong> <?= count($submission['submission_data'] ?? []) ?><br>
                    <strong>Submission Time:</strong> <?= date('M j, Y', strtotime($submission['submitted_at'])) ?><br>
                    <strong>Time Ago:</strong> <?= $this->timeAgo($submission['submitted_at']) ?>
                </p>

                <hr>

                <h6>Form Preview</h6>
                <p class="small text-muted">
                    <a href="<?= base_url('register/' . $form['slug']) ?>" target="_blank" class="text-decoration-none">
                        <i class="bi bi-box-arrow-up-right me-1"></i>View Live Form
                    </a>
                </p>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-shield-check me-2"></i>Data Privacy
                </h6>
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    This submission contains personal information. Ensure you follow your organization's data protection policies when handling this data.
                </p>
            </div>
        </div>
    </div>
</div>

<?php
// Helper function for time ago
if (!function_exists('timeAgo')) {
    function timeAgo($datetime) {
        $time = time() - strtotime($datetime);
        
        if ($time < 60) return 'just now';
        if ($time < 3600) return floor($time/60) . ' minutes ago';
        if ($time < 86400) return floor($time/3600) . ' hours ago';
        if ($time < 2592000) return floor($time/86400) . ' days ago';
        if ($time < 31536000) return floor($time/2592000) . ' months ago';
        return floor($time/31536000) . ' years ago';
    }
}
?>
<?= $this->endSection() ?>
