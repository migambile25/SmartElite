<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\FormModel;

class AdditionalFormsSeeder extends Seeder
{
    public function run()
    {
        $formModel = new FormModel();

        $forms = [
            [
                'title' => 'Scholarship Application',
                'slug' => 'scholarship-application',
                'description' => 'Apply for academic scholarships and financial aid opportunities.',
                'is_active' => true,
                'success_message' => 'Your scholarship application has been submitted successfully. We will review your application and contact you within 10 business days.',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_flag' => false
            ],
            [
                'title' => 'Event Registration',
                'slug' => 'event-registration',
                'description' => 'Register for upcoming SmartElite events, workshops, and training sessions.',
                'is_active' => true,
                'success_message' => 'Thank you for registering for our event. You will receive a confirmation email with event details shortly.',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_flag' => false
            ],
            [
                'title' => 'Feedback & Suggestions',
                'slug' => 'feedback-suggestions',
                'description' => 'Share your feedback, suggestions, and ideas to help us improve the SmartElite Initiative.',
                'is_active' => true,
                'success_message' => 'Thank you for your valuable feedback. We appreciate your input and will use it to improve our services.',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_flag' => false
            ]
        ];

        foreach ($forms as $form) {
            // Check if form already exists
            $existingForm = $formModel->where('slug', $form['slug'])->first();
            if (!$existingForm) {
                $formModel->insert($form);
                echo "Created form: " . $form['title'] . "\n";
            } else {
                echo "Form already exists: " . $form['title'] . "\n";
            }
        }
    }
}
