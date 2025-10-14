<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-pencil me-2"></i>Edit Field - <?= esc($form['title']) ?>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Fields
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-pencil me-2"></i>Edit Field Details
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('admin/forms/' . $form['id'] . '/fields/update/' . $field['id']) ?>">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="field_name" class="form-label">Field Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?= $validation->hasError('field_name') ? 'is-invalid' : '' ?>" 
                                       id="field_name" 
                                       name="field_name" 
                                       value="<?= old('field_name', $field['field_name']) ?>"
                                       placeholder="e.g., first_name"
                                       required>
                                <?php if ($validation->hasError('field_name')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('field_name') ?>
                                    </div>
                                <?php endif; ?>
                                <div class="form-text">Internal field name (letters, numbers, dashes, underscores only)</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="field_label" class="form-label">Field Label <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?= $validation->hasError('field_label') ? 'is-invalid' : '' ?>" 
                                       id="field_label" 
                                       name="field_label" 
                                       value="<?= old('field_label', $field['field_label']) ?>"
                                       placeholder="e.g., First Name"
                                       required>
                                <?php if ($validation->hasError('field_label')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('field_label') ?>
                                    </div>
                                <?php endif; ?>
                                <div class="form-text">Display label shown to users</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="field_type" class="form-label">Field Type <span class="text-danger">*</span></label>
                                <select class="form-select <?= $validation->hasError('field_type') ? 'is-invalid' : '' ?>" 
                                        id="field_type" 
                                        name="field_type" 
                                        required>
                                    <option value="">Select field type...</option>
                                    <option value="text" <?= old('field_type', $field['field_type']) === 'text' ? 'selected' : '' ?>>Text Input</option>
                                    <option value="email" <?= old('field_type', $field['field_type']) === 'email' ? 'selected' : '' ?>>Email</option>
                                    <option value="tel" <?= old('field_type', $field['field_type']) === 'tel' ? 'selected' : '' ?>>Phone Number</option>
                                    <option value="number" <?= old('field_type', $field['field_type']) === 'number' ? 'selected' : '' ?>>Number</option>
                                    <option value="date" <?= old('field_type', $field['field_type']) === 'date' ? 'selected' : '' ?>>Date</option>
                                    <option value="textarea" <?= old('field_type', $field['field_type']) === 'textarea' ? 'selected' : '' ?>>Textarea</option>
                                    <option value="select" <?= old('field_type', $field['field_type']) === 'select' ? 'selected' : '' ?>>Dropdown</option>
                                    <option value="radio" <?= old('field_type', $field['field_type']) === 'radio' ? 'selected' : '' ?>>Radio Buttons</option>
                                    <option value="checkbox" <?= old('field_type', $field['field_type']) === 'checkbox' ? 'selected' : '' ?>>Checkboxes</option>
                                    <option value="file" <?= old('field_type', $field['field_type']) === 'file' ? 'selected' : '' ?>>File Upload</option>
                                </select>
                                <?php if ($validation->hasError('field_type')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('field_type') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="field_order" class="form-label">Field Order</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="field_order" 
                                       name="field_order" 
                                       value="<?= old('field_order', $field['field_order']) ?>"
                                       min="0">
                                <div class="form-text">Order in which field appears (0 = auto-assign)</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" id="field_options_container" style="display: none;">
                        <label for="field_options" class="form-label">Field Options</label>
                        <textarea class="form-control" 
                                  id="field_options" 
                                  name="field_options" 
                                  rows="4"
                                  placeholder="Enter options, one per line"><?= old('field_options', is_array($field['field_options']) ? implode("\n", $field['field_options']) : $field['field_options']) ?></textarea>
                        <div class="form-text">For dropdown, radio, or checkbox fields. Enter one option per line.</div>
                    </div>

                    <div class="mb-3">
                        <label for="validation_rules" class="form-label">Validation Rules</label>
                        <input type="text" 
                               class="form-control" 
                               id="validation_rules" 
                               name="validation_rules" 
                               value="<?= old('validation_rules', $field['validation_rules']) ?>"
                               placeholder="e.g., min_length[3]|max_length[50]">
                        <div class="form-text">CodeIgniter validation rules (optional)</div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_required" 
                                   name="is_required" 
                                   value="1"
                                   <?= old('is_required', $field['is_required']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_required">
                                Required Field
                            </label>
                        </div>
                        <div class="form-text">Check if this field is required for form submission</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Field
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Field Information
                </h6>
            </div>
            <div class="card-body">
                <h6>Current Field Details</h6>
                <p class="small">
                    <strong>Field Name:</strong> <code><?= esc($field['field_name']) ?></code><br>
                    <strong>Field Label:</strong> <?= esc($field['field_label']) ?><br>
                    <strong>Field Type:</strong> <span class="badge bg-info"><?= esc($field['field_type']) ?></span><br>
                    <strong>Required:</strong> 
                    <?php if ($field['is_required']): ?>
                        <span class="badge bg-danger">Yes</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">No</span>
                    <?php endif; ?><br>
                    <strong>Order:</strong> <?= $field['field_order'] ?><br>
                    <strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($field['created_at'])) ?>
                </p>

                <hr>

                <h6>Field Types Guide</h6>
                <ul class="small">
                    <li><strong>Text Input:</strong> Single line text</li>
                    <li><strong>Email:</strong> Email validation</li>
                    <li><strong>Phone:</strong> Phone number input</li>
                    <li><strong>Number:</strong> Numeric input</li>
                    <li><strong>Date:</strong> Date picker</li>
                    <li><strong>Textarea:</strong> Multi-line text</li>
                    <li><strong>Dropdown:</strong> Select from options</li>
                    <li><strong>Radio:</strong> Single choice from options</li>
                    <li><strong>Checkbox:</strong> Multiple choices</li>
                    <li><strong>File:</strong> File upload</li>
                </ul>

                <hr>

                <h6>Validation Rules</h6>
                <p class="small text-muted">
                    Common rules: <code>required</code>, <code>min_length[3]</code>, 
                    <code>max_length[50]</code>, <code>valid_email</code>, 
                    <code>numeric</code>, <code>valid_date</code>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('field_type').addEventListener('change', function() {
    const optionsContainer = document.getElementById('field_options_container');
    const fieldType = this.value;
    
    if (['select', 'radio', 'checkbox'].includes(fieldType)) {
        optionsContainer.style.display = 'block';
    } else {
        optionsContainer.style.display = 'none';
    }
});

// Trigger change event on page load
document.getElementById('field_type').dispatchEvent(new Event('change'));
</script>
<?= $this->endSection() ?>
