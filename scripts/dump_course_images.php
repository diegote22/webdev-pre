<?php
// Debug helper to inspect course images
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';

/** @var Illuminate\Contracts\Console\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Course;

$courses = Course::select('id', 'title', 'image_path')->get();

$out = [];
foreach ($courses as $c) {
    $out[] = [
        'id' => $c->id,
        'title' => $c->title,
        'image_path' => $c->image_path,
        'has_image' => $c->has_image,
        'image_url' => $c->image_url,
    ];
}

echo json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
