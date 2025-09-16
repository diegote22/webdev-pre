<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';

$app->make(Kernel::class)->bootstrap();

$routes = Route::getRoutes();

echo "Total routes: " . count($routes) . PHP_EOL;
foreach ($routes as $route) {
    printf("%6s  %-40s  %s\n", implode('|', $route->methods()), $route->uri(), $route->getName() ?? '');
}
