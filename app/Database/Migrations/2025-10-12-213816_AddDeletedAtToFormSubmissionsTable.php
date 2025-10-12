<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToFormSubmissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('form_submissions', [
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('form_submissions', 'deleted_at');
    }
}
