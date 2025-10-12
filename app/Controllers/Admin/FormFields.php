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

        $fields = $this->formFieldModel->getFieldsByFormId($formId);

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
            'field_name' => 'required|min_length[2]|max_length[255]|alpha_dash',
            'field_label' => 'required|min_length[2]|max_length[255]',
            'field_type' => 'required|in_list[text,email,tel,number,date,textarea,select,radio,checkbox,file]',
            'is_required' => 'permit_empty',
            'field_order' => 'permit_empty|integer'
        ], [
            'field_name' => [
                'required' => 'Field name is required',
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

        if ($this->formFieldModel->insert($data)) {
            session()->setFlashdata('success', 'Field created successfully!');
            return redirect()->to('/admin/forms/' . $formId . '/fields');
        } else {
            session()->setFlashdata('error', 'Failed to create field. Please try again.');
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
            'field_name' => 'required|min_length[2]|max_length[255]|alpha_dash',
            'field_label' => 'required|min_length[2]|max_length[255]',
            'field_type' => 'required|in_list[text,email,tel,number,date,textarea,select,radio,checkbox,file]',
            'is_required' => 'permit_empty',
            'field_order' => 'permit_empty|integer'
        ], [
            'field_name' => [
                'required' => 'Field name is required',
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
        $field = $this->formFieldModel->find($fieldId);
        
        if (!$form || !$field || $field['form_id'] != $formId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form or field not found');
        }

        if ($this->request->getMethod() === 'post') {
            if ($this->formFieldModel->delete($fieldId)) {
                session()->setFlashdata('success', 'Field deleted successfully!');
            } else {
                session()->setFlashdata('error', 'Failed to delete field. Please try again.');
            }
            return redirect()->to('/admin/forms/' . $formId . '/fields');
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
}
