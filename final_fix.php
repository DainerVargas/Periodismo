<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Opinion;
use Illuminate\Support\Str;

$count = 0;
Opinion::all()->each(function ($o) use (&$count) {
    if (true) { // Force update all
        $cleanTitle = trim(preg_replace('/\s+/', ' ', $o->title));
        $o->slug = Str::slug($cleanTitle);
        if (empty($o->slug)) {
            $o->slug = 'opinion-' . $o->id;
        }
        $o->save();
        $count++;
    }
});

echo "Fixed $count opinions.\n";
foreach (Opinion::all() as $o) {
    echo "ID: {$o->id} | Slug: '{$o->slug}'\n";
}
