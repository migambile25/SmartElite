<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsPrimaryToFormsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('forms', [
            'is_primary' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
                'after' => 'is_active'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('forms', 'is_primary');
    }
}