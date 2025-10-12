<?php

namespace App\Services;

use App\Models\FormSubmissionModel;
use CodeIgniter\HTTP\ResponseInterface;

class DuplicateDetectionService
{
    protected $formSubmissionModel;
    protected $logger;

    public function __construct()
    {
        $this->formSubmissionModel = new FormSubmissionModel();
        $this->logger = \Config\Services::logger();
    }

    /**
     * Check if submission data contains duplicates for the given form
     */
    public function checkForDuplicates(int $formId, array $submissionData): array
    {
        $duplicates = [];
        $uniqueFields = $this->getUniqueFields($submissionData);

        if (empty($uniqueFields)) {
            return $duplicates;
        }

        // Get all existing submissions for this form
        $existingSubmissions = $this->formSubmissionModel->where('form_id', $formId)
                                                       ->where('deleted_flag', false)
                                                       ->findAll();

        foreach ($existingSubmissions as $existingSubmission) {
            $existingData = $this->decodeSubmissionData($existingSubmission['submission_data']);
            
            foreach ($uniqueFields as $field => $value) {
                if (isset($existingData[$field]) && $this->isValueMatch($value, $existingData[$field])) {
                    $duplicates[] = [
                        'field' => $field,
                        'value' => $value,
                        'submission_id' => $existingSubmission['id'],
                        'submitted_at' => $existingSubmission['submitted_at']
                    ];
                }
            }
        }

        return $duplicates;
    }

    /**
     * Get fields that should be checked for uniqueness
     */
    private function getUniqueFields(array $submissionData): array
    {
        $uniqueFields = [];
        
        // Define which fields should be unique
        $uniqueFieldNames = [
            'email',
            'phone',
            'mobile',
            'phone_number',
            'student_id',
            'registration_number',
            'national_id',
            'passport_number',
            'nida_number',
            'index_number',
            'application_number'
        ];

        foreach ($uniqueFieldNames as $fieldName) {
            if (isset($submissionData[$fieldName]) && !empty($submissionData[$fieldName])) {
                $uniqueFields[$fieldName] = $this->normalizeValue($submissionData[$fieldName]);
            }
        }

        // Also check for combination of first_name + last_name + email (if available)
        if (isset($submissionData['first_name']) && isset($submissionData['last_name']) && isset($submissionData['email'])) {
            $fullName = trim($submissionData['first_name'] . ' ' . $submissionData['last_name']);
            if (!empty($fullName) && !empty($submissionData['email'])) {
                $uniqueFields['full_name_email'] = [
                    'name' => strtolower($fullName),
                    'email' => strtolower(trim($submissionData['email']))
                ];
            }
        }

        return $uniqueFields;
    }

    /**
     * Normalize value for comparison
     */
    private function normalizeValue($value): string
    {
        if (is_array($value)) {
            $value = implode(', ', $value);
        }
        
        // Convert to lowercase and trim whitespace
        $normalized = strtolower(trim($value));
        
        // For phone numbers, remove all non-numeric characters except +
        if (preg_match('/^[\+]?[0-9\s\-\(\)]+$/', $value)) {
            $normalized = preg_replace('/[^0-9+]/', '', $normalized);
            // Remove leading 0 and add +255 for Tanzanian numbers
            if (str_starts_with($normalized, '0')) {
                $normalized = '+255' . substr($normalized, 1);
            } elseif (!str_starts_with($normalized, '+')) {
                $normalized = '+255' . $normalized;
            }
        }
        
        return $normalized;
    }

    /**
     * Check if two values match (considering normalization)
     */
    private function isValueMatch($value1, $value2): bool
    {
        $normalized1 = $this->normalizeValue($value1);
        $normalized2 = $this->normalizeValue($value2);
        
        return $normalized1 === $normalized2;
    }

    /**
     * Check for full name + email combination duplicates
     */
    private function checkNameEmailDuplicate(array $submissionData, array $existingData): bool
    {
        if (!isset($submissionData['first_name']) || !isset($submissionData['last_name']) || !isset($submissionData['email'])) {
            return false;
        }

        if (!isset($existingData['first_name']) || !isset($existingData['last_name']) || !isset($existingData['email'])) {
            return false;
        }

        $submissionName = strtolower(trim($submissionData['first_name'] . ' ' . $submissionData['last_name']));
        $submissionEmail = strtolower(trim($submissionData['email']));
        
        $existingName = strtolower(trim($existingData['first_name'] . ' ' . $existingData['last_name']));
        $existingEmail = strtolower(trim($existingData['email']));

        return $submissionName === $existingName && $submissionEmail === $existingEmail;
    }

