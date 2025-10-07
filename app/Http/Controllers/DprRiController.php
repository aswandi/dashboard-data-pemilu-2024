<?php

namespace App\Http\Controllers;

use App\Models\CalegiDprRi;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DprRiController extends Controller
{
    public function index(Request $request)
    {
        // Base query untuk filter
        $baseQuery = function() use ($request) {
            $query = CalegiDprRi::query();

            if ($request->filled('provinsi')) {
                $query->where('pro_nama', $request->provinsi);
            }

            if ($request->filled('dapil')) {
                $query->where('dapil_nama', $request->dapil);
            }

            if ($request->filled('partai')) {
                $query->where('partai_politik', $request->partai);
            }

            return $query;
        };

        // Ambil data untuk filter dropdown
        $provinsiList = CalegiDprRi::select('pro_nama')
            ->distinct()
            ->orderBy('pro_nama')
            ->pluck('pro_nama');

        $dapilList = CalegiDprRi::select('dapil_nama')
            ->when($request->filled('provinsi'), function ($q) use ($request) {
                $q->where('pro_nama', $request->provinsi);
            })
            ->distinct()
            ->orderBy('dapil_nama')
            ->pluck('dapil_nama');

        $partaiList = CalegiDprRi::select('partai_politik')
            ->distinct()
            ->orderBy('partai_politik')
            ->pluck('partai_politik');

        // Pagination - gunakan query baru
        $perPage = $request->input('per_page', 10);
        $calegData = $baseQuery()
            ->orderBy('pro_nama')
            ->orderBy('dapil_nama')
            ->orderBy('partai_politik')
            ->orderBy('nomor_urut')
            ->paginate($perPage)
            ->withQueryString();

        // Data untuk grafik - gunakan query baru dengan join ke tabel partai
        $chartData = $baseQuery()
            ->join('partai', \DB::raw('caleg_dpr_ri.partai_politik COLLATE utf8mb4_unicode_ci'), '=', 'partai.nama')
            ->select(
                'caleg_dpr_ri.partai_politik',
                'partai.partai_singkat',
                'partai.nomor_urut as partai_nomor_urut',
                'partai.warna as partai_warna',
                \DB::raw('SUM(caleg_dpr_ri.suara) as total_suara')
            )
            ->groupBy('caleg_dpr_ri.partai_politik', 'partai.partai_singkat', 'partai.nomor_urut', 'partai.warna')
            ->orderBy('partai.nomor_urut', 'asc')
            ->get()
            ->map(function ($item) {
                // Generate logo path berdasarkan nomor urut
                $item->partai_logo = asset('lampiran/partai/' . $item->partai_nomor_urut . '.jpg');
                return $item;
            });

        // Hitung total suara untuk persentase
        $totalSuaraKeseluruhan = $chartData->sum('total_suara');

        // Data untuk peta - gunakan query baru dengan partai pemenang
        $mapData = $baseQuery()
            ->join('partai', \DB::raw('caleg_dpr_ri.partai_politik COLLATE utf8mb4_unicode_ci'), '=', 'partai.nama')
            ->select(
                'caleg_dpr_ri.pro_id',
                'caleg_dpr_ri.pro_nama',
                'caleg_dpr_ri.partai_politik',
                'partai.partai_singkat',
                'partai.warna as partai_warna',
                \DB::raw('SUM(caleg_dpr_ri.suara) as total_suara')
            )
            ->groupBy('caleg_dpr_ri.pro_id', 'caleg_dpr_ri.pro_nama', 'caleg_dpr_ri.partai_politik', 'partai.partai_singkat', 'partai.warna')
            ->get()
            ->groupBy('pro_id')
            ->map(function ($partaiPerProv, $proId) {
                // Cari partai dengan suara terbanyak
                $topPartai = $partaiPerProv->sortByDesc('total_suara')->first();
                $totalSuaraProvinsi = $partaiPerProv->sum('total_suara');

                // Get top 3 partai untuk tooltip
                $top3Partai = $partaiPerProv->sortByDesc('total_suara')->take(3)->map(function ($item) {
                    return [
                        'nama' => $item->partai_singkat,
                        'nama_lengkap' => $item->partai_politik,
                        'suara' => $item->total_suara
                    ];
                })->values();

                return [
                    'kode' => $proId,
                    'nama' => $topPartai->pro_nama,
                    'total_suara' => $totalSuaraProvinsi,
                    'warna' => $topPartai->partai_warna,
                    'top_partai' => $top3Partai,
                ];
            })
            ->values();

        return Inertia::render('DprRi/Index', [
            'calegData' => $calegData,
            'filters' => [
                'provinsi' => $request->provinsi,
                'dapil' => $request->dapil,
                'partai' => $request->partai,
                'per_page' => $perPage,
            ],
            'provinsiList' => $provinsiList,
            'dapilList' => $dapilList,
            'partaiList' => $partaiList,
            'chartData' => $chartData,
            'totalSuara' => $totalSuaraKeseluruhan,
            'mapData' => $mapData,
        ]);
    }
}
