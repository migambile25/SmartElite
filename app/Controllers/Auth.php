<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
    }

    public function login()
    {
        // If already logged in, redirect to admin dashboard
        if ($this->session->get('user_id')) {
            return redirect()->to('/admin');
        }

        $data = [
            'title' => 'Admin Login - SmartElite',
            'validation' => \Config\Services::validation()
        ];

        return view('auth/login', $data);
    }

    public function authenticate()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username' => [
                'required' => 'Username or email is required'
            ],
            'password' => [
                'required' => 'Password is required'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->authenticate($username, $password);

        if ($user) {
            // Set session data
            $this->session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'user_role' => $user['role']
            ]);

            $this->session->setFlashdata('success', 'Welcome back, ' . $user['username'] . '!');
            return redirect()->to('/admin');
        } else {
            $this->session->setFlashdata('error', 'Invalid username/email or password.');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        $this->session->destroy();
        $this->session->setFlashdata('success', 'You have been logged out successfully.');
        return redirect()->to('/admin/login');
    }
}
