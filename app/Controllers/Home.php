<?php

namespace App\Controllers;

use App\Models\FormModel;

class Home extends BaseController
{
    protected $formModel;

    public function __construct()
    {
        $this->formModel = new FormModel();
    }

    public function index(): string
    {
        // Get the primary form using the new method
        $primaryForm = $this->formModel->getPrimaryForm();
        
        // Count active, non-deleted forms to decide whether to show multi-form CTAs
        $formsCount = $this->formModel
            ->where('deleted_flag', false)
            ->where('is_active', true)
            ->countAllResults();

        $data = [
            'primaryForm' => $primaryForm,
            'formsCount' => $formsCount,
        ];

        return view('welcome_message', $data);
    }
}
