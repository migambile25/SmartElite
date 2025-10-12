<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFormSubmissionsTable extends Migration
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
            'submission_data' => [
                'type' => 'JSON',
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'submitted_at' => [
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
        $this->forge->createTable('form_submissions');
    }

    public function down()
    {
        $this->forge->dropTable('form_submissions');
    }
}
