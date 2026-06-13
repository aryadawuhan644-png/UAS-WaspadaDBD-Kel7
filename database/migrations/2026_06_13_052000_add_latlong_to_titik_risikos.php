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
        if (Schema::hasTable('titik_risikos')) {
            Schema::table('titik_risikos', function (Blueprint $table) {
                if (!Schema::hasColumn('titik_risikos', 'latitude')) {
                    $table->decimal('latitude', 10, 7)->nullable()->after('rt_rw');
                }
                if (!Schema::hasColumn('titik_risikos', 'longitude')) {
                    $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('titik_risikos')) {
            Schema::table('titik_risikos', function (Blueprint $table) {
                if (Schema::hasColumn('titik_risikos', 'longitude')) {
                    $table->dropColumn('longitude');
                }
                if (Schema::hasColumn('titik_risikos', 'latitude')) {
                    $table->dropColumn('latitude');
                }
            });
        }
    }
};
