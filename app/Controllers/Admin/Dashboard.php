<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FormModel;
use App\Models\FormSubmissionModel;

class Dashboard extends BaseController
{
    protected $formModel;
    protected $formSubmissionModel;

    public function __construct()
    {
        $this->formModel = new FormModel();
        $this->formSubmissionModel = new FormSubmissionModel();
    }

    public function index()
    {
        // Get dashboard statistics
        $totalForms = $this->formModel->countAllResults();
        $activeForms = $this->formModel->where('is_active', true)->countAllResults();
        $totalSubmissions = $this->formSubmissionModel->countAllResults();
        
        // Get recent submissions (configurable limit)
        $submissionLimit = (int)($this->request->getGet('limit') ?: 10); // Default to 10, allow override via URL
        $submissionLimit = min($submissionLimit, 50); // Cap at 50 for performance
        
        $recentSubmissions = $this->formSubmissionModel
            ->select('form_submissions.*, forms.title as form_title')
            ->join('forms', 'forms.id = form_submissions.form_id')
            ->where('form_submissions.deleted_flag', false) // Only show non-deleted submissions
            ->orderBy('submitted_at', 'DESC')
            ->limit($submissionLimit)
            ->findAll();

        // Get forms with submission counts
        $formsWithStats = $this->formModel
            ->select('forms.*, COUNT(form_submissions.id) as submission_count')
            ->join('form_submissions', 'form_submissions.form_id = forms.id', 'left')
            ->groupBy('forms.id')
            ->orderBy('forms.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Dashboard - SmartElite Admin',
            'totalForms' => $totalForms,
            'activeForms' => $activeForms,
            'totalSubmissions' => $totalSubmissions,
            'recentSubmissions' => $recentSubmissions,
            'formsWithStats' => $formsWithStats,
            'submissionLimit' => $submissionLimit
        ];

        return view('admin/dashboard/index', $data);
    }
}
