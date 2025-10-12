<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h1 class="h2 mb-2">
                        <i class="bi bi-lightning-charge-fill me-2"></i><?= esc($form['title']) ?>
                    </h1>
                    <?php if (!empty($form['description'])): ?>
                        <p class="mb-0 opacity-75"><?= esc($form['description']) ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="card-body p-5">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success text-center">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php else: ?>
                        <form method="POST" action="<?= base_url('register/' . $form['slug']) ?>" novalidate>
                            <?= csrf_field() ?>
                            
                            <?php foreach ($form['fields'] as $field): ?>
                                <div class="mb-4">
                                    <label for="<?= esc($field['field_name']) ?>" class="form-label">
                                        <?= esc($field['field_label']) ?>
                                        <?php if ($field['is_required']): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    
                                    <?php
                                    $fieldValue = old($field['field_name']);
                                    $fieldOptions = !empty($field['field_options']) ? json_decode($field['field_options'], true) : [];
                                    $hasError = $validation->hasError($field['field_name']);
                                    $errorClass = $hasError ? 'is-invalid' : '';
                                    ?>
                                    
                                    <?php switch ($field['field_type']): 
                                        case 'text': ?>
                                            <input type="text" 
                                                   class="form-control <?= $errorClass ?>" 
                                                   id="<?= esc($field['field_name']) ?>" 
                                                   name="<?= esc($field['field_name']) ?>" 
                                                   value="<?= esc($fieldValue) ?>"
                                                   <?= $field['is_required'] ? 'required' : '' ?>>
                                            <?php break; ?>
                                            
                                        <?php case 'email': ?>
                                            <input type="email" 
                                                   class="form-control <?= $errorClass ?>" 
                                                   id="<?= esc($field['field_name']) ?>" 
                                                   name="<?= esc($field['field_name']) ?>" 
                                                   value="<?= esc($fieldValue) ?>"
                                                   <?= $field['is_required'] ? 'required' : '' ?>>
                                            <?php break; ?>
                                            
                                        <?php case 'tel': ?>
                                            <input type="tel" 
                                                   class="form-control <?= $errorClass ?>" 
                                                   id="<?= esc($field['field_name']) ?>" 
                                                   name="<?= esc($field['field_name']) ?>" 
                                                   value="<?= esc($fieldValue) ?>"
                                                   <?= $field['is_required'] ? 'required' : '' ?>>
                                            <?php break; ?>
                                            
                                        <?php case 'number': ?>
                                            <input type="number" 
                                                   class="form-control <?= $errorClass ?>" 
                                                   id="<?= esc($field['field_name']) ?>" 
                                                   name="<?= esc($field['field_name']) ?>" 
                                                   value="<?= esc($fieldValue) ?>"
                                                   <?= $field['is_required'] ? 'required' : '' ?>>
                                            <?php break; ?>
                                            
                                        <?php case 'date': ?>
                                            <input type="date" 
                                                   class="form-control <?= $errorClass ?>" 
                                                   id="<?= esc($field['field_name']) ?>" 
                                                   name="<?= esc($field['field_name']) ?>" 
                                                   value="<?= esc($fieldValue) ?>"
                                                   <?= $field['is_required'] ? 'required' : '' ?>>
                                            <?php break; ?>
                                            
                                        <?php case 'textarea': ?>
                                            <textarea class="form-control <?= $errorClass ?>" 
                                                      id="<?= esc($field['field_name']) ?>" 
                                                      name="<?= esc($field['field_name']) ?>" 
                                                      rows="4"
                                                      <?= $field['is_required'] ? 'required' : '' ?>><?= esc($fieldValue) ?></textarea>
                                            <?php break; ?>
                                            
                                        <?php case 'select': ?>
                                            <select class="form-select <?= $errorClass ?>" 
                                                    id="<?= esc($field['field_name']) ?>" 
                                                    name="<?= esc($field['field_name']) ?>"
                                                    <?= $field['is_required'] ? 'required' : '' ?>>
                                                <option value="">Choose an option...</option>
                                                <?php foreach ($fieldOptions as $option): ?>
                                                    <option value="<?= esc($option) ?>" 
                                                            <?= $fieldValue === $option ? 'selected' : '' ?>>
                                                        <?= esc($option) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php break; ?>
                                            
                                        <?php case 'radio': ?>
                                            <div class="form-check-group">
                                                <?php foreach ($fieldOptions as $index => $option): ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" 
                                                               type="radio" 
                                                               id="<?= esc($field['field_name'] . '_' . $index) ?>" 
                                                               name="<?= esc($field['field_name']) ?>" 
                                                               value="<?= esc($option) ?>"
                                                               <?= $fieldValue === $option ? 'checked' : '' ?>
                                                               <?= $field['is_required'] ? 'required' : '' ?>>
                                                        <label class="form-check-label" for="<?= esc($field['field_name'] . '_' . $index) ?>">
                                                            <?= esc($option) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php break; ?>
                                            
                                        <?php case 'checkbox': ?>
                                            <div class="form-check-group">
                                                <?php 
                                                $checkboxValues = is_array($fieldValue) ? $fieldValue : [];
                                                foreach ($fieldOptions as $index => $option): ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               id="<?= esc($field['field_name'] . '_' . $index) ?>" 
                                                               name="<?= esc($field['field_name']) ?>[]" 
                                                               value="<?= esc($option) ?>"
                                                               <?= in_array($option, $checkboxValues) ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="<?= esc($field['field_name'] . '_' . $index) ?>">
                                                            <?= esc($option) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php break; ?>
                                            
                                        <?php case 'file': ?>
                                            <input type="file" 
                                                   class="form-control <?= $errorClass ?>" 
                                                   id="<?= esc($field['field_name']) ?>" 
                                                   name="<?= esc($field['field_name']) ?>"
                                                   <?= $field['is_required'] ? 'required' : '' ?>>
                                            <?php break; ?>
                                    <?php endswitch; ?>
                                    
                                    <?php if ($hasError): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError($field['field_name']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-send me-2"></i>Submit Registration
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
                
                <div class="card-footer text-center text-muted py-3">
                    <small>
                        <i class="bi bi-shield-check me-1"></i>
                        Your information is secure and will only be used for registration purposes.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --smartelite-primary: #1e3a8a;
    --smartelite-secondary: #3b82f6;
    --smartelite-accent: #06b6d4;
    --smartelite-success: #10b981;
    --smartelite-warning: #f59e0b;
    --smartelite-danger: #ef4444;
    --smartelite-dark: #1f2937;
    --smartelite-light: #f8fafc;
    --smartelite-gray: #6b7280;
}

