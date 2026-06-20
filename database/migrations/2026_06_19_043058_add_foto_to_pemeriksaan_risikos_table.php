<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pemeriksaan_risikos', function (Blueprint $table) {
        // Menambahkan kolom foto setelah status_akhir, boleh kosong (nullable)
        $table->string('foto')->nullable()->after('status_akhir');
    });
}

public function down()
{
    Schema::table('pemeriksaan_risikos', function (Blueprint $table) {
        $table->dropColumn('foto');
    });
}
};
