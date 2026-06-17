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
    Schema::create('edukasi_dbds', function (Blueprint $table) {
        $table->id();
        $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
        $table->string('judul');
        $table->text('konten');
        $table->string('gambar')->nullable();
        
        // Menggunakan ENUM agar pilihan kategorinya pasti dan tidak salah ketik
        $table->enum('kategori', ['pencegahan', 'gejala', 'penanganan', 'fakta unik']);
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edukasi_dbds');
    }
};
