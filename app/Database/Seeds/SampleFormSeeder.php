<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SampleFormSeeder extends Seeder
{
    public function run()
    {
        // Create a sample form
        $formData = [
            'title' => 'SmartElite Laptop Application',
            'slug' => 'smartelite',
            'description' => 'Apply for an affordable laptop through the SmartElite Initiative. Get access to essential digital tools for your academic success.',
            'is_active' => 1,
            'is_primary' => true,
            'success_message' => 'Thank you for your application! We have received your SmartElite laptop application. Our team will review your application and contact you within 5-7 business days with further instructions.',
            'created_by' => 1, // Assuming admin user has ID 1
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $existingForm = $this->db->table('forms')->where('slug', 'smartelite')->get()->getFirstRow();
        if (! $existingForm) {
            $this->db->table('forms')->insert($formData);
            $formId = $this->db->insertID();
        } else {
            $formId = $existingForm->id;
        }

        // Create sample form fields
        $fields = [
            [
                'form_id' => $formId,
                'field_name' => 'first_name',
                'field_label' => 'First Name',
                'field_type' => 'text',
                'field_options' => null,
                'is_required' => 1,
                'field_order' => 1,
                'validation_rules' => 'min_length[2]|max_length[50]',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_id' => $formId,
                'field_name' => 'last_name',
                'field_label' => 'Last Name',
                'field_type' => 'text',
                'field_options' => null,
                'is_required' => 1,
                'field_order' => 2,
                'validation_rules' => 'min_length[2]|max_length[50]',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_id' => $formId,
                'field_name' => 'heslb_number',
                'field_label' => 'HESLB Loan Number',
                'field_type' => 'text',
                'field_options' => null,
                'is_required' => 1,
                'field_order' => 3,
                'validation_rules' => 'min_length[5]|max_length[20]',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_id' => $formId,
                'field_name' => 'email',
                'field_label' => 'Email Address',
                'field_type' => 'email',
                'field_options' => null,
                'is_required' => 1,
                'field_order' => 4,
                'validation_rules' => 'valid_email',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_id' => $formId,
                'field_name' => 'phone',
                'field_label' => 'Phone Number',
                'field_type' => 'tel',
                'field_options' => null,
                'is_required' => 1,
                'field_order' => 5,
                'validation_rules' => 'regex_match[/^[\+]?[1-9][\d]{0,15}$/]',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_id' => $formId,
                'field_name' => 'university',
                'field_label' => 'University/Institution',
                'field_type' => 'select',
                'field_options' => json_encode([
                    'Mbeya University of Science and Technology',
                    'Arusha Technical College',
                    'Dar es Salaam Institute of Technology',
                    'University of Dar es Salaam',
                    'Sokoine University of Agriculture',
                    'Muhimbili University of Health and Allied Sciences',
                    'University of Dodoma',
                    'Ardhi University',
                    'Tumaini University Dar es Salaam College',
                    'St. Augustine University of Tanzania',
                    'Mzumbe University',
                    'Open University of Tanzania',
                    'University of Iringa',
                    'Sebastian Kolowa Memorial University',
                    'Catholic University of Health and Allied Sciences',
                    'Kilimanjaro Christian Medical University College',
                    'Moshi Co-operative University',
                    'Institute of Social Work',
                    'Tanzania Institute of Accountancy',
                    'National Institute of Transport',
                    'Tanzania Public Service College',
                    'Other'
                ]),
                'is_required' => 1,
                'field_order' => 6,
                'validation_rules' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_id' => $formId,
                'field_name' => 'course_of_study',
                'field_label' => 'Course of Study',
                'field_type' => 'text',
                'field_options' => null,
                'is_required' => 1,
                'field_order' => 7,
                'validation_rules' => 'min_length[3]|max_length[100]',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_id' => $formId,
                'field_name' => 'year_of_study',
                'field_label' => 'Year of Study',
                'field_type' => 'select',
                'field_options' => json_encode([
                    'First Year',
                    'Second Year',
                    'Third Year',
                    'Fourth Year',
                    'Fifth Year',
                    'Postgraduate'
                ]),
                'is_required' => 1,
                'field_order' => 8,
                'validation_rules' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_id' => $formId,
                'field_name' => 'current_device',
                'field_label' => 'What device do you currently use for studies?',
                'field_type' => 'radio',
                'field_options' => json_encode([
                    'Smartphone only',
                    'Shared computer/laptop',
                    'Personal laptop (old/slow)',
                    'Tablet',
                    'No device',
                    'Other'
                ]),
                'is_required' => 1,
                'field_order' => 9,
                'validation_rules' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_id' => $formId,
                'field_name' => 'laptop_usage',
                'field_label' => 'How will you use the laptop? (Select all that apply)',
                'field_type' => 'checkbox',
                'field_options' => json_encode([
                    'Academic research and assignments',
                    'Online learning platforms',
                    'Programming and software development',
                    'Digital content creation',
                    'Entrepreneurship projects',
                    'Communication and collaboration',
                    'Data analysis and research',
                    'Other academic activities'
                ]),
                'is_required' => 1,
                'field_order' => 10,
                'validation_rules' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_id' => $formId,
                'field_name' => 'financial_need',
                'field_label' => 'Please explain your financial need for this laptop',
                'field_type' => 'textarea',
                'field_options' => null,
                'is_required' => 1,
                'field_order' => 11,
                'validation_rules' => 'min_length[20]|max_length[500]',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_id' => $formId,
                'field_name' => 'payment_agreement',
                'field_label' => 'I agree to pay TZS 300,000 in two installments per semester from my HESLB allowance',
                'field_type' => 'radio',
                'field_options' => json_encode([
                    'Yes, I agree to the payment terms',
                    'No, I do not agree'
                ]),
                'is_required' => 1,
                'field_order' => 12,
                'validation_rules' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        foreach ($fields as $field) {
            $this->db->table('form_fields')->insert($field);
        }
    }
}
