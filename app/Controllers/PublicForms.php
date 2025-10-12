<?php

namespace App\Controllers;

use App\Models\FormModel;
use CodeIgniter\Controller;

class PublicForms extends Controller
{
    protected $formModel;

    public function __construct()
    {
        $this->formModel = new FormModel();
    }

    public function index()
    {
        // Get all active forms
        $forms = $this->formModel->where('deleted_flag', false)
                                ->where('is_active', true)
                                ->orderBy('created_at', 'DESC')
                                ->findAll();

        $data = [
            'title' => 'Available Forms - SmartElite Initiative',
            'forms' => $forms
        ];

        return view('public/forms_gallery', $data);
    }
}
