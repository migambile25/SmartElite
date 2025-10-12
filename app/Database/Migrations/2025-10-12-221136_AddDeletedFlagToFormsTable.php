<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedFlagToFormsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('forms', [
            'deleted_flag' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('forms', 'deleted_flag');
    }
}
