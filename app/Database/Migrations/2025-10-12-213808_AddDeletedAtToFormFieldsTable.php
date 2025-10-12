<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToFormFieldsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('form_fields', [
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('form_fields', 'deleted_at');
    }
}
