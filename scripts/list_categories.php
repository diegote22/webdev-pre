<?php
$app = require __DIR__ . '/bootstrap.php';

use App\Models\Category;

$rows = Category::orderBy('name')->get(['id', 'name', 'slug']);
echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