    /**
     * Decode submission data from JSON
     */
    private function decodeSubmissionData($submissionData)
    {
        if (is_string($submissionData)) {
            $decoded = json_decode($submissionData, true);
            return $decoded ?: [];
        }
        
        return is_array($submissionData) ? $submissionData : [];
    }

    /**
     * Generate user-friendly duplicate error message
     */
    public function generateDuplicateMessage(array $duplicates): string
    {
        if (empty($duplicates)) {
            return '';
        }

        $messages = [];
        
        foreach ($duplicates as $duplicate) {
            $field = $duplicate['field'];
            $value = $duplicate['value'];
            $submittedAt = date('M j, Y g:i A', strtotime($duplicate['submitted_at']));
            
            switch ($field) {
                case 'email':
                    $messages[] = "An application with email '{$value}' was already submitted on {$submittedAt}.";
                    break;
                case 'phone':
                case 'mobile':
                case 'phone_number':
                    $messages[] = "An application with phone number '{$value}' was already submitted on {$submittedAt}.";
                    break;
                case 'student_id':
                case 'registration_number':
                case 'index_number':
                case 'application_number':
                    $messages[] = "An application with {$field} '{$value}' was already submitted on {$submittedAt}.";
                    break;
                case 'national_id':
                case 'nida_number':
                case 'passport_number':
                    $messages[] = "An application with {$field} '{$value}' was already submitted on {$submittedAt}.";
                    break;
                case 'full_name_email':
                    $messages[] = "An application with the same name and email was already submitted on {$submittedAt}.";
                    break;
                default:
                    $messages[] = "An application with {$field} '{$value}' was already submitted on {$submittedAt}.";
            }
        }

        return implode(' ', $messages);
    }

    /**
     * Get duplicate statistics for admin
     */
    public function getDuplicateStats(int $formId): array
    {
        $submissions = $this->formSubmissionModel->where('form_id', $formId)
                                               ->where('deleted_flag', false)
                                               ->findAll();

        $stats = [
            'total_submissions' => count($submissions),
            'unique_emails' => 0,
            'unique_phones' => 0,
            'duplicate_emails' => 0,
            'duplicate_phones' => 0,
            'duplicate_names' => 0
        ];

        $emails = [];
        $phones = [];
        $nameEmails = [];

        foreach ($submissions as $submission) {
            $data = $this->decodeSubmissionData($submission['submission_data']);
            
            // Check emails
            if (isset($data['email']) && !empty($data['email'])) {
                $email = $this->normalizeValue($data['email']);
                if (in_array($email, $emails)) {
                    $stats['duplicate_emails']++;
                } else {
                    $emails[] = $email;
                    $stats['unique_emails']++;
                }
            }
            
            // Check phones
            if (isset($data['phone']) && !empty($data['phone'])) {
                $phone = $this->normalizeValue($data['phone']);
                if (in_array($phone, $phones)) {
                    $stats['duplicate_phones']++;
                } else {
                    $phones[] = $phone;
                    $stats['unique_phones']++;
                }
            }
            
            // Check name + email combinations
            if (isset($data['first_name']) && isset($data['last_name']) && isset($data['email'])) {
                $nameEmail = strtolower(trim($data['first_name'] . ' ' . $data['last_name'])) . '|' . strtolower(trim($data['email']));
                if (in_array($nameEmail, $nameEmails)) {
                    $stats['duplicate_names']++;
                } else {
                    $nameEmails[] = $nameEmail;
                }
            }
        }

        return $stats;
    }

    /**
     * Check if a specific field value already exists
     */
    public function fieldValueExists(int $formId, string $fieldName, $value): bool
    {
        $submissions = $this->formSubmissionModel->where('form_id', $formId)
                                               ->where('deleted_flag', false)
                                               ->findAll();

        $normalizedValue = $this->normalizeValue($value);

        foreach ($submissions as $submission) {
            $data = $this->decodeSubmissionData($submission['submission_data']);
            
            if (isset($data[$fieldName]) && $this->isValueMatch($value, $data[$fieldName])) {
                return true;
            }
        }

        return false;
    }
}
