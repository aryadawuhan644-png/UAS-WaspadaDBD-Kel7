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
    Schema::create('titik_risikos', function (Blueprint $table) {
        $table->id();
        $table->string('nama_titik'); // <--- Pastikan baris ini dan bawahnya ada
        $table->text('alamat');
        $table->string('rt_rw');
        $table->decimal('latitude', 10, 8);
        $table->decimal('longitude', 11, 8);
        $table->enum('jenis_risiko', ['genangan', 'barang bekas', 'saluran air', 'tempat sampah']);
        $table->enum('level_risiko_awal', ['rendah', 'sedang', 'tinggi']);
        $table->boolean('status_aktif')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titik_risikos');
    }
};
