<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-file-earmark-text me-2"></i>Forms Management
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/forms/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Create New Form
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <?php if (empty($forms)): ?>
            <div class="text-center py-5">
                <i class="bi bi-file-earmark-plus text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 text-muted">No Forms Created Yet</h4>
                <p class="text-muted">Get started by creating your first form to collect submissions.</p>
                <a href="<?= base_url('admin/forms/create') ?>" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Create Your First Form
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($forms as $form): ?>
                        <tr>
                            <td>
                                <div>
                                    <strong><?= esc($form['title']) ?></strong>
                                    <?php if (!empty($form['description'])): ?>
                                        <br><small class="text-muted"><?= esc($form['description']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <code><?= esc($form['slug']) ?></code>
                                <br><small class="text-muted">
                                    <a href="<?= base_url('register/' . $form['slug']) ?>" target="_blank" class="text-decoration-none">
                                        <i class="bi bi-box-arrow-up-right me-1"></i>View Form
                                    </a>
                                </small>
                            </td>
                            <td>
                                <?php if ($form['is_active']): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?= date('M j, Y', strtotime($form['created_at'])) ?>
                                </small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields') ?>" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Manage Fields">
                                        <i class="bi bi-list-ul"></i>
                                    </a>
                                    <a href="<?= base_url('admin/forms/' . $form['id'] . '/submissions') ?>" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="View Submissions">
                                        <i class="bi bi-inbox"></i>
                                    </a>
                                    <a href="<?= base_url('admin/forms/edit/' . $form['id']) ?>" 
                                       class="btn btn-sm btn-outline-warning" 
                                       title="Edit Form">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('admin/forms/delete/' . $form['id']) ?>" 
                                       class="btn btn-sm btn-outline-danger btn-delete" 
                                       title="Delete Form">
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
<?= $this->endSection() ?>
