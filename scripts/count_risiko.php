<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TitikRisiko;
use App\Models\PemeriksaanRisiko;

echo "Counts report:\n";

$levelHigh = TitikRisiko::where('level_risiko_awal', 'tinggi')->count();
echo "- level_risiko_awal == 'tinggi': $levelHigh\n";

$whereHas = TitikRisiko::whereHas('pemeriksaan', function ($q) {
    $q->where('status_akhir', 'perlu tindakan');
})->count();
echo "- whereHas pemeriksaan status 'perlu tindakan': $whereHas\n";

$distinct = PemeriksaanRisiko::where('status_akhir', 'perlu tindakan')->distinct('titik_risiko_id')->pluck('titik_risiko_id')->count();
echo "- distinct titik_risiko_id in pemeriksaan with status 'perlu tindakan': $distinct\n";

// Latest pemeriksaan per titik
$latestCount = 0;
$titikIds = TitikRisiko::pluck('id');
foreach ($titikIds as $id) {
    $last = PemeriksaanRisiko::where('titik_risiko_id', $id)->orderByDesc('tanggal_pemeriksaan')->first();
    if ($last && $last->status_akhir === 'perlu tindakan') {
        $latestCount++;
    }
}
echo "- latest pemeriksaan per titik status 'perlu tindakan': $latestCount\n";

// List ids for debugging
echo "\nTitik IDs with level_risiko_awal='tinggi':\n";
foreach (TitikRisiko::where('level_risiko_awal','tinggi')->pluck('id') as $id) echo "  - $id\n";

echo "\nTitik IDs with any pemeriksaan status 'perlu tindakan':\n";
foreach (PemeriksaanRisiko::where('status_akhir','perlu tindakan')->distinct()->pluck('titik_risiko_id') as $id) echo "  - $id\n";

echo "\nDone.\n";