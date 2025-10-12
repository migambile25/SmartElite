<?php

namespace App\Models;

use CodeIgniter\Model;

class FormSubmissionModel extends Model
{
    protected $table = 'form_submissions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'form_id',
        'submission_data',
        'ip_address',
        'user_agent',
        'submitted_at',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = false; // We use submitted_at instead
    protected $dateFormat = 'datetime';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'form_id' => 'required|integer',
        'submission_data' => 'required',
        'ip_address' => 'permit_empty|valid_ip',
        'user_agent' => 'permit_empty',
        'submitted_at' => 'permit_empty'
    ];

    protected $validationMessages = [
        'form_id' => [
            'required' => 'Form ID is required',
            'integer' => 'Form ID must be a valid integer'
        ],
        'submission_data' => [
            'required' => 'Submission data is required'
        ],
        'ip_address' => [
            'valid_ip' => 'Please provide a valid IP address'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['processSubmissionData', 'setSubmissionTime'];
    protected $beforeUpdate = ['processSubmissionData'];

    protected function processSubmissionData(array $data)
    {
        if (isset($data['data']['submission_data']) && is_array($data['data']['submission_data'])) {
            $data['data']['submission_data'] = json_encode($data['data']['submission_data']);
        }
        return $data;
    }

    protected function setSubmissionTime(array $data)
    {
        if (!isset($data['data']['submitted_at'])) {
            $data['data']['submitted_at'] = date('Y-m-d H:i:s');
        }
        return $data;
    }

    public function getSubmissionsByFormId($formId, $limit = null, $offset = 0)
    {
        $builder = $this->where('form_id', $formId)
                       ->orderBy('submitted_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        $submissions = $builder->findAll();
        
        // Decode JSON data for each submission
        foreach ($submissions as &$submission) {
            $submission['submission_data'] = json_decode($submission['submission_data'], true);
        }
        
        return $submissions;
    }

    public function getSubmissionWithForm($submissionId)
    {
        $submission = $this->find($submissionId);
        if (!$submission) {
            return null;
        }

        $formModel = new FormModel();
        $submission['form'] = $formModel->find($submission['form_id']);
        $submission['submission_data'] = json_decode($submission['submission_data'], true);

        return $submission;
    }

    public function getSubmissionStats($formId)
    {
        $total = $this->where('form_id', $formId)->countAllResults();
        
        $today = $this->where('form_id', $formId)
                     ->where('DATE(submitted_at)', date('Y-m-d'))
                     ->countAllResults();
        
        $thisWeek = $this->where('form_id', $formId)
                        ->where('submitted_at >=', date('Y-m-d', strtotime('monday this week')))
                        ->countAllResults();
        
        $thisMonth = $this->where('form_id', $formId)
                         ->where('MONTH(submitted_at)', date('m'))
                         ->where('YEAR(submitted_at)', date('Y'))
                         ->countAllResults();

        return [
            'total' => $total,
            'today' => $today,
            'this_week' => $thisWeek,
            'this_month' => $thisMonth
        ];
    }

    public function exportToCSV($formId, $submissions = null)
    {
        if ($submissions === null) {
            $submissions = $this->getSubmissionsByFormId($formId);
        }

        if (empty($submissions)) {
            return '';
        }

        $formModel = new FormModel();
        $form = $formModel->getFormWithFields($formId);
        
        // Create CSV header
        $headers = ['ID', 'Submitted At', 'IP Address'];
        foreach ($form['fields'] as $field) {
            $headers[] = $field['field_label'];
        }
        
        $csv = implode(',', array_map(function($header) {
            return '"' . str_replace('"', '""', $header) . '"';
        }, $headers)) . "\n";
        
        // Add data rows
        foreach ($submissions as $submission) {
            $row = [
                $submission['id'],
                $submission['submitted_at'],
                $submission['ip_address']
            ];
            
            foreach ($form['fields'] as $field) {
                $value = $submission['submission_data'][$field['field_name']] ?? '';
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }
                $row[] = $value;
            }
            
            $csv .= implode(',', array_map(function($cell) {
                return '"' . str_replace('"', '""', $cell) . '"';
            }, $row)) . "\n";
        }
        
        return $csv;
    }
}
