<?php

/**
 * SmartElite Setup Script
 * 
 * This script will:
 * 1. Run database migrations
 * 2. Run database seeders
 * 3. Set proper permissions
 * 
 * Run this script after setting up your database configuration
 */

echo "SmartElite Setup Script\n";
echo "======================\n\n";

// Check if we're in the right directory
if (!file_exists('spark')) {
    echo "Error: Please run this script from the SmartElite project root directory.\n";
    exit(1);
}

echo "1. Running database migrations...\n";
$migrationOutput = shell_exec('php spark migrate 2>&1');
echo $migrationOutput . "\n";

echo "2. Running database seeders...\n";
$seederOutput = shell_exec('php spark db:seed DatabaseSeeder 2>&1');
echo $seederOutput . "\n";

echo "3. Setting up writable directories...\n";
$directories = [
    'writable/cache',
    'writable/logs',
    'writable/session',
    'writable/uploads'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    chmod($dir, 0755);
    echo "   ✓ $dir\n";
}

echo "\nSetup completed successfully!\n\n";
echo "Default Admin Credentials:\n";
echo "Username: admin\n";
echo "Email: admin@smartelite.com\n";
echo "Password: admin123\n\n";
echo "Access the admin panel at: /admin/login\n";
echo "Sample form available at: /register/smartelite\n\n";
echo "IMPORTANT: Change the default admin password after first login!\n";
