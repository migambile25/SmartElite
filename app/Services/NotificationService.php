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
            // Normalize phone number and sender ID to Textify/E.164 requirements
            $phoneNumber = $this->cleanPhoneNumber($phoneNumber);
            $senderId = $this->normalizeSenderId($this->config->textify['sender_id']);

            if ($phoneNumber === '') {
                $this->logger->error('SMS not sent: invalid phone number after normalization');
                return false;
            }

            $payload = [
                'to' => $phoneNumber,
                'message' => $message,
                'sender_id' => $senderId,
            ];

            $response = $this->client->post(rtrim($this->config->textify['api_url'], '/') . '/sms/send', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->config->textify['api_key']
                ],
                'json' => $payload,
                'timeout' => 30
            ]);

            $status = $response->getStatusCode();
            $body = (string) $response->getBody();

            if ($status >= 200 && $status < 300) {
                // Try parse JSON and check success flags if provided
                $ok = true;
                $json = json_decode($body, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
                    if (isset($json['success']) && $json['success'] === false) {
                        $ok = false;
                    }
                    if (isset($json['status']) && in_array(strtolower((string) $json['status']), ['failed', 'error'], true)) {
                        $ok = false;
                    }
                }

                if ($ok) {
                    $this->logger->info('SMS sent successfully via Textify', ['to' => $phoneNumber, 'response' => $body]);
                    return true;
                }
            }

            $this->logger->error('Failed to send SMS via Textify', [
                'status' => $status,
                'payload' => $payload,
                'response' => $body,
            ]);
            return false;

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
            $subject = 'Confirmation: Your SmartElite Laptop Application Has Been Received';
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
        $name = isset($submissionData['first_name']) ? $submissionData['first_name'] : 'Student';
        $formTitle = $formData['title'];

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Confirmation: Your SmartElite Laptop Application Has Been Received</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
                .container { max-width: 640px; margin: 0 auto; padding: 20px; }
                .header { background: #1e3a8a; color: #fff; padding: 24px; text-align: center; }
                .content { padding: 28px 24px; background: #f8fafc; }
                .footer { padding: 16px; text-align: center; color: #666; font-size: 13px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>SmartElite Initiative</h1>
                </div>
                <div class='content'>
                    <p>Dear {$name},</p>
                    <p>Thank you for applying to the <strong>SmartElite initiative</strong> and for your interest in our laptop program with the pay-later option.</p>
                    <p>This email is to confirm that we have successfully received your application for <strong>{$formTitle}</strong>. Our team has begun the review process for all submissions.</p>
                    <p>We understand your eagerness to get started and appreciate your patience. You can expect to receive another notification from us regarding the status of your application once the review is complete.</p>
                    <p>Should you have any urgent questions, please do not hesitate to contact us at:<br>
                    Email: <a href='mailto:support@smartelite.co.tz'>support@smartelite.co.tz</a> or Call <a href='tel:+255625199652'>+255625 199 652</a></p>
                    <p>Thank you for being a part of the SmartElite community.</p>
                    <p>Best regards,<br>
                    <strong>The SmartElite Team</strong></p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " SmartElite Initiative</p>
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
        return "Hi {$name}!
We have received your application and are reviewing it carefully. We'll be sure to update you the moment the process is complete.
Thank you for your patience!";
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
        // Normalize to E.164. Accept inputs like 0712..., +255712..., 255712..., 712...
        $raw = trim($phoneNumber);
        if ($raw === '') {
            return '';
        }

        // Remove non-digits except leading +
        $normalized = preg_replace('/[^0-9+]/', '', $raw);

        // If starts with '+' assume E.164 (validate Tanzania default)
        if (strpos($normalized, '+') === 0) {
            // Ensure + followed by digits only
            if (!preg_match('/^\+[0-9]{7,15}$/', $normalized)) {
                return '';
            }
            return $normalized;
        }

        // If starts with '255', add '+'
        if (strpos($normalized, '255') === 0) {
            $candidate = '+' . $normalized;
            return preg_match('/^\+255[0-9]{7,12}$/', $candidate) ? $candidate : $candidate; // keep as is
        }

        // If starts with '0', drop it and prepend +255
        if (strpos($normalized, '0') === 0) {
            $digits = substr($normalized, 1);
            return '+255' . $digits;
        }

        // If starts with a 7 or 6 (common TZ mobile prefixes), prepend +255
        if (preg_match('/^[67][0-9]{7,}$/', $normalized)) {
            return '+255' . $normalized;
        }

        // Fallback: if only digits, prepend +255
        if (preg_match('/^[0-9]+$/', $normalized)) {
            return '+255' . $normalized;
        }

        return '';
    }

    /**
     * Ensure sender ID meets common SMS gateway constraints (<= 11 chars, alphanumeric).
     */
    private function normalizeSenderId(string $senderId): string
    {
        $id = preg_replace('/[^A-Za-z0-9]/', '', $senderId);
        if ($id === '' ) {
            $id = 'SmartElite';
        }
        if (strlen($id) > 11) {
            $id = substr($id, 0, 11);
        }
        return $id;
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
