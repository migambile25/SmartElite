<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-trash-fill me-2"></i>Permanently Delete Form
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Danger:</strong> You are about to permanently delete this form. This action cannot be undone and will remove all associated data.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Form Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Title:</th>
                                    <td><?= esc($form['title']) ?></td>
                                </tr>
                                <tr>
                                    <th>Slug:</th>
                                    <td><code><?= esc($form['slug']) ?></code></td>
                                </tr>
                                <tr>
                                    <th>Description:</th>
                                    <td><?= esc($form['description']) ?: 'No description' ?></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-danger">Deleted</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td><?= date('M j, Y g:i A', strtotime($form['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Deleted:</th>
                                    <td>
                                        <?php if ($form['deleted_at']): ?>
                                            <?= date('M j, Y g:i A', strtotime($form['deleted_at'])) ?>
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
                                    <strong>Form record</strong> - Completely removed from database
                                </li>
                                <li class="list-group-item list-group-item-danger">
                                    <i class="bi bi-x-circle me-2"></i>
                                    <strong>All form fields</strong> - All field configurations
                                </li>
                                <li class="list-group-item list-group-item-danger">
                                    <i class="bi bi-x-circle me-2"></i>
                                    <strong>All submissions</strong> - All user submissions and data
                                </li>
                                <li class="list-group-item list-group-item-danger">
                                    <i class="bi bi-x-circle me-2"></i>
                                    <strong>Public access</strong> - Form will no longer be accessible
                                </li>
                            </ul>
                            
                            <div class="alert alert-warning mt-3">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Note:</strong> This action cannot be undone. Consider restoring the form instead if you might need it later.
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <form id="permanentDeleteForm" method="post" action="<?= base_url('admin/forms/permanent-delete/' . $form['id']) ?>">
                            <?= csrf_field() ?>
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('admin/forms') ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" id="permanentDeleteBtn" class="btn btn-danger" 
                                        onclick="return confirm('Are you absolutely sure you want to permanently delete this form? This action cannot be undone!')">
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
