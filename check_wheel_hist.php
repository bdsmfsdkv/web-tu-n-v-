<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$h = DB::table('lucky_wheel_histories')->first();
echo json_encode($h, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
echo "\n\n--- COLUMNS ---\n";
echo json_encode(DB::getSchemaBuilder()->getColumnListing('lucky_wheel_histories'));
