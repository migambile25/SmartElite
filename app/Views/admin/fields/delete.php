<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-trash me-2"></i>Delete Field - <?= esc($form['title']) ?>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Fields
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirm Field Deletion
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> This action will remove the field from the form. Users will no longer see this field when filling out the form.
                </div>

                <h6>Field Details:</h6>
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Field Name:</strong> <code><?= esc($field['field_name']) ?></code></p>
                                <p><strong>Field Label:</strong> <?= esc($field['field_label']) ?></p>
                                <p><strong>Field Type:</strong> <span class="badge bg-info"><?= esc($field['field_type']) ?></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Required:</strong> 
                                    <?php if ($field['is_required']): ?>
                                        <span class="badge bg-danger">Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No</span>
                                    <?php endif; ?>
                                </p>
                                <p><strong>Order:</strong> <?= $field['field_order'] ?></p>
                                <p><strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($field['created_at'])) ?></p>
                            </div>
                        </div>
                        
                        <?php if ($field['validation_rules']): ?>
                        <div class="mt-3">
                            <p><strong>Validation Rules:</strong></p>
                            <code><?= esc($field['validation_rules']) ?></code>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($field['field_options']): ?>
                        <div class="mt-3">
                            <p><strong>Field Options:</strong></p>
                            <pre class="small"><?= esc($field['field_options']) ?></pre>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <h6>Impact of Deletion:</h6>
                    <ul class="text-muted">
                        <li>This field will be removed from the form</li>
                        <li>Users will no longer see this field when filling out the form</li>
                        <li>Existing submissions will retain this field's data</li>
                        <li>Form validation will no longer check this field</li>
                    </ul>
                </div>

                <form method="POST" action="<?= base_url('admin/forms/' . $form['id'] . '/fields/delete/' . $field['id']) ?>" class="mt-4" id="deleteForm">
                    <?= csrf_field() ?>
                    
                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-danger" id="deleteBtn">
                            <i class="bi bi-trash me-2"></i>Yes, Delete Field
                        </button>
                    </div>
                </form>

                <script>
                document.getElementById('deleteForm').addEventListener('submit', function(e) {
                    console.log('Form submitted!');
                    console.log('Form action:', this.action);
                    console.log('Form method:', this.method);
                    console.log('CSRF token:', document.querySelector('input[name="csrf_test_name"]').value);
                    
                    // Show loading state
                    const deleteBtn = document.getElementById('deleteBtn');
                    deleteBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Deleting...';
                    deleteBtn.disabled = true;
                });
                </script>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
