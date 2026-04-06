<?php

require 'vendor/autoload.php';
$app = include 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$modules = \App\Models\Module::with('children.children')->where('parent_id', null)->orderBy('order_number')->get();

echo "=== EXISTING MODULE STRUCTURE ===\n";
echo str_repeat("=", 60) . "\n\n";

foreach ($modules as $m) {
    echo "📁 " . $m->name . " (ID: {$m->id}, Slug: {$m->slug})\n";
    
    foreach ($m->children as $c) {
        echo "   └─ " . $c->name . " (ID: {$c->id}, Slug: {$c->slug})\n";
        
        foreach ($c->children as $cc) {
            echo "      └─ " . $cc->name . " (ID: {$cc->id})\n";
        }
    }
    echo "\n";
}

echo "\nTotal modules: " . \App\Models\Module::count() . "\n";
