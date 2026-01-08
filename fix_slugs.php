<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Opinion;
use Illuminate\Support\Str;

Opinion::all()->each(function ($o) {
    $cleanTitle = trim(preg_replace('/\s+/', ' ', $o->title));
    $o->slug = Str::slug($cleanTitle);
    if (!$o->slug) {
        $o->slug = 'opinion-' . $o->id;
    }
    $o->save();
    echo "ID: {$o->id} | New Slug: {$o->slug}\n";
});
