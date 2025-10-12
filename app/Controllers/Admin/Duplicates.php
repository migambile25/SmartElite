<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\DuplicateDetectionService;
use App\Models\FormModel;

class Duplicates extends BaseController
{
    protected $duplicateDetectionService;
    protected $formModel;

    public function __construct()
    {
        $this->duplicateDetectionService = new DuplicateDetectionService();
        $this->formModel = new FormModel();
    }

    public function index()
    {
        $forms = $this->formModel->where('deleted_flag', false)->findAll();
        $formStats = [];

        foreach ($forms as $form) {
            $formStats[$form['id']] = [
                'form' => $form,
                'stats' => $this->duplicateDetectionService->getDuplicateStats($form['id'])
            ];
        }

        $data = [
            'title' => 'Duplicate Detection - SmartElite Admin',
            'forms' => $forms,
            'formStats' => $formStats,
            'showSidebar' => true
        ];

        return view('admin/duplicates/index', $data);
    }

    public function form($formId)
    {
        $form = $this->formModel->find($formId);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        $stats = $this->duplicateDetectionService->getDuplicateStats($formId);

        $data = [
            'title' => 'Duplicate Analysis - ' . $form['title'],
            'form' => $form,
            'stats' => $stats,
            'showSidebar' => true
        ];

        return view('admin/duplicates/form', $data);
    }
}
