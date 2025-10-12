<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFormFieldsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'form_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'field_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'field_label' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'field_type' => [
                'type' => 'ENUM',
                'constraint' => ['text', 'email', 'tel', 'number', 'date', 'textarea', 'select', 'radio', 'checkbox', 'file'],
                'default' => 'text',
            ],
            'field_options' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'is_required' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'field_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'validation_rules' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('form_id', 'forms', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('form_fields');
    }

    public function down()
    {
        $this->forge->dropTable('form_fields');
    }
}
