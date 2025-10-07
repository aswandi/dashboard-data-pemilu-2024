<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataPartaiController extends Controller
{
    public function index(Request $request)
    {
        $partaiId = $request->input('partai', 1); // Default partai nomor urut 1 (PKB)

        // Get all parties
        $partaiList = DB::table('partai')
            ->select('nomor_urut', 'partai_singkat', 'nama', 'warna', 'logo_url')
            ->whereIn('nomor_urut', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,24])
            ->orderBy('nomor_urut')
            ->get();

        // Get selected party info
        $selectedPartai = $partaiList->firstWhere('nomor_urut', $partaiId);

        // Get all provinces
        $provinces = Wilayah::where('tipe', 'provinsi')
            ->orderBy('nama')
            ->get();

        // Build province data with dapil breakdown
        $provinceData = [];
        $maxDapil = 0;

        foreach ($provinces as $prov) {
            $proId = $prov->kode;

            // Get all dapil for this province with vote count
            $dapilData = DB::table('caleg_dpr_ri')
                ->select('dapil_nama', DB::raw('SUM(suara) as total_suara'))
                ->where('pro_id', $proId)
                ->where('partai_id', $partaiId)
                ->where('caleg_id', '<>', 333333)
                ->groupBy('dapil_nama')
                ->orderBy('dapil_nama')
                ->get()
                ->keyBy('dapil_nama');

            $dapilCount = $dapilData->count();
            if ($dapilCount > $maxDapil) {
                $maxDapil = $dapilCount;
            }

            // Calculate total for province
            $totalSuara = $dapilData->sum('total_suara');

            $provinceData[] = [
                'nama' => $prov->nama,
                'kode' => $prov->kode,
                'jumlah_dapil' => $dapilCount,
                'dapil_votes' => $dapilData->toArray(),
                'total_suara' => $totalSuara,
            ];
        }

        // Calculate grand total
        $grandTotal = array_sum(array_column($provinceData, 'total_suara'));

        // Prepare chart data (suara per provinsi)
        $chartData = [];
        $chartPercentageData = [];

        foreach ($provinceData as $prov) {
            $proId = $prov['kode'];

            // Get total suara ALL partai di provinsi ini
            $totalAllPartai = DB::table('caleg_dpr_ri')
                ->where('pro_id', $proId)
                ->where('caleg_id', '<>', 333333)
                ->sum('suara');

            // Calculate percentage
            $percentage = $totalAllPartai > 0 ? ($prov['total_suara'] / $totalAllPartai * 100) : 0;

            $chartData[] = [
                'nama' => $prov['nama'],
                'total_suara' => $prov['total_suara'],
            ];

            $chartPercentageData[] = [
                'nama' => $prov['nama'],
                'persentase' => round($percentage, 2),
                'total_suara' => $prov['total_suara'],
                'total_all' => $totalAllPartai,
            ];
        }

        // Prepare map data with color gradient (10 levels) - based on absolute votes
        $maxSuara = max(array_column($provinceData, 'total_suara'));
        $minSuara = min(array_column($provinceData, 'total_suara'));

        $mapData = [];
        foreach ($provinceData as $prov) {
            // Calculate gradient level (1-10)
            if ($maxSuara > $minSuara) {
                $level = ceil((($prov['total_suara'] - $minSuara) / ($maxSuara - $minSuara)) * 10);
            } else {
                $level = 5;
            }
            $level = max(1, min(10, $level)); // Ensure 1-10

            // Generate color from light to dark based on party color
            $baseColor = $selectedPartai->warna ?? '#3B82F6';
            $opacity = 0.1 + ($level * 0.09); // 0.1 to 1.0

            $mapData[] = [
                'nama' => $prov['nama'],
                'kode' => $prov['kode'],
                'total_suara' => $prov['total_suara'],
                'level' => $level,
                'color' => $this->adjustColorOpacity($baseColor, $opacity),
            ];
        }

        // Prepare map data based on percentage - for second map
        $percentages = array_column($chartPercentageData, 'persentase');
        $maxPercentage = max($percentages);
        $minPercentage = min($percentages);

        $mapPercentageData = [];
        foreach ($chartPercentageData as $prov) {
            // Calculate gradient level based on percentage (1-10)
            if ($maxPercentage > $minPercentage) {
                $level = ceil((($prov['persentase'] - $minPercentage) / ($maxPercentage - $minPercentage)) * 10);
            } else {
                $level = 5;
            }
            $level = max(1, min(10, $level)); // Ensure 1-10

            // Generate color from light to dark based on party color
            $baseColor = $selectedPartai->warna ?? '#3B82F6';
            $opacity = 0.1 + ($level * 0.09); // 0.1 to 1.0

            // Find matching province code
            $kode = '';
            foreach ($provinceData as $p) {
                if ($p['nama'] === $prov['nama']) {
                    $kode = $p['kode'];
                    break;
                }
            }

            $mapPercentageData[] = [
                'nama' => $prov['nama'],
                'kode' => $kode,
                'persentase' => $prov['persentase'],
                'total_suara' => $prov['total_suara'],
                'total_all' => $prov['total_all'],
                'level' => $level,
                'color' => $this->adjustColorOpacity($baseColor, $opacity),
            ];
        }

        return view('data-partai', [
            'partaiList' => $partaiList,
            'selectedPartai' => $selectedPartai,
            'provinceData' => $provinceData,
            'maxDapil' => $maxDapil,
            'grandTotal' => $grandTotal,
            'chartData' => $chartData,
            'chartPercentageData' => $chartPercentageData,
            'mapData' => $mapData,
            'mapPercentageData' => $mapPercentageData,
        ]);
    }

    private function adjustColorOpacity($hexColor, $opacity)
    {
        // Convert hex to RGB
        $hex = str_replace('#', '', $hexColor);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Create lighter to darker shade
        // opacity dari 0.1 (terang) ke 1.0 (pekat)
        // Blend dengan putih untuk level rendah, full color untuk level tinggi
        $white = 255;
        $r = round($white + ($r - $white) * $opacity);
        $g = round($white + ($g - $white) * $opacity);
        $b = round($white + ($b - $white) * $opacity);

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
