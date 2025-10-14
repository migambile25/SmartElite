<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-plus-circle me-2"></i>Bulk Add Fields - <?= esc($form['title']) ?>
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
                    <i class="bi bi-plus-circle me-2"></i>Add Multiple Fields
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('admin/forms/' . $form['id'] . '/fields/bulk-store') ?>" id="bulkFieldsForm" onsubmit="return validateAndCleanForm()">
                    <?= csrf_field() ?>
                    
                    <div id="fields-container">
                        <!-- Field templates will be added here -->
                    </div>
                    
                    <div id="emptyFieldsWarning" class="alert alert-warning mt-3" style="display: none;">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Empty fields detected!</strong> You have some empty field templates. 
                        Either fill them out or remove them before submitting.
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <button type="button" class="btn btn-success" id="addFieldBtn">
                                <i class="bi bi-plus-circle me-2"></i>Add Another Field
                            </button>
                            <button type="button" class="btn btn-outline-info" id="addCommonFieldsBtn">
                                <i class="bi bi-lightning me-2"></i>Add Common Fields
                            </button>
                            <button type="button" class="btn btn-outline-warning" id="removeEmptyBtn" style="display: none;">
                                <i class="bi bi-trash me-2"></i>Remove Empty Fields
                            </button>
                        </div>
                        <div>
                            <a href="<?= base_url('admin/forms/' . $form['id'] . '/fields') ?>" class="btn btn-secondary me-2">
                                <i class="bi bi-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Create All Fields
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Quick Tips
                </h6>
            </div>
            <div class="card-body">
                <h6>Field Types</h6>
                <ul class="small">
                    <li><strong>Text:</strong> Single line text input</li>
                    <li><strong>Email:</strong> Email validation</li>
                    <li><strong>Phone:</strong> Phone number input</li>
                    <li><strong>Number:</strong> Numeric input</li>
                    <li><strong>Date:</strong> Date picker</li>
                    <li><strong>Textarea:</strong> Multi-line text</li>
                    <li><strong>Dropdown:</strong> Select from options</li>
                    <li><strong>Radio:</strong> Single choice</li>
                    <li><strong>Checkbox:</strong> Multiple choices</li>
                </ul>

                <hr>

                <h6>Common Field Sets</h6>
                <p class="small text-muted">
                    Use "Add Common Fields" to quickly add standard form fields like personal information, contact details, etc.
                </p>

                <hr>

                <h6>Field Options</h6>
                <p class="small text-muted">
                    For dropdown, radio, and checkbox fields, enter one option per line in the options field.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Field Template (Hidden) -->
<template id="field-template">
    <div class="field-item card mb-3" data-field-index="">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <i class="bi bi-grip-vertical me-2 text-muted"></i>
                Field <span class="field-number">1</span>
            </h6>
            <button type="button" class="btn btn-sm btn-outline-danger remove-field">
                <i class="bi bi-trash"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Field Name <small class="text-muted">(Optional)</small></label>
                        <input type="text" 
                               class="form-control field-name" 
                               name="fields[INDEX][field_name]" 
                               placeholder="Auto-generated from label">
                        <div class="form-text">
                            <span class="field-name-preview text-muted">Will be auto-generated from the field label</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Field Label <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control field-label" 
                               name="fields[INDEX][field_label]" 
                               placeholder="e.g., First Name"
                               required>
                        <div class="form-text">Display label shown to users</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Placeholder <small class="text-muted">(Optional)</small></label>
                        <input type="text"
                               class="form-control field-placeholder"
                               name="fields[INDEX][placeholder]"
                               placeholder="e.g., Enter your first name">
                        <div class="form-text">Shown inside input before user types</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Field Type <span class="text-danger">*</span></label>
                        <select class="form-select field-type" name="fields[INDEX][field_type]" required>
                            <option value="">Select field type...</option>
                            <option value="text">Text Input</option>
                            <option value="email">Email</option>
                            <option value="tel">Phone Number</option>
                            <option value="number">Number</option>
                            <option value="date">Date</option>
                            <option value="textarea">Textarea</option>
                            <option value="select">Dropdown</option>
                            <option value="radio">Radio Buttons</option>
                            <option value="checkbox">Checkboxes</option>
                            <option value="file">File Upload</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Field Order</label>
                        <input type="number" 
                               class="form-control field-order" 
                               name="fields[INDEX][field_order]" 
                               value="0"
                               min="0">
                        <div class="form-text">Order in which field appears (0 = auto-assign)</div>
                    </div>
                </div>
            </div>

            <div class="mb-3 field-options-container" style="display: none;">
                <label class="form-label">Field Options</label>
                <textarea class="form-control field-options" 
                          name="fields[INDEX][field_options]" 
                          rows="3"
                          placeholder="Enter options, one per line"></textarea>
                <div class="form-text">For dropdown, radio, or checkbox fields. Enter one option per line.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Validation Rules</label>
                <input type="text" 
                       class="form-control field-validation" 
                       name="fields[INDEX][validation_rules]" 
                       placeholder="e.g., min_length[3]|max_length[50]">
                <div class="form-text">CodeIgniter validation rules (optional)</div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input field-required" 
                           type="checkbox" 
                           name="fields[INDEX][is_required]" 
                           value="1">
                    <label class="form-check-label">
                        Required Field
                    </label>
                </div>
                <div class="form-text">Check if this field is required for form submission</div>
            </div>
        </div>
    </div>
