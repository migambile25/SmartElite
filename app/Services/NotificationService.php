<?php

namespace App\Services;

use App\Config\Notifications;
use CodeIgniter\HTTP\CURLRequest;
use CodeIgniter\HTTP\ResponseInterface;

class NotificationService
{
    protected $config;
    protected $client;
    protected $logger;

    public function __construct()
    {
        $this->config = new Notifications();
        $this->client = \Config\Services::curlrequest();
        $this->logger = \Config\Services::logger();
        
        // Load environment variables
        $this->loadEnvironmentConfig();
    }

    /**
     * Load configuration from environment variables
     */
    private function loadEnvironmentConfig()
    {
        $this->config->brevo['api_key'] = isset($_ENV['BREVO_API_KEY']) ? $_ENV['BREVO_API_KEY'] : '';
        $this->config->brevo['sender_email'] = isset($_ENV['BREVO_SENDER_EMAIL']) ? $_ENV['BREVO_SENDER_EMAIL'] : 'noreply@smartelite.tz';
        $this->config->brevo['reply_to'] = isset($_ENV['BREVO_REPLY_TO']) ? $_ENV['BREVO_REPLY_TO'] : 'support@smartelite.tz';
        
        $this->config->textify['api_key'] = isset($_ENV['TEXTIFY_API_KEY']) ? $_ENV['TEXTIFY_API_KEY'] : '';
        $this->config->textify['sender_id'] = isset($_ENV['TEXTIFY_SENDER_ID']) ? $_ENV['TEXTIFY_SENDER_ID'] : 'SmartElite';
        
        $this->config->settings['admin_notification_email'] = isset($_ENV['ADMIN_NOTIFICATION_EMAIL']) ? $_ENV['ADMIN_NOTIFICATION_EMAIL'] : 'admin@smartelite.tz';
        $this->config->settings['admin_notification_sms'] = isset($_ENV['ADMIN_NOTIFICATION_SMS']) ? $_ENV['ADMIN_NOTIFICATION_SMS'] : '+255123456789';
    }

    /**
     * Send email notification using Brevo API
     */
    public function sendEmail(array $to, string $subject, string $htmlContent, ?string $textContent = null): bool
    {
        if (!$this->config->settings['send_email_notifications']) {
            $this->logger->info('Email notifications disabled');
            return true;
        }

        if (empty($this->config->brevo['api_key'])) {
            $this->logger->error('Brevo API key not configured');
            return false;
        }

        try {
            $payload = [
                'sender' => [
                    'name' => $this->config->brevo['sender_name'],
                    'email' => $this->config->brevo['sender_email']
                ],
                'to' => $to,
                'subject' => $subject,
                'htmlContent' => $htmlContent,
                'textContent' => $textContent ?: strip_tags($htmlContent),
                'replyTo' => [
                    'email' => $this->config->brevo['reply_to'],
                    'name' => $this->config->brevo['sender_name']
                ]
            ];

            $response = $this->client->post($this->config->brevo['api_url'] . '/smtp/email', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'api-key' => $this->config->brevo['api_key']
                ],
                'json' => $payload,
                'timeout' => 30
            ]);

