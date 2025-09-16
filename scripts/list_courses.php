<?php
$app = require __DIR__ . '/bootstrap.php';

use App\Models\Course;

$rows = Course::with('category')->get()->map(function ($c) {
    return [
        'id' => $c->id,
        'title' => $c->title,
        'status' => $c->status,
        'category' => $c->category->name ?? null,
    ];
});

echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
