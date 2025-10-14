<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Notifications extends BaseConfig
{
    // Brevo Email Configuration
    public $brevo = [
        // API Configuration
        'api_key' => '', // Set in .env as BREVO_API_KEY
        'api_url' => 'https://api.brevo.com/v3',
        'sender_email' => 'info@cims.co.tz', // Set in .env as BREVO_SENDER_EMAIL
        'sender_name' => 'SmartElite Initiative',
        'reply_to' => 'info@cims.co.tz', // Set in .env as BREVO_REPLY_TO
        
        // SMTP Configuration
        'smtp_host' => 'smtp-relay.brevo.com', // Set in .env as BREVO_SMTP_HOST
        'smtp_port' => 465, // Set in .env as BREVO_SMTP_PORT (587 for TLS, 465 for SSL)
        'smtp_username' => '', // Set in .env as BREVO_SMTP_USERNAME (your Brevo email)
        'smtp_password' => '', // Set in .env as BREVO_SMTP_PASSWORD (your SMTP key)
        'smtp_encryption' => 'ssl', // Set in .env as BREVO_SMTP_ENCRYPTION (tls for 587, ssl for 465)
    ];

    // Textify SMS API Configuration
    public $textify = [
        'api_key' => '', // Set in .env as TEXTIFY_API_KEY
        'api_url' => 'https://api.textify.africa/v1',
        'sender_id' => 'SmartElite', // Set in .env as TEXTIFY_SENDER_ID
    ];

    // Notification Settings
    public $settings = [
        'send_email_notifications' => true,
        'send_sms_notifications' => true,
        'email_method' => 'api', // 'api' or 'smtp' - Set in .env as EMAIL_METHOD
        'email_template_id' => null, // Brevo template ID (optional)
        'sms_template' => 'Thank you for your SmartElite application. We will contact you within 5-7 business days.',
        'admin_notification_email' => 'admin@smartelite.tz', // Set in .env as ADMIN_NOTIFICATION_EMAIL
        'admin_notification_sms' => '+255123456789', // Set in .env as ADMIN_NOTIFICATION_SMS
    ];

    // Rate Limiting
    public $rateLimits = [
        'email_per_hour' => 100,
        'sms_per_hour' => 50,
        'email_per_day' => 1000,
        'sms_per_day' => 500,
    ];
}
