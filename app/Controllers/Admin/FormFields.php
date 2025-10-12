<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FormModel;
use App\Models\FormFieldModel;

class FormFields extends BaseController
{
    protected $formModel;
    protected $formFieldModel;

    public function __construct()
    {
        $this->formModel = new FormModel();
        $this->formFieldModel = new FormFieldModel();
    }

    public function index($formId)
    {
        $form = $this->formModel->find($formId);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        // Get both active and deleted fields for admin view
        $activeFields = $this->formFieldModel->where('form_id', $formId)
                                           ->where('deleted_flag', false)
                                           ->orderBy('field_order', 'ASC')
                                           ->findAll();
        
        $deletedFields = $this->formFieldModel->where('form_id', $formId)
                                            ->where('deleted_flag', true)
                                            ->orderBy('field_order', 'ASC')
                                            ->findAll();
        
        $fields = array_merge($activeFields, $deletedFields);

        $data = [
            'title' => 'Manage Fields - ' . $form['title'],
            'form' => $form,
            'fields' => $fields,
            'showSidebar' => true
        ];

        return view('admin/fields/index', $data);
    }

    public function create($formId)
    {
        $form = $this->formModel->find($formId);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        $data = [
            'title' => 'Add Field - ' . $form['title'],
            'form' => $form,
            'validation' => \Config\Services::validation(),
            'showSidebar' => true
        ];

        return view('admin/fields/create', $data);
    }

