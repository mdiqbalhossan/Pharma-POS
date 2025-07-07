<?php

use Illuminate\Http\Request;
use Illuminate\Contracts\Http\Kernel;

define('LARAVEL_START', microtime(true));

$corePath = E:\xampp\htdocs\pharmacy . '/core';

if (file_exists($maintenance = $corePath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $corePath . '/vendor/autoload.php';
$app = require_once $corePath . '/bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$response = $kernel->handle($request = Request::capture())->send();
$kernel->terminate($request, $response);