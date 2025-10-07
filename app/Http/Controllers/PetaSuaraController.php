<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PetaSuaraController extends Controller
{
    public function index()
    {
        // Get all 18 parties with colors
        $partaiList = DB::table('partai')
            ->select('nomor_urut', 'partai_singkat', 'nama', 'warna', 'logo_url')
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
                $proId = $prov->kode;

                // Get vote counts per party for this province
                $suaraPerPartai = DB::table('caleg_dpr_ri')
                    ->select('partai_id', DB::raw('SUM(suara) as total_suara'))
                    ->where('pro_id', $proId)
                    ->where('caleg_id', '<>', 333333)
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
                $topPartai = DB::table('caleg_dpr_ri')
                    ->join('partai', 'caleg_dpr_ri.partai_id', '=', 'partai.nomor_urut')
                    ->select('partai.partai_singkat', 'caleg_dpr_ri.partai_politik', DB::raw('SUM(caleg_dpr_ri.suara) as total_suara'))
                    ->where('caleg_dpr_ri.pro_id', $proId)
                    ->where('caleg_dpr_ri.caleg_id', '<>', 333333)
                    ->groupBy('caleg_dpr_ri.partai_id', 'caleg_dpr_ri.partai_politik', 'partai.partai_singkat')
                    ->orderByDesc('total_suara')
                    ->limit(3)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'nama' => $item->partai_singkat,
                            'nama_lengkap' => $item->partai_politik,
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
                    'total_dpt' => $prov->jml_dpt,
                    'total_kabupaten' => Wilayah::where('id_prov', $idProv)->where('tipe', 'kabupaten')->count(),
                    'top_partai' => $topPartai,
                    'partai_votes' => $partaiVotes,
                    'warna' => $topPartyId ? ($partaiColors[$topPartyId] ?? '#3B82F6') : '#3B82F6',
                ];
            });

        if (request()->wantsJson() || request()->header('X-Inertia')) {
            return Inertia::render('PetaSuara/Index', [
                'provinces' => $provinces,
                'partaiList' => $partaiList,
            ]);
        }

        // Calculate total votes per party across all provinces
        $totalSuaraPartai = [];
        $totalSuaraAll = 0;

        foreach ($partaiList as $partai) {
            $totalSuara = DB::table('caleg_dpr_ri')
                ->where('partai_id', $partai->nomor_urut)
                ->where('caleg_id', '<>', 333333)
                ->sum('suara');
            $totalSuaraPartai[] = [
                'partai_singkat' => $partai->partai_singkat,
                'nama' => $partai->nama,
                'warna' => $partai->warna,
                'logo_url' => $partai->logo_url,
                'total_suara' => $totalSuara,
                'nomor_urut' => $partai->nomor_urut,
            ];
            $totalSuaraAll += $totalSuara;
        }

        // Calculate percentage
        foreach ($totalSuaraPartai as &$item) {
            $item['persentase'] = $totalSuaraAll > 0 ? ($item['total_suara'] / $totalSuaraAll * 100) : 0;
        }

        return view('peta-suara-temp', [
            'provinces' => $provinces,
            'partaiList' => $partaiList,
            'totalSuaraPartai' => $totalSuaraPartai,
        ]);
    }
}
