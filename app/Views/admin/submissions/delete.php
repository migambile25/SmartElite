<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-trash me-2"></i>Delete Submission - <?= esc($form['title']) ?>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Submissions
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirm Submission Deletion
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. Deleting this submission will permanently remove all submitted data.
                </div>

                <h6>Submission Details:</h6>
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Submission ID:</strong> #<?= $submission['id'] ?></p>
                                <p><strong>Form:</strong> <?= esc($form['title']) ?></p>
                                <p><strong>Submitted:</strong> <?= date('M j, Y g:i A', strtotime($submission['submitted_at'])) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>IP Address:</strong> <code><?= esc($submission['ip_address']) ?></code></p>
                                <p><strong>Time Ago:</strong> <?= $this->timeAgo($submission['submitted_at']) ?></p>
                                <p><strong>Data Fields:</strong> <?= count($submission['submission_data'] ?? []) ?> fields</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6>Sample of Submitted Data:</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            <?php if (!empty($submission['submission_data'])): ?>
                                <?php $count = 0; ?>
                                <?php foreach ($submission['submission_data'] as $fieldName => $value): ?>
                                    <?php if ($count < 5): ?>
                                        <p class="small mb-1">
                                            <strong><?= esc(ucwords(str_replace('_', ' ', $fieldName))) ?>:</strong>
                                            <?php if (is_array($value)): ?>
                                                <?= esc(implode(', ', $value)) ?>
                                            <?php else: ?>
                                                <?= esc(substr($value, 0, 100)) ?><?= strlen($value) > 100 ? '...' : '' ?>
                                            <?php endif; ?>
                                        </p>
                                        <?php $count++; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php if (count($submission['submission_data']) > 5): ?>
                                    <p class="small text-muted">
                                        ... and <?= count($submission['submission_data']) - 5 ?> more fields
                                    </p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="small text-muted">No data available</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6>Impact of Deletion:</h6>
                    <ul class="text-muted">
                        <li>All submitted data will be permanently removed</li>
                        <li>This action cannot be undone</li>
                        <li>Form statistics will be updated</li>
                        <li>Export files will no longer include this submission</li>
                    </ul>
                </div>

                <form method="POST" action="<?= base_url('admin/forms/' . $form['id'] . '/submissions/delete/' . $submission['id']) ?>" class="mt-4">
                    <?= csrf_field() ?>
                    
                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Yes, Delete Submission
                        </button>
                    </div>
                </form>
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
