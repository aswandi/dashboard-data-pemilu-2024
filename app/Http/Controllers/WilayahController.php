<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use App\Models\DapilDprRi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function index()
    {
        // Get statistics for each type
        $statistics = [
            'total_provinsi' => Wilayah::where('tipe', 'provinsi')->count(),
            'total_kabupaten' => Wilayah::where('tipe', 'kabupaten')->count(),
            'total_kecamatan' => Wilayah::where('tipe', 'kecamatan')->count(),
            'total_kelurahan' => Wilayah::where('tipe', 'kelurahan')->count(),
            'total_tps' => Wilayah::where('tipe', 'provinsi')->sum('tps'),
            'total_dpt' => Wilayah::where('tipe', 'provinsi')->sum('jml_dpt'),
        ];

        // Get dapil count per province
        $dapilPerProvince = DapilDprRi::select('wilayah_prov_id', DB::raw('COUNT(DISTINCT dapil_id) as jumlah_dapil'))
            ->groupBy('wilayah_prov_id')
            ->pluck('jumlah_dapil', 'wilayah_prov_id')
            ->toArray();

        // Get province data with aggregated statistics
        $provinsiData = Wilayah::where('tipe', 'provinsi')
            ->orderBy('nama')
            ->get()
            ->map(function ($item, $index) use ($dapilPerProvince) {
                // Get counts per province
                $idProv = $item->id_prov;

                $jumlahKabupaten = Wilayah::where('id_prov', $idProv)
                    ->where('tipe', 'kabupaten')
                    ->distinct('id')
                    ->count();

                $jumlahKecamatan = Wilayah::where('id_prov', $idProv)
                    ->where('tipe', 'kecamatan')
                    ->distinct('id')
                    ->count();

                $jumlahKelurahan = Wilayah::where('id_prov', $idProv)
                    ->where('tipe', 'kelurahan')
                    ->distinct('id')
                    ->count();

                $totalTps = Wilayah::where('id_prov', $idProv)->sum('tps');
                $totalDpt = Wilayah::where('id_prov', $idProv)->sum('jml_dpt');

                return [
                    'nomor' => $index + 1,
                    'provinsi' => $item->nama,
                    'jumlah_dapil' => $dapilPerProvince[$item->id] ?? 0,
                    'jumlah_kabupaten' => $jumlahKabupaten,
                    'jumlah_kecamatan' => $jumlahKecamatan,
                    'jumlah_kelurahan' => $jumlahKelurahan,
                    'total_tps' => $totalTps ?? 0,
                    'total_dpt' => $totalDpt ?? 0,
                ];
            });

        // Check if Inertia is available, otherwise use blade view
        if (request()->wantsJson() || request()->header('X-Inertia')) {
            return Inertia::render('Wilayah/Index', [
                'statistics' => $statistics,
                'provinsiData' => $provinsiData,
            ]);
        }

        return view('wilayah-temp', [
            'statistics' => $statistics,
            'provinsiData' => $provinsiData,
        ]);
    }
}
