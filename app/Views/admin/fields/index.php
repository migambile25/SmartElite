<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-list-ul me-2"></i>Manage Fields - <?= esc($form['title']) ?>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2" role="group">
            <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Field
            </a>
            <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields/bulk-create') ?>" class="btn btn-success">
                <i class="bi bi-plus-square me-2"></i>Bulk Add Fields
            </a>
        </div>
        <a href="<?= base_url('admin/forms') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Forms
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-list-ul me-2"></i>Form Fields
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($fields)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-list-ul text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3 text-muted">No Fields Added Yet</h4>
                        <p class="text-muted">Start building your form by adding fields.</p>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields/create') ?>" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Add Single Field
                            </a>
                            <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields/bulk-create') ?>" class="btn btn-success">
                                <i class="bi bi-plus-square me-2"></i>Bulk Add Fields
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Label</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($fields as $field): ?>
                                <tr class="<?= $field['deleted_flag'] ? 'table-danger opacity-75' : '' ?>">
                                    <td>
                                        <span class="badge <?= $field['deleted_flag'] ? 'bg-danger' : 'bg-secondary' ?>">
                                            <?= $field['field_order'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong class="<?= $field['deleted_flag'] ? 'text-decoration-line-through text-muted' : '' ?>">
                                            <?= esc($field['field_label']) ?>
                                        </strong>
                                        <br><small class="text-muted"><?= esc($field['field_name']) ?></small>
                                        <?php if ($field['deleted_flag']): ?>
                                            <br><small class="text-danger">
                                                <i class="bi bi-trash me-1"></i>Deleted on <?= $field['deleted_at'] ? date('M j, Y g:i A', strtotime($field['deleted_at'])) : 'Unknown' ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= $field['deleted_flag'] ? 'bg-danger' : 'bg-info' ?>">
                                            <?= esc($field['field_type']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($field['is_required']): ?>
                                            <span class="badge <?= $field['deleted_flag'] ? 'bg-danger' : 'bg-danger' ?>">Required</span>
                                        <?php else: ?>
                                            <span class="badge <?= $field['deleted_flag'] ? 'bg-danger' : 'bg-secondary' ?>">Optional</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($field['deleted_flag']): ?>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields/restore/' . $field['id']) ?>" 
                                                   class="btn btn-sm btn-outline-success" 
                                                   title="Restore Field"
                                                   onclick="return confirm('Are you sure you want to restore this field?')">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </a>
                                                <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields/permanent-delete/' . $field['id']) ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   title="Permanently Delete Field"
                                                   onclick="return confirm('Are you sure you want to permanently delete this field? This action cannot be undone.')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields/edit/' . $field['id']) ?>" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   title="Edit Field">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields/delete/' . $field['id']) ?>" 
                                                   class="btn btn-sm btn-outline-danger btn-delete" 
                                                   title="Delete Field">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        <?php endif; ?>
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

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Form Information
                </h6>
            </div>
            <div class="card-body">
                <h6>Form Details</h6>
                <p class="small">
                    <strong>Title:</strong> <?= esc($form['title']) ?><br>
                    <strong>Slug:</strong> <code><?= esc($form['slug']) ?></code><br>
                    <strong>Status:</strong> 
                    <?php if ($form['is_active']): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Inactive</span>
                    <?php endif; ?>
                </p>

                <hr>

                <h6>Form URL</h6>
                <p class="small">
                    <code><?= base_url('register/' . $form['slug']) ?></code>
                    <br>
                    <a href="<?= base_url('register/' . $form['slug']) ?>" target="_blank" class="text-decoration-none">
                        <i class="bi bi-box-arrow-up-right me-1"></i>View Form
                    </a>
                </p>

                <hr>

                <h6>Quick Actions</h6>
                <div class="d-grid gap-2">
                    <a href="<?= base_url('admin/forms/edit/' . $form['id']) ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-pencil me-2"></i>Edit Form
                    </a>
                    <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-inbox me-2"></i>View Submissions
                    </a>
                </div>

                <hr>

                <h6>Field Statistics</h6>
                <p class="small text-muted">
                    Total Fields: <strong><?= count($fields) ?></strong><br>
                    Required Fields: <strong><?= count(array_filter($fields, function($f) { return $f['is_required']; })) ?></strong><br>
                    Optional Fields: <strong><?= count(array_filter($fields, function($f) { return !$f['is_required']; })) ?></strong>
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