    public function store($formId)
    {
        $form = $this->formModel->find($formId);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'field_name' => 'permit_empty|min_length[2]|max_length[255]|alpha_dash',
            'field_label' => 'required|min_length[2]|max_length[255]',
            'field_type' => 'required|in_list[text,email,tel,number,date,textarea,select,radio,checkbox,file]',
            'is_required' => 'permit_empty',
            'field_order' => 'permit_empty|integer'
        ], [
            'field_name' => [
                'min_length' => 'Field name must be at least 2 characters long',
                'max_length' => 'Field name cannot exceed 255 characters',
                'alpha_dash' => 'Field name can only contain letters, numbers, dashes and underscores'
            ],
            'field_label' => [
                'required' => 'Field label is required',
                'min_length' => 'Field label must be at least 2 characters long',
                'max_length' => 'Field label cannot exceed 255 characters'
            ],
            'field_type' => [
                'required' => 'Field type is required',
                'in_list' => 'Field type must be one of: text, email, tel, number, date, textarea, select, radio, checkbox, file'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $data = [
            'form_id' => $formId,
            'field_name' => $this->request->getPost('field_name'),
            'field_label' => $this->request->getPost('field_label'),
            'field_type' => $this->request->getPost('field_type'),
            'field_options' => $this->request->getPost('field_options'),
            'is_required' => $this->request->getPost('is_required') ? 1 : 0,
            'field_order' => $this->request->getPost('field_order') ?: 0,
            'validation_rules' => $this->request->getPost('validation_rules')
        ];

        // Debug: Log the data being inserted
        log_message('debug', 'Single field creation data: ' . json_encode($data));

        if ($this->formFieldModel->insert($data)) {
            session()->setFlashdata('success', 'Field created successfully!');
            return redirect()->to('/admin/forms/' . $formId . '/fields');
        } else {
            // Get model validation errors for debugging
            $errors = $this->formFieldModel->errors();
            $errorMessage = 'Failed to create field. Please try again.';
            if (!empty($errors)) {
                $errorMessage .= ' Errors: ' . implode(', ', $errors);
            }
            log_message('error', 'Single field creation failed: ' . $errorMessage);
            session()->setFlashdata('error', $errorMessage);
            return redirect()->back()->withInput();
        }
    }

    public function edit($formId, $fieldId)
    {
        $form = $this->formModel->find($formId);
        $field = $this->formFieldModel->find($fieldId);
        
        if (!$form || !$field || $field['form_id'] != $formId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form or field not found');
        }

        $data = [
            'title' => 'Edit Field - ' . $form['title'],
            'form' => $form,
            'field' => $field,
            'validation' => \Config\Services::validation(),
            'showSidebar' => true
        ];

        return view('admin/fields/edit', $data);
    }

    public function update($formId, $fieldId)
    {
        $form = $this->formModel->find($formId);
        $field = $this->formFieldModel->find($fieldId);
        
        if (!$form || !$field || $field['form_id'] != $formId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form or field not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'field_name' => 'permit_empty|min_length[2]|max_length[255]|alpha_dash',
            'field_label' => 'required|min_length[2]|max_length[255]',
            'field_type' => 'required|in_list[text,email,tel,number,date,textarea,select,radio,checkbox,file]',
            'is_required' => 'permit_empty',
            'field_order' => 'permit_empty|integer'
        ], [
            'field_name' => [
                'min_length' => 'Field name must be at least 2 characters long',
                'max_length' => 'Field name cannot exceed 255 characters',
                'alpha_dash' => 'Field name can only contain letters, numbers, dashes and underscores'
            ],
            'field_label' => [
                'required' => 'Field label is required',
                'min_length' => 'Field label must be at least 2 characters long',
                'max_length' => 'Field label cannot exceed 255 characters'
            ],
            'field_type' => [
                'required' => 'Field type is required',
                'in_list' => 'Field type must be one of: text, email, tel, number, date, textarea, select, radio, checkbox, file'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $data = [
            'field_name' => $this->request->getPost('field_name'),
            'field_label' => $this->request->getPost('field_label'),
            'field_type' => $this->request->getPost('field_type'),
            'field_options' => $this->request->getPost('field_options'),
            'is_required' => $this->request->getPost('is_required') ? 1 : 0,
            'field_order' => $this->request->getPost('field_order') ?: 0,
            'validation_rules' => $this->request->getPost('validation_rules')
        ];

        if ($this->formFieldModel->update($fieldId, $data)) {
            session()->setFlashdata('success', 'Field updated successfully!');
            return redirect()->to('/admin/forms/' . $formId . '/fields');
        } else {
            session()->setFlashdata('error', 'Failed to update field. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function delete($formId, $fieldId)
    {
        $form = $this->formModel->find($formId);
        $field = $this->formFieldModel->findActive($fieldId);
        
        // If field not found, check if it's soft-deleted
        if (!$field) {
            $deletedField = $this->formFieldModel->findWithDeleted($fieldId);
            if ($deletedField && $deletedField['deleted_flag']) {
                session()->setFlashdata('error', 'This field has already been deleted.');
                return redirect()->to('/admin/forms/' . $formId . '/fields');
            }
        }
        
        if (!$form || !$field || $field['form_id'] != $formId || ($field['deleted_flag'] ?? false)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form or field not found');
        }
        
        if (strtolower($this->request->getMethod()) === 'post') {
            // Debug: Log the deletion attempt
            log_message('debug', 'POST method detected, attempting to delete field ID: ' . $fieldId . ' from form ID: ' . $formId);
            
            $deleteResult = $this->formFieldModel->softDelete($fieldId);
            log_message('debug', 'Delete result: ' . ($deleteResult ? 'true' : 'false'));
            
            if ($deleteResult) {
                log_message('debug', 'Field soft deleted successfully');
                session()->setFlashdata('success', 'Field deleted successfully!');
                log_message('debug', 'Redirecting to fields list');
                return redirect()->to('/admin/forms/' . $formId . '/fields');
            } else {
                // Get model errors for debugging
                $errors = $this->formFieldModel->errors();
                $errorMessage = 'Failed to delete field. Please try again.';
                if (!empty($errors)) {
                    $errorMessage .= ' Errors: ' . implode(', ', $errors);
                }
                log_message('error', 'Field deletion failed: ' . $errorMessage);
                session()->setFlashdata('error', $errorMessage);
                log_message('debug', 'Redirecting back to fields list with error');
                return redirect()->to('/admin/forms/' . $formId . '/fields');
            }
        } else {
            log_message('debug', 'Not a POST method, showing delete confirmation page');
        }

        $data = [
            'title' => 'Delete Field - ' . $form['title'],
            'form' => $form,
            'field' => $field,
            'showSidebar' => true
        ];

        return view('admin/fields/delete', $data);
    }

    public function reorder($formId)
    {
        $form = $this->formModel->find($formId);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        $fieldOrders = $this->request->getPost('field_orders');
        
        if ($fieldOrders && is_array($fieldOrders)) {
            if ($this->formFieldModel->reorderFields($formId, $fieldOrders)) {
                session()->setFlashdata('success', 'Field order updated successfully!');
            } else {
                session()->setFlashdata('error', 'Failed to update field order. Please try again.');
            }
        }

        return redirect()->to('/admin/forms/' . $formId . '/fields');
    }

    public function bulkCreate($formId)
    {
        $form = $this->formModel->find($formId);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        $data = [
            'title' => 'Bulk Add Fields - ' . $form['title'],
            'form' => $form,
            'validation' => \Config\Services::validation(),
            'showSidebar' => true
        ];

        return view('admin/fields/bulk_create', $data);
    }

    public function bulkStore($formId)
    {
        $form = $this->formModel->find($formId);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        $fields = $this->request->getPost('fields');
        
        if (empty($fields) || !is_array($fields)) {
            session()->setFlashdata('error', 'No fields provided.');
            return redirect()->back();
        }

        // Filter out empty fields (fields without labels)
        $validFields = [];
        foreach ($fields as $index => $field) {
            if (!empty(trim($field['field_label'] ?? ''))) {
                $validFields[] = $field;
            }
        }
        
        // Debug: Log the fields being processed
        log_message('debug', 'Total fields received: ' . count($fields));
        log_message('debug', 'Valid fields after filtering: ' . count($validFields));
        log_message('debug', 'Raw fields data: ' . json_encode($fields));

        if (empty($validFields)) {
            session()->setFlashdata('error', 'Please provide at least one field with a label.');
            return redirect()->back();
        }

        $validation = \Config\Services::validation();
        $errors = [];
        $successCount = 0;

        foreach ($validFields as $index => $field) {
            // Debug: Log each field being validated
            log_message('debug', 'Validating field ' . ($index + 1) . ': ' . json_encode($field));
            
            $validation->setRules([
                'field_name' => 'permit_empty|min_length[2]|max_length[255]|alpha_dash',
                'field_label' => 'required|min_length[2]|max_length[255]',
                'field_type' => 'required|in_list[text,email,tel,number,date,textarea,select,radio,checkbox,file]',
                'is_required' => 'permit_empty',
                'field_order' => 'permit_empty|integer'
            ], [
                'field_name' => [
                    'min_length' => "Field name must be at least 2 characters long for field " . ($index + 1),
                    'max_length' => "Field name cannot exceed 255 characters for field " . ($index + 1),
                    'alpha_dash' => "Field name can only contain letters, numbers, dashes and underscores for field " . ($index + 1)
                ],
                'field_label' => [
                    'required' => "Field label is required for field " . ($index + 1),
                    'min_length' => "Field label must be at least 2 characters long for field " . ($index + 1),
                    'max_length' => "Field label cannot exceed 255 characters for field " . ($index + 1)
                ],
                'field_type' => [
                    'required' => "Field type is required for field " . ($index + 1),
                    'in_list' => "Field type must be one of: text, email, tel, number, date, textarea, select, radio, checkbox, file for field " . ($index + 1)
                ]
            ]);

            // Validate the individual field data
            if (!$validation->run($field)) {
                $fieldErrors = $validation->getErrors();
                $errors = array_merge($errors, $fieldErrors);
            }
        }

        if (!empty($errors)) {
            session()->setFlashdata('error', 'Validation errors: ' . implode(', ', $errors));
            return redirect()->back()->withInput();
        }

        // Process each valid field
        foreach ($validFields as $field) {
            $data = [
                'form_id' => $formId,
                'field_name' => $field['field_name'],
                'field_label' => $field['field_label'],
                'field_type' => $field['field_type'],
                'field_options' => $field['field_options'] ?? null,
                'is_required' => isset($field['is_required']) ? 1 : 0,
                'field_order' => $field['field_order'] ?? 0,
                'validation_rules' => $field['validation_rules'] ?? null
            ];

            if ($this->formFieldModel->insert($data)) {
                $successCount++;
            }
        }

        if ($successCount > 0) {
            session()->setFlashdata('success', "Successfully created {$successCount} field(s)!");
        } else {
            session()->setFlashdata('error', 'Failed to create any fields. Please try again.');
        }

        return redirect()->to('/admin/forms/' . $formId . '/fields');
    }

    public function restore($formId, $fieldId)
    {
        $form = $this->formModel->findActive($formId);
        $field = $this->formFieldModel->findWithDeleted($fieldId);
        
        if (!$form || !$field || $field['form_id'] != $formId || !$field['deleted_flag']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form or field not found');
        }

        if (strtolower($this->request->getMethod()) === 'post') {
            if ($this->formFieldModel->restore($fieldId)) {
                session()->setFlashdata('success', 'Field restored successfully!');
            } else {
                session()->setFlashdata('error', 'Failed to restore field. Please try again.');
            }
            return redirect()->to('/admin/forms/' . $formId . '/fields');
        }

        $data = [
            'title' => 'Restore Field - ' . $form['title'],
            'form' => $form,
            'field' => $field,
            'showSidebar' => true
        ];

        return view('admin/fields/restore', $data);
    }

    public function permanentDelete($formId, $fieldId)
    {
        $form = $this->formModel->findActive($formId);
        $field = $this->formFieldModel->findWithDeleted($fieldId);
        
        if (!$form || !$field || $field['form_id'] != $formId || !$field['deleted_flag']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form or field not found');
        }

        if (strtolower($this->request->getMethod()) === 'post') {
            if ($this->formFieldModel->delete($fieldId, true)) { // Force delete
                session()->setFlashdata('success', 'Field permanently deleted!');
            } else {
                session()->setFlashdata('error', 'Failed to permanently delete field. Please try again.');
            }
            return redirect()->to('/admin/forms/' . $formId . '/fields');
        }

        $data = [
            'title' => 'Permanently Delete Field - ' . $form['title'],
            'form' => $form,
            'field' => $field,
            'showSidebar' => true
        ];

        return view('admin/fields/permanent_delete', $data);
    }
}
