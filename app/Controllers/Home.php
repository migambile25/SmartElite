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

        $data = [
            'primaryForm' => $primaryForm
        ];

        return view('welcome_message', $data);
    }
}
