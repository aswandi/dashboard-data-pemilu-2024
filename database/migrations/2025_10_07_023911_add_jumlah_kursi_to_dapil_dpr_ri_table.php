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
        Schema::table('dapil_dpr_ri', function (Blueprint $table) {
            $table->integer('jumlah_kursi')->nullable()->after('dapil_nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dapil_dpr_ri', function (Blueprint $table) {
            $table->dropColumn('jumlah_kursi');
        });
    }
};
