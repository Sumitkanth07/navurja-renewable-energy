<?php
define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== BOOTING ARTISAN ===<br>";

// Clear view cache
$status = $kernel->call('view:clear');
echo "View cache cleared. Status: " . $status . "<br>";
echo "<pre>" . $kernel->output() . "</pre><br>";

// Clear route cache too to be safe
$status = $kernel->call('route:clear');
echo "Route cache cleared. Status: " . $status . "<br>";
echo "<pre>" . $kernel->output() . "</pre><br>";

echo "=== ALL OPERATIONS COMPLETE ===";
