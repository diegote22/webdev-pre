<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Course as CourseModel;
use App\Models\Category;

$secundaria = CourseModel::published()->whereHas('category', function ($q) {
    $q->where('slug', 'secundaria');
})->with(['category', 'subCategory', 'professor'])->get();

$pre = CourseModel::published()->whereHas('category', function ($q) {
    $q->where('slug', 'pre-universitario');
})->with(['category', 'subCategory', 'professor'])->get();

$uni = CourseModel::published()->whereHas('category', function ($q) {
    $q->where('slug', 'universitario');
})->with(['category', 'subCategory', 'professor'])->get();

$cats = Category::select('id', 'name')->orderBy('name')->get();

$out = [
    'categories' => $cats,
    'secundaria' => $secundaria->map(fn($c) => ['id' => $c->id, 'title' => $c->title, 'status' => $c->status, 'category' => $c->category->name ?? null]),
    'pre' => $pre->map(fn($c) => ['id' => $c->id, 'title' => $c->title, 'status' => $c->status, 'category' => $c->category->name ?? null]),
    'uni' => $uni->map(fn($c) => ['id' => $c->id, 'title' => $c->title, 'status' => $c->status, 'category' => $c->category->name ?? null]),
];

echo json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
