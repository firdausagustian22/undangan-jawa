<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "DB_CONNECTION: " . config('database.default') . "\n";
echo "DB_DATABASE: " . config('database.connections.mysql.database') . "\n";

try {
    \DB::connection()->getPdo();
    echo "MySQL Connected! Driver: " . \DB::connection()->getDriverName() . "\n";
    $count = \DB::table('weddings')->count();
    echo "Weddings table rows: " . $count . "\n";
    echo "SUCCESS - Database terhubung dengan benar!\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
