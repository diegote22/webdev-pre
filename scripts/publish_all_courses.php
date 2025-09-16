<?php
$app = require __DIR__ . '/bootstrap.php';

use App\Models\Course;

$count = Course::where('status', '!=', 'published')->update(['status' => 'published']);
echo json_encode(['updated' => $count], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
