<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PetaSuaraDprdProvController extends Controller
{
    public function index()
    {
        // Get all 18 parties with colors
        $partaiList = DB::table('partai')
            ->select('nomor_urut', 'partai_singkat', 'nama', 'warna')
            ->whereIn('nomor_urut', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,24])
            ->orderBy('nomor_urut')
            ->get();

        // Create color mapping by party ID
        $partaiColors = DB::table('partai')
            ->whereIn('nomor_urut', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,24])
            ->pluck('warna', 'nomor_urut');

        // Get all provinces with their vote statistics per party
        $provinces = Wilayah::where('tipe', 'provinsi')
            ->orderBy('nama')
            ->get()
            ->map(function ($prov) use ($partaiList, $partaiColors) {
                $idProv = $prov->id_prov;
                $proKode = $prov->kode;

                // Get vote counts per party for this province
                $suaraPerPartai = DB::table('caleg_dprd_provinsi')
                    ->select('partai_id', DB::raw('SUM(suara) as total_suara'))
                    ->where('pro_kode', $proKode)
                    ->groupBy('partai_id')
                    ->pluck('total_suara', 'partai_id');

                // Get top party (winner) for this province
                $topPartyId = null;
                $maxSuara = 0;
                foreach ($suaraPerPartai as $partaiId => $suara) {
                    if ($suara > $maxSuara) {
                        $maxSuara = $suara;
                        $topPartyId = $partaiId;
                    }
                }

                // Get top 3 parties for tooltip
                $topPartai = DB::table('caleg_dprd_provinsi')
                    ->select('partai_politik', DB::raw('SUM(suara) as total_suara'))
                    ->where('pro_kode', $proKode)
                    ->groupBy('partai_id', 'partai_politik')
                    ->orderByDesc('total_suara')
                    ->limit(3)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'nama' => $item->partai_politik,
                            'suara' => $item->total_suara
                        ];
                    });

                // Build party votes array
                $partaiVotes = [];
                foreach ($partaiList as $partai) {
                    $partaiVotes[$partai->partai_singkat] = $suaraPerPartai[$partai->nomor_urut] ?? 0;
                }

                return [
                    'id' => $prov->id,
                    'nama' => $prov->nama,
                    'kode' => $prov->kode,
                    'total_dpt' => Wilayah::where('id_prov', $idProv)->sum('jml_dpt'),
                    'total_kabupaten' => Wilayah::where('id_prov', $idProv)->where('tipe', 'kabupaten')->count(),
                    'top_partai' => $topPartai,
                    'partai_votes' => $partaiVotes,
                    'warna' => $topPartyId ? ($partaiColors[$topPartyId] ?? '#3B82F6') : '#3B82F6',
                ];
            });

        return view('peta-suara-dprd-prov', [
            'provinces' => $provinces,
            'partaiList' => $partaiList,
        ]);
    }
}
