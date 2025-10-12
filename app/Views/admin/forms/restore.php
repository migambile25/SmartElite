<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-arrow-clockwise me-2"></i>Restore Form
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> You are about to restore a deleted form. This will make the form active again and visible to users.
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
                            <h5>What happens when you restore?</h5>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Form will become active and visible to users
                                </li>
                                <li class="list-group-item">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Form fields will remain as they were
                                </li>
                                <li class="list-group-item">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Form submissions will remain intact
                                </li>
                                <li class="list-group-item">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Form can be accessed via its public URL
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-4">
                        <form id="restoreForm" method="post" action="<?= base_url('admin/forms/restore/' . $form['id']) ?>">
                            <?= csrf_field() ?>
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('admin/forms') ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" id="restoreBtn" class="btn btn-warning">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Restore Form
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