</template>

<style>
.field-item {
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.field-item:hover {
    border-color: var(--smartelite-primary);
    box-shadow: 0 2px 8px rgba(30, 58, 138, 0.1);
}

.field-item .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-bottom: 1px solid #e5e7eb;
}

.remove-field {
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.remove-field:hover {
    opacity: 1;
}

#addFieldBtn, #addCommonFieldsBtn {
    transition: all 0.3s ease;
}

#addFieldBtn:hover, #addCommonFieldsBtn:hover {
    transform: translateY(-1px);
}
</style>

<script>
let fieldIndex = 0;

// Common field templates
const commonFields = [
    {
        label: 'First Name',
        type: 'text',
        required: true,
        validation: 'min_length[2]|max_length[50]'
    },
    {
        label: 'Last Name',
        type: 'text',
        required: true,
        validation: 'min_length[2]|max_length[50]'
    },
    {
        label: 'Email Address',
        type: 'email',
        required: true,
        validation: 'valid_email'
    },
    {
        label: 'Phone Number',
        type: 'tel',
        required: true,
        validation: 'regex_match[/^[\+]?[1-9][\d]{0,15}$/]'
    },
    {
        label: 'Date of Birth',
        type: 'date',
        required: true,
        validation: 'valid_date'
    },
    {
        label: 'Address',
        type: 'textarea',
        required: false,
        validation: 'max_length[500]'
    }
];

document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('fields-container');
    const addFieldBtn = document.getElementById('addFieldBtn');
    const addCommonFieldsBtn = document.getElementById('addCommonFieldsBtn');
    
    // Add first field
    addField();
    
    // Add field button
    addFieldBtn.addEventListener('click', addField);
    
    // Add common fields button
    addCommonFieldsBtn.addEventListener('click', addCommonFields);
    
    // Remove field functionality
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-field')) {
            e.target.closest('.field-item').remove();
            updateFieldNumbers();
            checkForEmptyFields();
        }
    });
    
    // Field type change handler
    container.addEventListener('change', function(e) {
        if (e.target.classList.contains('field-type')) {
            toggleFieldOptions(e.target);
        }
    });
    
    // Field label change handler for auto-generating field names
    container.addEventListener('input', function(e) {
        if (e.target.classList.contains('field-label')) {
            updateFieldNamePreview(e.target);
        }
        checkForEmptyFields();
    });
    
    // Remove empty fields button
    document.getElementById('removeEmptyBtn').addEventListener('click', function() {
        removeEmptyFields();
    });
});

function addField() {
    const template = document.getElementById('field-template');
    const clone = template.content.cloneNode(true);
    
    // Update field index
    const fieldItem = clone.querySelector('.field-item');
    fieldItem.setAttribute('data-field-index', fieldIndex);
    
    // Update field number
    clone.querySelector('.field-number').textContent = fieldIndex + 1;
    
    // Update all input names and IDs
    clone.querySelectorAll('input, select, textarea').forEach(input => {
        const name = input.getAttribute('name');
        if (name) {
            input.setAttribute('name', name.replace('INDEX', fieldIndex));
        }
    });
    
    // Add to container
    document.getElementById('fields-container').appendChild(clone);
    
    fieldIndex++;
    checkForEmptyFields();
}