            if ($response->getStatusCode() === 201) {
                $this->logger->info('Email sent successfully via Brevo', ['to' => $to, 'subject' => $subject]);
                return true;
            } else {
                $this->logger->error('Failed to send email via Brevo', [
                    'status' => $response->getStatusCode(),
                    'response' => $response->getBody()
                ]);
                return false;
            }

        } catch (\Exception $e) {
            $this->logger->error('Exception sending email via Brevo', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Send SMS notification using Textify API
     */
    public function sendSMS(string $phoneNumber, string $message): bool
    {
        if (!$this->config->settings['send_sms_notifications']) {
            $this->logger->info('SMS notifications disabled');
            return true;
        }

        if (empty($this->config->textify['api_key'])) {
            $this->logger->error('Textify API key not configured');
            return false;
        }

        try {
            // Clean phone number (remove spaces, add country code if needed)
            $phoneNumber = $this->cleanPhoneNumber($phoneNumber);

            $payload = [
                'to' => $phoneNumber,
                'message' => $message,
                'sender_id' => $this->config->textify['sender_id']
            ];

            $response = $this->client->post($this->config->textify['api_url'] . '/sms/send', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->config->textify['api_key']
                ],
                'json' => $payload,
                'timeout' => 30
            ]);

            if ($response->getStatusCode() === 200) {
                $this->logger->info('SMS sent successfully via Textify', ['to' => $phoneNumber]);
                return true;
            } else {
                $this->logger->error('Failed to send SMS via Textify', [
                    'status' => $response->getStatusCode(),
                    'response' => $response->getBody()
                ]);
                return false;
            }

        } catch (\Exception $e) {
            $this->logger->error('Exception sending SMS via Textify', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Send form submission confirmation to user
     */
    public function sendFormSubmissionConfirmation(array $formData, array $submissionData): bool
    {
        $email = isset($submissionData['email']) ? $submissionData['email'] : null;
        $phone = isset($submissionData['phone']) ? $submissionData['phone'] : null;

        $success = true;

        // Send email confirmation
        if ($email) {
            $subject = "Application Received - {$formData['title']}";
            $htmlContent = $this->generateEmailTemplate($formData, $submissionData);
            
            $emailSent = $this->sendEmail(
                [['email' => $email, 'name' => isset($submissionData['first_name']) ? $submissionData['first_name'] : 'Applicant']],
                $subject,
                $htmlContent
            );
            
            if (!$emailSent) {
                $success = false;
            }
        }

        // Send SMS confirmation
        if ($phone) {
            $message = $this->generateSMSTemplate($formData, $submissionData);
            $smsSent = $this->sendSMS($phone, $message);
            
            if (!$smsSent) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Send admin notification about new form submission
     */
    public function sendAdminNotification(array $formData, array $submissionData): bool
    {
        $email = $this->config->settings['admin_notification_email'];
        $phone = $this->config->settings['admin_notification_sms'];

        $success = true;

        // Send email to admin
        if ($email) {
            $subject = "New Form Submission - {$formData['title']}";
            $htmlContent = $this->generateAdminEmailTemplate($formData, $submissionData);
            
            $emailSent = $this->sendEmail(
                [['email' => $email, 'name' => 'SmartElite Admin']],
                $subject,
                $htmlContent
            );
            
            if (!$emailSent) {
                $success = false;
            }
        }

        // Send SMS to admin
        if ($phone) {
            $firstName = isset($submissionData['first_name']) ? $submissionData['first_name'] : 'Unknown';
            $message = "New SmartElite form submission: {$formData['title']} from {$firstName}";
            $smsSent = $this->sendSMS($phone, $message);
            
            if (!$smsSent) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Generate HTML email template for user confirmation
     */
    private function generateEmailTemplate(array $formData, array $submissionData): string
    {
        $name = isset($submissionData['first_name']) ? $submissionData['first_name'] : 'Applicant';
        $formTitle = $formData['title'];
        $successMessage = isset($formData['success_message']) ? $formData['success_message'] : 'Thank you for your application. We will review it and contact you soon.';

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Application Confirmation</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #1e3a8a; color: white; padding: 20px; text-align: center; }
                .content { padding: 30px 20px; background: #f8fafc; }
                .footer { padding: 20px; text-align: center; color: #666; font-size: 14px; }
                .success-icon { font-size: 48px; color: #10b981; margin-bottom: 20px; }
                .btn { display: inline-block; padding: 12px 24px; background: #1e3a8a; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>SmartElite Initiative</h1>
                </div>
                <div class='content'>
                    <div style='text-align: center;'>
                        <div class='success-icon'>✓</div>
                        <h2>Application Received Successfully!</h2>
                    </div>
                    <p>Dear {$name},</p>
                    <p>Thank you for submitting your application for <strong>{$formTitle}</strong>.</p>
                    <p>{$successMessage}</p>
                    <p>We will contact you within 5-7 business days with further instructions.</p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='" . base_url('/') . "' class='btn'>Visit SmartElite</a>
                    </div>
                </div>
                <div class='footer'>
                    <p>SmartElite Initiative - Bridging the gap between higher education and digital inclusion in Tanzania</p>
                    <p>This is an automated message. Please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Generate SMS template for user confirmation
     */
    private function generateSMSTemplate(array $formData, array $submissionData): string
    {
        $name = isset($submissionData['first_name']) ? $submissionData['first_name'] : 'Applicant';
        $formTitle = $formData['title'];
        
        return "Hi {$name}! Your {$formTitle} application has been received. We'll contact you within 5-7 business days. - SmartElite Initiative";
    }

    /**
     * Generate HTML email template for admin notification
     */
    private function generateAdminEmailTemplate(array $formData, array $submissionData): string
    {
        $submissionDetails = '';
        foreach ($submissionData as $field => $value) {
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            $submissionDetails .= "<tr><td><strong>" . ucfirst(str_replace('_', ' ', $field)) . ":</strong></td><td>" . htmlspecialchars($value) . "</td></tr>";
        }

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>New Form Submission</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #dc2626; color: white; padding: 20px; text-align: center; }
                .content { padding: 30px 20px; background: #f8fafc; }
                .submission-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                .submission-table td { padding: 10px; border-bottom: 1px solid #e5e7eb; }
                .submission-table tr:nth-child(even) { background: #f9fafb; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>New Form Submission</h1>
                </div>
                <div class='content'>
                    <h2>Form: {$formData['title']}</h2>
                    <p>A new form submission has been received and requires your attention.</p>
                    <h3>Submission Details:</h3>
                    <table class='submission-table'>
                        {$submissionDetails}
                    </table>
                    <p><strong>Submitted:</strong> " . date('Y-m-d H:i:s') . "</p>
                    <p><strong>IP Address:</strong> " . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'Unknown') . "</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Clean and format phone number
     */
    private function cleanPhoneNumber(string $phoneNumber): string
    {
        // Remove all non-numeric characters except +
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);
        
        // If it doesn't start with +, assume it's a Tanzanian number and add +255
        if (!str_starts_with($phoneNumber, '+')) {
            // Remove leading 0 if present
            if (str_starts_with($phoneNumber, '0')) {
                $phoneNumber = substr($phoneNumber, 1);
            }
            $phoneNumber = '+255' . $phoneNumber;
        }
        
        return $phoneNumber;
    }

    /**
     * Test email configuration
     */
    public function testEmailConfiguration(): array
    {
        $result = [
            'api_key_configured' => !empty($this->config->brevo['api_key']),
            'sender_email_configured' => !empty($this->config->brevo['sender_email']),
            'test_sent' => false,
            'error' => null
        ];

        if ($result['api_key_configured'] && $result['sender_email_configured']) {
            try {
                $testEmail = $this->sendEmail(
                    [['email' => $this->config->settings['admin_notification_email'], 'name' => 'Test']],
                    'SmartElite Email Test',
                    '<h1>Email Test Successful</h1><p>Your Brevo email configuration is working correctly.</p>'
                );
                $result['test_sent'] = $testEmail;
            } catch (\Exception $e) {
                $result['error'] = $e->getMessage();
            }
        }

        return $result;
    }

    /**
     * Test SMS configuration
     */
    public function testSMSConfiguration(): array
    {
        $result = [
            'api_key_configured' => !empty($this->config->textify['api_key']),
            'sender_id_configured' => !empty($this->config->textify['sender_id']),
            'test_sent' => false,
            'error' => null
        ];

        if ($result['api_key_configured'] && $result['sender_id_configured']) {
            try {
                $testSMS = $this->sendSMS(
                    $this->config->settings['admin_notification_sms'],
                    'SmartElite SMS Test - Configuration working correctly!'
                );
                $result['test_sent'] = $testSMS;
            } catch (\Exception $e) {
                $result['error'] = $e->getMessage();
            }
        }

        return $result;
    }
}
