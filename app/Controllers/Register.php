<?php

namespace App\Controllers;

use App\Models\FormModel;
use App\Models\FormSubmissionModel;
use App\Services\NotificationService;
use App\Services\DuplicateDetectionService;
use App\Services\RateLimitService;
use CodeIgniter\Controller;

class Register extends Controller
{
    protected $formModel;
    protected $formSubmissionModel;
    protected $notificationService;
    protected $duplicateDetectionService;
    protected $rateLimitService;

    public function __construct()
    {
        $this->formModel = new FormModel();
        $this->formSubmissionModel = new FormSubmissionModel();
        $this->notificationService = new NotificationService();
        $this->duplicateDetectionService = new DuplicateDetectionService();
        $this->rateLimitService = new RateLimitService();
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
        // Log the submission attempt
        log_message('debug', 'FORM SUBMISSION START - slug: ' . $slug);
        log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));
        
        $form = $this->formModel->getFormBySlug($slug);
        
        if (!$form) {
            log_message('error', 'Form not found for slug: ' . $slug);
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }
        
        log_message('debug', 'Form found: ' . json_encode($form));

        // Check rate limiting
        $ip = $this->request->getIPAddress();
        if ($this->rateLimitService->isRateLimited($ip, $slug)) {
            $timeUntilReset = $this->rateLimitService->getTimeUntilReset($ip, $slug);
            $minutes = ceil($timeUntilReset / 60);
            
            log_message('warning', "Rate limit exceeded for IP {$ip} on form {$slug}");
            $this->session->setFlashdata('error', "Too many submissions. Please try again in {$minutes} minutes.");
            return redirect()->back()->withInput();
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
            log_message('debug', 'Validation failed: ' . json_encode($validation->getErrors()));
            return redirect()->back()->withInput()->with('validation', $validation);
        }
        
        log_message('debug', 'Validation passed for form submission');

        // Check for suspicious activity
        $userAgent = $this->request->getUserAgent()->getAgentString();
        $preliminaryData = $this->request->getPost();
        
        if ($this->rateLimitService->isSuspiciousSubmission($preliminaryData, $userAgent)) {
            $this->rateLimitService->logSuspiciousActivity($ip, 'Suspicious submission pattern detected', [
                'form_slug' => $slug,
                'user_agent' => $userAgent,
                'ip' => $ip
            ]);
            
            log_message('warning', "Suspicious submission blocked from IP {$ip} on form {$slug}");
            $this->session->setFlashdata('error', 'Submission blocked due to suspicious activity.');
            return redirect()->back()->withInput();
        }

        // Record this attempt
        $this->rateLimitService->recordAttempt($ip, $slug);

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

        // Check for duplicates before saving
        try {
            $duplicateCheck = $this->duplicateDetectionService->checkForDuplicates($form['id'], $submissionData);
            
            if ($duplicateCheck['is_duplicate']) {
                $this->session->setFlashdata('error', $duplicateCheck['message']);
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            // Log the error but don't block submission
            log_message('error', 'Duplicate detection failed: ' . $e->getMessage());
        }

        // Save submission
        $submission = [
            'form_id' => $form['id'],
            'submission_data' => $submissionData,
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'submitted_at' => date('Y-m-d H:i:s')
        ];

        // Debug: Log submission data
        log_message('debug', 'Attempting to save submission: ' . json_encode($submission));
        
        if ($this->formSubmissionModel->insert($submission)) {
            log_message('debug', 'Submission saved successfully');
            
            // Send notifications
            try {
                // Send confirmation to user
                $this->notificationService->sendFormSubmissionConfirmation($form, $submissionData);
                
                // Send notification to admin
                $this->notificationService->sendAdminNotification($form, $submissionData);
                
                log_message('debug', 'Notifications sent successfully');
            } catch (\Exception $e) {
                // Log the error but don't block the success redirect
                log_message('error', 'Notification sending failed: ' . $e->getMessage());
            }

            // Redirect to success page with form data
            return redirect()->to('/register/' . $slug . '/success');
        } else {
            // Log model errors
            $errors = $this->formSubmissionModel->errors();
            log_message('error', 'Failed to save submission. Model errors: ' . json_encode($errors));
            log_message('error', 'Submission data that failed: ' . json_encode($submission));
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