.form-check-group .form-check {
    margin-bottom: 0.5rem;
}

.form-check-group .form-check:last-child {
    margin-bottom: 0;
}

.card {
    border-radius: 1.5rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.card-header {
    border-radius: 1.5rem 1.5rem 0 0 !important;
    background: linear-gradient(135deg, var(--smartelite-primary) 0%, var(--smartelite-secondary) 100%);
    border: none;
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 0.75rem;
}

.btn-primary {
    background-color: var(--smartelite-primary);
    border-color: var(--smartelite-primary);
}

.btn-primary:hover {
    background-color: var(--smartelite-secondary);
    border-color: var(--smartelite-secondary);
    transform: translateY(-1px);
}

.alert {
    border-radius: 1rem;
    border: none;
}

.form-control:focus {
    border-color: var(--smartelite-primary);
    box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
}

.form-select:focus {
    border-color: var(--smartelite-primary);
    box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
}

.form-check-input:checked {
    background-color: var(--smartelite-primary);
    border-color: var(--smartelite-primary);
}

.form-check-input:focus {
    border-color: var(--smartelite-primary);
    box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
}

.text-danger {
    color: var(--smartelite-danger) !important;
}

.card-footer {
    background-color: var(--smartelite-light);
    border-top: 1px solid #e5e7eb;
    border-radius: 0 0 1.5rem 1.5rem !important;
}
</style>
<?= $this->endSection() ?>
