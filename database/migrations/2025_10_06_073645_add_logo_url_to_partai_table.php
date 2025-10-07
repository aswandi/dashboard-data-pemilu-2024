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
        Schema::table('partai', function (Blueprint $table) {
            $table->string('logo_url', 500)->nullable()->after('warna');
        });

        // Update logo URLs untuk setiap partai berdasarkan nomor urut
        $logoUpdates = [
            1 => 'https://asset-2.tstatic.net/tribunnews/foto/bank/images/logo-pkb.jpg',
            2 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gerindra.svg/200px-Gerindra.svg.png',
            3 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/Logo_PDI-P.svg/200px-Logo_PDI-P.svg.png',
            4 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/Golkar.svg/200px-Golkar.svg.png',
            5 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c2/Logo_Partai_NasDem.svg/200px-Logo_Partai_NasDem.svg.png',
            6 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/Logo_Partai_Buruh.svg/200px-Logo_Partai_Buruh.svg.png',
            7 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Logo_Gelora.svg/200px-Logo_Gelora.svg.png',
            8 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Logo_Partai_Keadilan_Sejahtera.svg/200px-Logo_Partai_Keadilan_Sejahtera.svg.png',
            9 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/56/PKN_logo.svg/200px-PKN_logo.svg.png',
            10 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/34/Hanura.svg/200px-Hanura.svg.png',
            11 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fd/Logo_Partai_Garuda.svg/200px-Logo_Partai_Garuda.svg.png',
            12 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/17/Logo_of_the_National_Mandate_Party.svg/200px-Logo_of_the_National_Mandate_Party.svg.png',
            13 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Crescent_Star_Party_logo.svg/200px-Crescent_Star_Party_logo.svg.png',
            14 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8c/Logo_Partai_Demokrat.svg/200px-Logo_Partai_Demokrat.svg.png',
            15 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f8/Logo_Partai_Solidaritas_Indonesia_%28PSI%29.svg/200px-Logo_Partai_Solidaritas_Indonesia_%28PSI%29.svg.png',
            16 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3b/Perindo.svg/200px-Perindo.svg.png',
            17 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/PPP.svg/200px-PPP.svg.png',
            24 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Partai_Ummat_logo.svg/200px-Partai_Ummat_logo.svg.png',
        ];

        foreach ($logoUpdates as $nomorUrut => $logoUrl) {
            DB::table('partai')
                ->where('nomor_urut', $nomorUrut)
                ->update(['logo_url' => $logoUrl]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partai', function (Blueprint $table) {
            $table->dropColumn('logo_url');
        });
    }
};
