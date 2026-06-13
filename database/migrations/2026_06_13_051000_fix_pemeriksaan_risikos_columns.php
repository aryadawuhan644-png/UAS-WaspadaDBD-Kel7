<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('pemeriksaan_risikos')) {
            Schema::table('pemeriksaan_risikos', function (Blueprint $table) {
                if (!Schema::hasColumn('pemeriksaan_risikos', 'ditemukan_jentik')) {
                    $table->boolean('ditemukan_jentik')->default(0)->after('tanggal_pemeriksaan');
                }
            });

            if (!Schema::hasColumn('pemeriksaan_risikos', 'kondisi_lingkungan')) {
                if (Schema::hasColumn('pemeriksaan_risikos', 'hasil_temuan')) {
                    DB::statement('ALTER TABLE pemeriksaan_risikos CHANGE hasil_temuan kondisi_lingkungan TEXT NULL');
                } else {
                    Schema::table('pemeriksaan_risikos', function (Blueprint $table) {
                        $table->text('kondisi_lingkungan')->nullable()->after('tanggal_pemeriksaan');
                    });
                }
            }

            if (Schema::hasColumn('pemeriksaan_risikos', 'status_tindak_lanjut')) {
                DB::statement("UPDATE pemeriksaan_risikos SET status_tindak_lanjut = CASE
                    WHEN status_tindak_lanjut = 'selesai' THEN 'aman'
                    WHEN status_tindak_lanjut = 'proses' THEN 'perlu pemantauan'
                    WHEN status_tindak_lanjut = 'belum' THEN 'perlu tindakan'
                    ELSE 'perlu pemantauan' END");

                DB::statement("ALTER TABLE pemeriksaan_risikos CHANGE status_tindak_lanjut status_akhir ENUM('aman','perlu pemantauan','perlu tindakan') NOT NULL");
            }
            if (!Schema::hasColumn('pemeriksaan_risikos', 'tindakan_dilakukan')) {
                Schema::table('pemeriksaan_risikos', function (Blueprint $table) {
                    $table->text('tindakan_dilakukan')->nullable()->after('kondisi_lingkungan');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pemeriksaan_risikos')) {
            if (Schema::hasColumn('pemeriksaan_risikos', 'status_akhir')) {
                DB::statement("ALTER TABLE pemeriksaan_risikos CHANGE status_akhir status_tindak_lanjut ENUM('belum','proses','selesai') NOT NULL");
            }

            if (Schema::hasColumn('pemeriksaan_risikos', 'kondisi_lingkungan')) {
                DB::statement('ALTER TABLE pemeriksaan_risikos CHANGE kondisi_lingkungan hasil_temuan VARCHAR(255) NOT NULL');
            }

            Schema::table('pemeriksaan_risikos', function (Blueprint $table) {
                if (Schema::hasColumn('pemeriksaan_risikos', 'ditemukan_jentik')) {
                    $table->dropColumn('ditemukan_jentik');
                }

                if (Schema::hasColumn('pemeriksaan_risikos', 'tindakan_dilakukan')) {
                    $table->dropColumn('tindakan_dilakukan');
                }
            });
        }
    }
};