function addCommonFields() {
    commonFields.forEach((field, index) => {
        addField();
        
        const lastField = document.querySelector('.field-item:last-child');
        // Don't set field name - let it be auto-generated
        lastField.querySelector('.field-label').value = field.label;
        lastField.querySelector('.field-type').value = field.type;
        lastField.querySelector('.field-validation').value = field.validation;
        lastField.querySelector('.field-required').checked = field.required;
        
        // Trigger field name preview update
        updateFieldNamePreview(lastField.querySelector('.field-label'));
        
        // Trigger field type change to show/hide options
        toggleFieldOptions(lastField.querySelector('.field-type'));
    });
}

function toggleFieldOptions(selectElement) {
    const fieldItem = selectElement.closest('.field-item');
    const optionsContainer = fieldItem.querySelector('.field-options-container');
    const fieldType = selectElement.value;
    
    if (['select', 'radio', 'checkbox'].includes(fieldType)) {
        optionsContainer.style.display = 'block';
    } else {
        optionsContainer.style.display = 'none';
    }
}

function updateFieldNumbers() {
    document.querySelectorAll('.field-item').forEach((item, index) => {
        item.querySelector('.field-number').textContent = index + 1;
    });
}

function updateFieldNamePreview(labelInput) {
    const fieldItem = labelInput.closest('.field-item');
    const fieldNameInput = fieldItem.querySelector('.field-name');
    const preview = fieldItem.querySelector('.field-name-preview');
    const label = labelInput.value;
    
    if (label && !fieldNameInput.value) {
        // Generate field name from label
        const fieldName = label.toLowerCase()
            .replace(/[^a-z0-9\s]/g, '')
            .replace(/\s+/g, '_')
            .trim();
        
        preview.textContent = `Will be: ${fieldName}`;
        preview.className = 'field-name-preview text-success';
    } else if (!label) {
        preview.textContent = 'Will be auto-generated from the field label';
        preview.className = 'field-name-preview text-muted';
    }
}

function validateAndCleanForm() {
    const fields = document.querySelectorAll('.field-item');
    let hasValidFields = false;
    let emptyFields = [];
    let incompleteFields = [];
    
    fields.forEach((field, index) => {
        const label = field.querySelector('.field-label').value.trim();
        const type = field.querySelector('.field-type').value;
        
        if (label && type) {
            hasValidFields = true;
        } else if (!label && !type) {
            // Completely empty field - mark for removal
            emptyFields.push(field);
        } else if (!label || !type) {
            // Partially filled field - mark for error
            incompleteFields.push({field, index: index + 1, label, type});
        }
    });
    
    // Show errors for incomplete fields
    if (incompleteFields.length > 0) {
        const errorMsg = incompleteFields.map(f => 
            `Field ${f.index}: ${!f.label ? 'Missing label' : 'Missing type'}`
        ).join('\n');
        alert(`Please complete the following fields:\n\n${errorMsg}\n\nOr remove them if not needed.`);
        return false;
    }
    
    if (!hasValidFields) {
        alert('Please add at least one complete field with both label and type.');
        return false;
    }
    
    // Remove empty fields before submission
    emptyFields.forEach(field => {
        field.remove();
    });
    
    // Update field numbers after removal
    updateFieldNumbers();
    
    return true;
}

function checkForEmptyFields() {
    const fields = document.querySelectorAll('.field-item');
    let hasEmptyFields = false;
    
    fields.forEach(field => {
        const label = field.querySelector('.field-label').value.trim();
        const type = field.querySelector('.field-type').value;
        
        if (!label && !type) {
            hasEmptyFields = true;
        }
    });
    
    const warning = document.getElementById('emptyFieldsWarning');
    const removeBtn = document.getElementById('removeEmptyBtn');
    
    if (hasEmptyFields) {
        warning.style.display = 'block';
        removeBtn.style.display = 'inline-block';
    } else {
        warning.style.display = 'none';
        removeBtn.style.display = 'none';
    }
}

function removeEmptyFields() {
    const fields = document.querySelectorAll('.field-item');
    let removedCount = 0;
    
    fields.forEach(field => {
        const label = field.querySelector('.field-label').value.trim();
        const type = field.querySelector('.field-type').value;
        
        if (!label && !type) {
            field.remove();
            removedCount++;
        }
    });
    
    updateFieldNumbers();
    checkForEmptyFields();
    
    if (removedCount > 0) {
        // Show a brief success message
        const btn = document.getElementById('removeEmptyBtn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check me-2"></i>Removed!';
        btn.className = 'btn btn-success';
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.className = 'btn btn-outline-warning';
        }, 2000);
    }
}
</script>
<?= $this->endSection() ?>
