<?php

namespace App\Controllers;

use App\Models\FormModel;
use App\Models\FormSubmissionModel;
use CodeIgniter\Controller;

class Register extends Controller
{
    protected $formModel;
    protected $formSubmissionModel;

    public function __construct()
    {
        $this->formModel = new FormModel();
        $this->formSubmissionModel = new FormSubmissionModel();
    }

    public function index($slug)
    {
        $form = $this->formModel->getFormBySlug($slug);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        $data = [
            'title' => $form['title'] . ' - SmartElite Registration',
            'form' => $form,
            'validation' => \Config\Services::validation()
        ];

        return view('register/form', $data);
    }

    public function submit($slug)
    {
        $form = $this->formModel->getFormBySlug($slug);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        // Build validation rules dynamically based on form fields
        $validationRules = [];
        $validationMessages = [];

        foreach ($form['fields'] as $field) {
            $rules = [];
            $messages = [];

            if ($field['is_required']) {
                $rules[] = 'required';
                $messages['required'] = $field['field_label'] . ' is required';
            }

            // Add field-specific validation
            switch ($field['field_type']) {
                case 'email':
                    $rules[] = 'valid_email';
                    $messages['valid_email'] = 'Please enter a valid email address';
                    break;
                case 'tel':
                    $rules[] = 'regex_match[/^[\+]?[1-9][\d]{0,15}$/]';
                    $messages['regex_match'] = 'Please enter a valid phone number';
                    break;
                case 'number':
                    $rules[] = 'numeric';
                    $messages['numeric'] = 'Please enter a valid number';
                    break;
                case 'date':
                    $rules[] = 'valid_date';
                    $messages['valid_date'] = 'Please enter a valid date';
                    break;
            }

            // Add custom validation rules if specified
            if (!empty($field['validation_rules'])) {
                $customRules = explode('|', $field['validation_rules']);
                $rules = array_merge($rules, $customRules);
            }

            if (!empty($rules)) {
                $validationRules[$field['field_name']] = implode('|', $rules);
                $validationMessages[$field['field_name']] = $messages;
            }
        }

        $validation = \Config\Services::validation();
        $validation->setRules($validationRules, $validationMessages);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // Prepare submission data
        $submissionData = [];
        foreach ($form['fields'] as $field) {
            $value = $this->request->getPost($field['field_name']);
            
            // Handle different field types
            switch ($field['field_type']) {
                case 'checkbox':
                    $submissionData[$field['field_name']] = is_array($value) ? $value : [];
                    break;
                case 'file':
                    // Handle file uploads if needed
                    $submissionData[$field['field_name']] = $value;
                    break;
                default:
                    $submissionData[$field['field_name']] = $value;
                    break;
            }
        }

        // Save submission
        $submission = [
            'form_id' => $form['id'],
            'submission_data' => $submissionData,
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'submitted_at' => date('Y-m-d H:i:s')
        ];

        if ($this->formSubmissionModel->insert($submission)) {
            // Redirect to success page with form data
            return redirect()->to('/register/' . $slug . '/success');
        } else {
            $this->session->setFlashdata('error', 'There was an error submitting your form. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function success($slug)
    {
        $form = $this->formModel->getFormBySlug($slug);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        $data = [
            'title' => 'Application Submitted - SmartElite',
            'form' => $form
        ];

        return view('register/success', $data);
    }
}
