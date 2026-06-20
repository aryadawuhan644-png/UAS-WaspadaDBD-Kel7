<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = \Illuminate\Http\Request::capture());

$pemeriksaans = \App\Models\PemeriksaanRisiko::select('id','titik_risiko_id','foto','created_at')->limit(5)->get();

echo "=== PEMERIKSAAN FOTO DEBUG ===\n";
foreach($pemeriksaans as $p) {
    echo "ID: " . $p->id . " | TitikID: " . $p->titik_risiko_id . " | Foto: " . ($p->foto ?? 'NULL/EMPTY') . " | Created: " . $p->created_at . "\n";
}

echo "\n=== TITIK RISIKO FOTO_AWAL DEBUG ===\n";
$titiks = \App\Models\TitikRisiko::select('id','nama_titik','foto_awal')->limit(5)->get();
foreach($titiks as $t) {
    echo "ID: " . $t->id . " | Nama: " . $t->nama_titik . " | Foto Awal: " . ($t->foto_awal ?? 'NULL/EMPTY') . "\n";
}

echo "\n=== STORAGE PATH CHECK ===\n";
$storagePath = 'public/storage';
if (is_dir($storagePath)) {
    echo "Storage symlink EXISTS\n";
    $files = scandir($storagePath);
    echo "Folders in public/storage: " . implode(', ', array_diff($files, ['.', '..'])) . "\n";
} else {
    echo "Storage symlink MISSING\n";
}
?>
