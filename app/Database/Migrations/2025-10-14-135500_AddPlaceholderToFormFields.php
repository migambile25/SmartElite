<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPlaceholderToFormFields extends Migration
{
    public function up()
    {
        $fields = [
            'placeholder' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'field_label',
            ],
        ];

        $this->forge->addColumn('form_fields', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('form_fields', 'placeholder');
    }
}


