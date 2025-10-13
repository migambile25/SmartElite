<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToFormsTable extends Migration
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
        if (! $this->columnExists('forms', 'deleted_at')) {
            $this->forge->addColumn('forms', [
                'deleted_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->columnExists('forms', 'deleted_at')) {
            $this->forge->dropColumn('forms', 'deleted_at');
        }
    }
}
