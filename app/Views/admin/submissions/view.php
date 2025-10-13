<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

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

// Helper function to get submission data count
if (!function_exists('getSubmissionDataCount')) {
    function getSubmissionDataCount($submissionData) {
        if (is_string($submissionData)) {
            $decoded = json_decode($submissionData, true);
            return is_array($decoded) ? count($decoded) : 0;
        }
        return is_array($submissionData) ? count($submissionData) : 0;
    }
}
?>

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
                <?php 
                $submissionData = $submission['submission_data'] ?? '';
                if (is_string($submissionData)) {
                    $submissionData = json_decode($submissionData, true) ?? [];
                }
                if (!empty($submissionData) && is_array($submissionData)): ?>
                    <div class="row">
                        <?php foreach ($submissionData as $fieldName => $value): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 bg-light">
                                <div class="card-body p-3">
                                    <h6 class="card-title text-primary mb-2">
                                        <i class="bi bi-tag me-1"></i><?= esc(ucwords(str_replace('_', ' ', $fieldName))) ?>
                                    </h6>
                                    <div class="card-text">
                                        <?php if (is_array($value)): ?>
                                            <ul class="mb-0 list-unstyled">
                                                <?php foreach ($value as $item): ?>
                                                    <li class="mb-1">
                                                        <span class="badge bg-secondary"><?= esc($item) ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php elseif (is_string($value) && strlen($value) > 100): ?>
                                            <div class="text-break bg-white p-2 rounded border">
                                                <?= esc($value) ?>
                                            </div>
                                        <?php elseif (filter_var($value, FILTER_VALIDATE_EMAIL)): ?>
                                            <a href="mailto:<?= esc($value) ?>" class="text-decoration-none">
                                                <i class="bi bi-envelope me-1"></i><?= esc($value) ?>
                                            </a>
                                        <?php elseif (preg_match('/^[\+]?[1-9][\d]{0,15}$/', $value)): ?>
                                            <a href="tel:<?= esc($value) ?>" class="text-decoration-none">
                                                <i class="bi bi-telephone me-1"></i><?= esc($value) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-dark"><?= esc($value) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-muted">No Data Available</h5>
                        <p class="text-muted">This submission doesn't contain any form data.</p>
                    </div>
                <?php endif; ?>

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
                    <strong>Total Fields:</strong> <?= getSubmissionDataCount($submission['submission_data'] ?? '') ?><br>
                    <strong>Submission Time:</strong> <?= date('M j, Y', strtotime($submission['submitted_at'])) ?><br>
                    <strong>Time Ago:</strong> <?= timeAgo($submission['submitted_at']) ?>
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

<?= $this->endSection() ?>
