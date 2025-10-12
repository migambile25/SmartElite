<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedFlagToFormSubmissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('form_submissions', [
            'deleted_flag' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('form_submissions', 'deleted_flag');
    }
}
