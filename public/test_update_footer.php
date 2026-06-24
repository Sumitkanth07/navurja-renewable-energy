<?php
define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::create('/robots.txt', 'GET'));

use App\Models\FooterSetting;

$data = [
    'company_name' => 'Navurja Renewable Energy Solutions',
    'footer_description' => 'Leading Solar Power Systems and Renewable Energy Solutions in New Delhi.',
    'copyright_text' => 'Copyright 2026 Navurja Solutions Inc.',
    'phone' => '+91 96506 63966',
    'alternate_phone' => '+91 98765 43210',
    'email' => 'info@nav-urja.com',
    'address' => '12, Connaught Place, New Delhi, Delhi, 110001',
    'map_url' => 'https://maps.google.com/?q=Connaught+Place',
    'whatsapp_enabled' => 1,
    'whatsapp_number' => '919650663966',
    'whatsapp_message' => 'Hello Navurja, I want to inquire about solar panel installation.',
    'facebook_url' => 'https://facebook.com/navurja',
    'instagram_url' => 'https://instagram.com/navurja',
    'linkedin_url' => 'https://linkedin.com/company/navurja',
    'youtube_url' => 'https://youtube.com/navurja',
    'twitter_url' => 'https://twitter.com/navurja'
];

try {
    $footer = FooterSetting::query()->updateOrCreate(['id' => 1], $data);
    echo "PRODUCTION DATABASE UPDATED SUCCESSFULLY!<br>";
    print_r($footer->toArray());
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
