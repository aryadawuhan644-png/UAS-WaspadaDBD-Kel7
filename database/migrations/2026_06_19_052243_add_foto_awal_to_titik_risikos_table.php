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
    Schema::table('titik_risikos', function (Blueprint $table) {
        $table->string('foto_awal')->nullable()->after('level_risiko_awal');
    });
}

public function down()
{
    Schema::table('titik_risikos', function (Blueprint $table) {
        $table->dropColumn('foto_awal');
    });
}
};
