<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Notifications extends BaseConfig
{
    // Brevo Email API Configuration
    public $brevo = [
        'api_key' => '', // Set in .env as BREVO_API_KEY
        'api_url' => 'https://api.brevo.com/v3',
        'sender_email' => 'noreply@smartelite.tz', // Set in .env as BREVO_SENDER_EMAIL
        'sender_name' => 'SmartElite Initiative',
        'reply_to' => 'support@smartelite.tz', // Set in .env as BREVO_REPLY_TO
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
