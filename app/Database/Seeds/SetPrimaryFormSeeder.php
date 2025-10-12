<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\FormModel;

class SetPrimaryFormSeeder extends Seeder
{
    public function run()
    {
        $formModel = new FormModel();
        
        // Set the SmartElite Laptop Application as primary
        $result = $formModel->where('slug', 'smartelite-laptop-application')
                           ->set(['is_primary' => true])
                           ->update();
        
        if ($result) {
            echo "Set SmartElite Laptop Application as primary form\n";
        } else {
            echo "Failed to set primary form\n";
        }
    }
}
