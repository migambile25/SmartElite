<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FormModel;
use App\Models\FormSubmissionModel;

class Submissions extends BaseController
{
    protected $formModel;
    protected $formSubmissionModel;

    public function __construct()
    {
        $this->formModel = new FormModel();
        $this->formSubmissionModel = new FormSubmissionModel();
    }

    public function index($formId)
    {
        $form = $this->formModel->findActive($formId);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        $submissions = $this->formSubmissionModel->getSubmissionsByFormId($formId);
        $stats = $this->formSubmissionModel->getSubmissionStats($formId);

        $data = [
            'title' => 'Submissions - ' . $form['title'],
            'form' => $form,
            'submissions' => $submissions,
            'stats' => $stats,
            'showSidebar' => true
        ];

        return view('admin/submissions/index', $data);
    }

    public function view($formId, $submissionId)
    {
        $form = $this->formModel->findActive($formId);
        $submission = $this->formSubmissionModel->getSubmissionWithForm($submissionId);
        
        if (!$form || !$submission || $submission['form_id'] != $formId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form or submission not found');
        }

        $data = [
            'title' => 'View Submission - ' . $form['title'],
            'form' => $form,
            'submission' => $submission,
            'showSidebar' => true
        ];

        return view('admin/submissions/view', $data);
    }

    public function export($formId)
    {
        $form = $this->formModel->findActive($formId);
        
        if (!$form) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form not found');
        }

        $submissions = $this->formSubmissionModel->getSubmissionsByFormId($formId);
        $csv = $this->formSubmissionModel->exportToCSV($formId, $submissions);

        $filename = 'smartelite_submissions_' . $form['slug'] . '_' . date('Y-m-d') . '.csv';

        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($csv);
    }

    public function delete($formId, $submissionId)
    {
        $form = $this->formModel->findActive($formId);
        $submission = $this->formSubmissionModel->findActive($submissionId);
        
        if (!$form || !$submission || $submission['form_id'] != $formId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Form or submission not found');
        }

        if (strtolower($this->request->getMethod()) === 'post') {
            if ($this->formSubmissionModel->softDelete($submissionId)) {
                session()->setFlashdata('success', 'Submission deleted successfully!');
            } else {
                session()->setFlashdata('error', 'Failed to delete submission. Please try again.');
            }
            return redirect()->to('/admin/forms/' . $formId . '/submissions');
        }

        $data = [
            'title' => 'Delete Submission - ' . $form['title'],
            'form' => $form,
            'submission' => $submission,
            'showSidebar' => true
        ];

        return view('admin/submissions/delete', $data);
    }
}
