<?php
define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "=== BOOTING ARTISAN ===<br>";

// Clear route cache
$status = $kernel->call('route:clear');
echo "Route cache cleared. Status: " . $status . "<br>";
echo "<pre>" . $kernel->output() . "</pre><br>";

// Clear view cache
$status = $kernel->call('view:clear');
echo "View cache cleared. Status: " . $status . "<br>";
echo "<pre>" . $kernel->output() . "</pre><br>";

// Clear config cache
$status = $kernel->call('config:clear');
echo "Config cache cleared. Status: " . $status . "<br>";
echo "<pre>" . $kernel->output() . "</pre><br>";

// Clear cache
$status = $kernel->call('cache:clear');
echo "Cache cleared. Status: " . $status . "<br>";
echo "<pre>" . $kernel->output() . "</pre><br>";

// Run migrations
$status = $kernel->call('migrate', ['--force' => true]);
echo "Migrations run. Status: " . $status . "<br>";
echo "<pre>" . $kernel->output() . "</pre><br>";

echo "=== ALL OPERATIONS COMPLETE ===";
