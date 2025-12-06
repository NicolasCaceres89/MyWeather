<?php
$vendor = __DIR__ . '/../vendor/autoload.php';
require $vendor;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$email = 'admin@myweather.com';
$user = User::where('email', $email)->first();

if (! $user) {
    echo "No user found with email: $email\n";
    exit(0);
}

$data = $user->only(['id','email','user_type','active']);
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
