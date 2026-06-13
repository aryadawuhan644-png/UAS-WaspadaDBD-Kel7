<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('pemeriksaan_risikos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('titik_risiko_id')->constrained('titik_risikos')->onDelete('cascade');
        $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
        $table->date('tanggal_pemeriksaan');
        $table->boolean('ditemukan_jentik');
        $table->text('kondisi_lingkungan');
        $table->text('tindakan_dilakukan');
        $table->enum('status_akhir', ['aman', 'perlu pemantauan', 'perlu tindakan']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_risikos');
    }
};
