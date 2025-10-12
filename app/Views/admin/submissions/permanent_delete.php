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
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-trash-fill me-2"></i>Permanently Delete Submission
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Danger:</strong> You are about to permanently delete this submission. This action cannot be undone and will remove all submission data.
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
                            <h5 class="text-danger">What will be permanently deleted?</h5>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-danger">
                                    <i class="bi bi-x-circle me-2"></i>
                                    <strong>Submission record</strong> - Completely removed from database
                                </li>
                                <li class="list-group-item list-group-item-danger">
                                    <i class="bi bi-x-circle me-2"></i>
                                    <strong>All submission data</strong> - All form responses and user data
                                </li>
                                <li class="list-group-item list-group-item-danger">
                                    <i class="bi bi-x-circle me-2"></i>
                                    <strong>Submission metadata</strong> - IP address, user agent, timestamps
                                </li>
                                <li class="list-group-item list-group-item-danger">
                                    <i class="bi bi-x-circle me-2"></i>
                                    <strong>Export data</strong> - Will no longer appear in CSV exports
                                </li>
                            </ul>
                            
                            <div class="alert alert-warning mt-3">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Note:</strong> This action cannot be undone. Consider restoring the submission instead if you might need the data later.
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Submission Data Preview</h5>
                            <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                                <?php 
                                $submissionData = $submission['submission_data'] ?? '';
                                if (is_string($submissionData)) {
                                    $submissionData = json_decode($submissionData, true) ?? [];
                                }
                                if (!empty($submissionData) && is_array($submissionData)): ?>
                                    <?php $count = 0; ?>
                                    <?php foreach ($submissionData as $fieldName => $value): ?>
                                        <?php if ($count >= 3) break; ?>
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
                                    <?php if (count($submissionData) > 3): ?>
                                        <p class="small text-muted">
                                            ... and <?= count($submissionData) - 3 ?> more fields
                                        </p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p class="text-muted">No data available</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <form id="permanentDeleteForm" method="post" action="<?= base_url('admin/forms/' . $form['id'] . '/submissions/permanent-delete/' . $submission['id']) ?>">
                            <?= csrf_field() ?>
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" id="permanentDeleteBtn" class="btn btn-danger" 
                                        onclick="return confirm('Are you absolutely sure you want to permanently delete this submission? This action cannot be undone!')">
                                    <i class="bi bi-trash-fill me-2"></i>Permanently Delete
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
document.getElementById('permanentDeleteForm').addEventListener('submit', function(e) {
    // Show loading state
    const permanentDeleteBtn = document.getElementById('permanentDeleteBtn');
    permanentDeleteBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Deleting...';
    permanentDeleteBtn.disabled = true;
});
</script>
<?= $this->endSection() ?>
