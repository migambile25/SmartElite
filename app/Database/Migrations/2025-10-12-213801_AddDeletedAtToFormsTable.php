<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToFormsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('forms', [
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('forms', 'deleted_at');
    }
}
