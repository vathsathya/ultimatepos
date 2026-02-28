<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$request = Illuminate\Http\Request::create('/bakong/generate-qr', 'POST', ['amount' => 10]);
app()->make(\Illuminate\Session\Middleware\StartSession::class)->handle($request, function($req) {
    return app()->handle($req);
});
echo "\nDONE\n";
