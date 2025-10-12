<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\NotificationService;

class Notifications extends BaseController
{
    protected $notificationService;

    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }

    public function index()
    {
        $data = [
            'title' => 'Notification Settings - SmartElite Admin',
            'showSidebar' => true
        ];

        return view('admin/notifications/index', $data);
    }

    public function testEmail()
    {
        if ($this->request->getMethod() === 'post') {
            $result = $this->notificationService->testEmailConfiguration();
            
            if ($result['test_sent']) {
                session()->setFlashdata('success', 'Test email sent successfully! Check your inbox.');
            } else {
                $error = $result['error'] ?? 'Failed to send test email. Please check your configuration.';
                session()->setFlashdata('error', 'Test email failed: ' . $error);
            }
        }

        return redirect()->to('/admin/notifications');
    }

    public function testSMS()
    {
        if ($this->request->getMethod() === 'post') {
            $result = $this->notificationService->testSMSConfiguration();
            
            if ($result['test_sent']) {
                session()->setFlashdata('success', 'Test SMS sent successfully! Check your phone.');
            } else {
                $error = $result['error'] ?? 'Failed to send test SMS. Please check your configuration.';
                session()->setFlashdata('error', 'Test SMS failed: ' . $error);
            }
        }

        return redirect()->to('/admin/notifications');
    }

    public function sendTestNotification()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $phone = $this->request->getPost('phone');
            $message = $this->request->getPost('message') ?: 'This is a test notification from SmartElite.';

            $results = [];

            // Send test email
            if ($email) {
                $emailSent = $this->notificationService->sendEmail(
                    [['email' => $email, 'name' => 'Test User']],
                    'SmartElite Test Notification',
                    '<h1>Test Notification</h1><p>' . htmlspecialchars($message) . '</p>'
                );
                $results['email'] = $emailSent;
            }

            // Send test SMS
            if ($phone) {
                $smsSent = $this->notificationService->sendSMS($phone, $message);
                $results['sms'] = $smsSent;
            }

            if (empty($results)) {
                session()->setFlashdata('error', 'Please provide at least an email or phone number.');
            } else {
                $successCount = array_sum($results);
                $totalCount = count($results);
                
                if ($successCount === $totalCount) {
                    session()->setFlashdata('success', 'All test notifications sent successfully!');
                } else {
                    session()->setFlashdata('warning', "Sent {$successCount} out of {$totalCount} notifications.");
                }
            }
        }

        return redirect()->to('/admin/notifications');
    }
}
