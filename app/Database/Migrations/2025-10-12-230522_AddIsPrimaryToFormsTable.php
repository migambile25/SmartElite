<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsPrimaryToFormsTable extends Migration
{
    private function columnExists(string $table, string $column): bool
    {
        $result = $this->db->query(
            'SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ? LIMIT 1',
            [$table, $column]
        );
        return $result && $result->getFirstRow() !== null;
    }

    public function up()
    {
        if (! $this->columnExists('forms', 'is_primary')) {
            $this->forge->addColumn('forms', [
                'is_primary' => [
                    'type' => 'BOOLEAN',
                    'default' => false,
                    'null' => false,
                    'after' => 'is_active'
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->columnExists('forms', 'is_primary')) {
            $this->forge->dropColumn('forms', 'is_primary');
        }
    }
}