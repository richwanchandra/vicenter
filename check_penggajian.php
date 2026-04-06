<?php
require 'bootstrap/app.php';
$app = make(\Illuminate\Contracts\Foundation\Application::class);
$app->make(\Illuminate\Contracts\Http\Kernel::class);

use Illuminate\Support\Facades\DB;

$modules = DB::table('modules')
    ->whereRaw('LOWER(name) LIKE ?', ['%penggajian%'])
    ->get();

echo "Modules with 'Penggajian':\n";
foreach ($modules as $m) {
    echo "  ID: {$m->id}, Name: {$m->name}, Parent: {$m->parent_id}\n";
}

echo "\n\nAll HRD child modules:\n";
$hrd = DB::table('modules')->where('name', 'Human Resource Development (HRD)')->first();
if ($hrd) {
    $children = DB::table('modules')->where('parent_id', $hrd->id)->get();
    foreach ($children as $c) {
        echo "  - {$c->name}\n";
    }
}
