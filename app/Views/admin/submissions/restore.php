<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
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

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-arrow-clockwise me-2"></i>Restore Submission
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> You are about to restore a deleted submission. This will make the submission visible again in the admin panel.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Submission Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Form:</th>
                                    <td><?= esc($form['title']) ?></td>
                                </tr>
                                <tr>
                                    <th>Submission ID:</th>
                                    <td>#<?= $submission['id'] ?></td>
                                </tr>
                                <tr>
                                    <th>Submitted:</th>
                                    <td><?= date('M j, Y g:i A', strtotime($submission['submitted_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Time Ago:</th>
                                    <td><?= timeAgo($submission['submitted_at']) ?></td>
                                </tr>
                                <tr>
                                    <th>IP Address:</th>
                                    <td><?= esc($submission['ip_address']) ?></td>
                                </tr>
                                <tr>
                                    <th>Data Fields:</th>
                                    <td><?= getSubmissionDataCount($submission['submission_data'] ?? '') ?> fields</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-danger">Deleted</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Deleted:</th>
                                    <td>
                                        <?php if ($submission['deleted_at']): ?>
                                            <?= date('M j, Y g:i A', strtotime($submission['deleted_at'])) ?>
                                        <?php else: ?>
                                            Unknown
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Submission Data Preview</h5>
                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                <?php 
                                $submissionData = $submission['submission_data'] ?? '';
                                if (is_string($submissionData)) {
                                    $submissionData = json_decode($submissionData, true) ?? [];
                                }
                                if (!empty($submissionData) && is_array($submissionData)): ?>
                                    <?php $count = 0; ?>
                                    <?php foreach ($submissionData as $fieldName => $value): ?>
                                        <?php if ($count >= 5) break; ?>
                                        <div class="mb-2">
                                            <strong><?= esc($fieldName) ?>:</strong>
                                            <span class="text-muted">
                                                <?php if (is_array($value)): ?>
                                                    <?= esc(implode(', ', $value)) ?>
                                                <?php else: ?>
                                                    <?= esc($value) ?>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <?php $count++; ?>
                                    <?php endforeach; ?>
                                    <?php if (count($submissionData) > 5): ?>
                                        <p class="small text-muted">
                                            ... and <?= count($submissionData) - 5 ?> more fields
                                        </p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p class="text-muted">No data available</p>
                                <?php endif; ?>
                            </div>
                            
                            <h5 class="mt-3">What happens when you restore?</h5>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Submission will become visible in admin panel
                                </li>
                                <li class="list-group-item">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    All submission data will be preserved
                                </li>
                                <li class="list-group-item">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Submission can be exported again
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-4">
                        <form id="restoreForm" method="post" action="<?= base_url('admin/forms/' . $form['id'] . '/submissions/restore/' . $submission['id']) ?>">
                            <?= csrf_field() ?>
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" id="restoreBtn" class="btn btn-warning">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Restore Submission
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('restoreForm').addEventListener('submit', function(e) {
    // Show loading state
    const restoreBtn = document.getElementById('restoreBtn');
    restoreBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Restoring...';
    restoreBtn.disabled = true;
});
</script>
<?= $this->endSection() ?>
