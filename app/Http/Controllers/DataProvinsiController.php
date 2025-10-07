<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataProvinsiController extends Controller
{
    public function index(Request $request)
    {
        // Get all provinces
        $provinces = Wilayah::where('tipe', 'provinsi')
            ->orderBy('nama')
            ->get();

        // Default: first province (Aceh)
        $selectedProvinceCode = $request->input('provinsi', $provinces->first()->kode ?? 11);

        // Get selected province info
        $selectedProvince = $provinces->firstWhere('kode', $selectedProvinceCode);

        // Get all parties
        $partaiList = DB::table('partai')
            ->select('nomor_urut', 'partai_singkat', 'nama', 'warna', 'logo_url')
            ->whereIn('nomor_urut', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,24])
            ->orderBy('nomor_urut')
            ->get();

        // Get all dapil in selected province
        $dapilList = DB::table('caleg_dpr_ri')
            ->select('dapil_nama')
            ->where('pro_id', $selectedProvinceCode)
            ->where('caleg_id', '<>', 333333)
            ->groupBy('dapil_nama')
            ->orderBy('dapil_nama')
            ->pluck('dapil_nama');

        // Build dapil data with party votes
        $dapilData = [];
        $partyTotals = [];

        // Initialize party totals
        foreach ($partaiList as $partai) {
            $partyTotals[$partai->nomor_urut] = 0;
        }

        foreach ($dapilList as $dapil) {
            $dapilVotes = [];

            foreach ($partaiList as $partai) {
                $suara = DB::table('caleg_dpr_ri')
                    ->where('pro_id', $selectedProvinceCode)
                    ->where('dapil_nama', $dapil)
                    ->where('partai_id', $partai->nomor_urut)
                    ->where('caleg_id', '<>', 333333)
                    ->sum('suara');

                $dapilVotes[$partai->nomor_urut] = $suara;
                $partyTotals[$partai->nomor_urut] += $suara;
            }

            $dapilData[] = [
                'nama' => $dapil,
                'votes' => $dapilVotes,
                'total' => array_sum($dapilVotes),
            ];
        }

        // Calculate grand total
        $grandTotal = array_sum($partyTotals);

        // Prepare chart data (suara per partai di provinsi)
        $chartData = [];
        foreach ($partaiList as $partai) {
            $chartData[] = [
                'partai' => $partai->partai_singkat,
                'nama' => $partai->nama,
                'warna' => $partai->warna,
                'total_suara' => $partyTotals[$partai->nomor_urut],
            ];
        }

        // Get kabupaten/kota in selected province for map
        $kabupatenList = Wilayah::where('id_prov', $selectedProvince->id_prov)
            ->where('tipe', 'kabupaten')
            ->get();

        // Get province boundary from wilayah_boundaries
        $provinceBoundary = DB::table('wilayah_boundaries')
            ->where('kode', $selectedProvinceCode)
            ->first();

        // Get kabupaten boundaries from wilayah_boundaries (only kabupaten level: xx.xx format)
        $kabupatenBoundaries = DB::table('wilayah_boundaries')
            ->where('kode', 'LIKE', $selectedProvinceCode . '.%')
            ->whereRaw('LENGTH(kode) = 5') // Only kabupaten level (e.g., 11.01, 11.02)
            ->get();

        return view('data-provinsi', [
            'provinces' => $provinces,
            'selectedProvince' => $selectedProvince,
            'partaiList' => $partaiList,
            'dapilData' => $dapilData,
            'partyTotals' => $partyTotals,
            'grandTotal' => $grandTotal,
            'chartData' => $chartData,
            'kabupatenList' => $kabupatenList,
            'provinceBoundary' => $provinceBoundary,
            'kabupatenBoundaries' => $kabupatenBoundaries,
        ]);
    }
}
