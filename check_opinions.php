<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Opinion;

Opinion::all(['id', 'slug', 'title'])->each(function ($o) {
    echo "ID: {$o->id} | Slug: '{$o->slug}' | Title: '{$o->title}'\n";
});
