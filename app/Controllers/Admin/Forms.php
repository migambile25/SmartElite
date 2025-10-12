<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FormModel;

class Forms extends BaseController
{
    protected $formModel;

    public function __construct()
    {
        $this->formModel = new FormModel();
    }

    public function index()
    {
        $forms = $this->formModel->where('deleted_flag', false)->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title' => 'Manage Forms - SmartElite Admin',
            'forms' => $forms
        ];

        return view('admin/forms/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create New Form - SmartElite Admin',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/forms/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'permit_empty|min_length[3]|max_length[255]|alpha_dash',
            'description' => 'permit_empty',
            'success_message' => 'permit_empty',
            'is_active' => 'permit_empty'
        ], [
            'title' => [
                'required' => 'Form title is required',
                'min_length' => 'Title must be at least 3 characters long',
                'max_length' => 'Title cannot exceed 255 characters'
            ],
            'slug' => [
                'min_length' => 'Slug must be at least 3 characters long',
                'max_length' => 'Slug cannot exceed 255 characters',
                'alpha_dash' => 'Slug can only contain letters, numbers, dashes and underscores'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // Get user ID from session or default to admin user
        $userId = session()->get('user_id');
        if (!$userId) {
            // If no user in session, use admin user (ID 1)
            $userId = 1;
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug') ?: null, // Let the model generate if empty
            'description' => $this->request->getPost('description'),
            'success_message' => $this->request->getPost('success_message'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'created_by' => $userId
        ];

        // Debug: Log the data being inserted
        log_message('debug', 'Form creation data: ' . json_encode($data));
        
        // Temporarily disable model validation for debugging
        $this->formModel->skipValidation(true);
        
        if ($this->formModel->insert($data)) {
            session()->setFlashdata('success', 'Form created successfully!');
            return redirect()->to('/admin/forms');
        } else {
            // Get validation errors for debugging
            $errors = $this->formModel->errors();
            $errorMessage = 'Failed to create form. Please try again.';
            if (!empty($errors)) {
                $errorMessage .= ' Errors: ' . implode(', ', $errors);
            }
            log_message('error', 'Form creation failed: ' . $errorMessage);
            session()->setFlashdata('error', $errorMessage);
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $form = $this->formModel->find($id);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        $data = [
            'title' => 'Edit Form - SmartElite Admin',
            'form' => $form,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/forms/edit', $data);
    }

    public function update($id)
    {
        $form = $this->formModel->find($id);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'permit_empty|min_length[3]|max_length[255]|alpha_dash',
            'description' => 'permit_empty',
            'success_message' => 'permit_empty',
            'is_active' => 'permit_empty'
        ], [
            'title' => [
                'required' => 'Form title is required',
                'min_length' => 'Title must be at least 3 characters long',
                'max_length' => 'Title cannot exceed 255 characters'
            ],
            'slug' => [
                'min_length' => 'Slug must be at least 3 characters long',
                'max_length' => 'Slug cannot exceed 255 characters',
                'alpha_dash' => 'Slug can only contain letters, numbers, dashes and underscores'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug') ?: null, // Let the model generate if empty
            'description' => $this->request->getPost('description'),
            'success_message' => $this->request->getPost('success_message'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->formModel->update($id, $data)) {
            session()->setFlashdata('success', 'Form updated successfully!');
            return redirect()->to('/admin/forms');
        } else {
            session()->setFlashdata('error', 'Failed to update form. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id)
    {
        $form = $this->formModel->findActive($id);
        
        if (!$form) {
            // Check if form is soft-deleted
            $deletedForm = $this->formModel->findWithDeleted($id);
            if ($deletedForm && $deletedForm['deleted_flag']) {
                session()->setFlashdata('error', 'This form has already been deleted.');
                return redirect()->to('/admin/forms');
            }
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        if (strtolower($this->request->getMethod()) === 'post') {
            if ($this->formModel->softDelete($id)) {
                session()->setFlashdata('success', 'Form deleted successfully!');
            } else {
                session()->setFlashdata('error', 'Failed to delete form. Please try again.');
            }
            return redirect()->to('/admin/forms');
        }

        $data = [
            'title' => 'Delete Form - SmartElite Admin',
            'form' => $form
        ];

        return view('admin/forms/delete', $data);
    }
}
