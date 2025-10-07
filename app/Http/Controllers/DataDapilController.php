<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataDapilController extends Controller
{
    public function index()
    {
        // Get all parties
        $partaiList = DB::table('partai')
            ->select('nomor_urut', 'partai_singkat', 'nama', 'warna')
            ->whereIn('nomor_urut', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,24])
            ->orderBy('nomor_urut')
            ->get();

        // Get all provinces
        $provinces = Wilayah::where('tipe', 'provinsi')
            ->orderBy('nama')
            ->get();

        // Build dapil data
        $dapilData = [];
        $totalRow = [];

        // Initialize party totals
        foreach ($partaiList as $partai) {
            $totalRow['partai_' . $partai->nomor_urut] = 0;
        }
        $totalRow['total'] = 0;

        foreach ($provinces as $prov) {
            $proId = $prov->kode;

            // Get all dapil in this province
            $dapils = DB::table('caleg_dpr_ri')
                ->select('dapil_nama')
                ->where('pro_id', $proId)
                ->where('caleg_id', '<>', 333333)
                ->distinct()
                ->orderBy('dapil_nama')
                ->pluck('dapil_nama');

            foreach ($dapils as $dapilNama) {
                $row = [
                    'provinsi' => $prov->nama,
                    'pro_id' => $proId,
                    'dapil' => $dapilNama,
                ];

                $rowTotal = 0;

                // Get votes per party for this dapil
                foreach ($partaiList as $partai) {
                    $suara = DB::table('caleg_dpr_ri')
                        ->where('pro_id', $proId)
                        ->where('dapil_nama', $dapilNama)
                        ->where('partai_id', $partai->nomor_urut)
                        ->where('caleg_id', '<>', 333333)
                        ->sum('suara');

                    $row['partai_' . $partai->nomor_urut] = $suara;
                    $totalRow['partai_' . $partai->nomor_urut] += $suara;
                    $rowTotal += $suara;
                }

                $row['total'] = $rowTotal;
                $totalRow['total'] += $rowTotal;

                $dapilData[] = $row;
            }
        }

        // Prepare map data - color by total votes per province
        $provinceVotes = [];
        foreach ($dapilData as $row) {
            $proId = $row['pro_id'];
            if (!isset($provinceVotes[$proId])) {
                $provinceVotes[$proId] = [
                    'nama' => $row['provinsi'],
                    'kode' => $proId,
                    'total_suara' => 0,
                ];
            }
            $provinceVotes[$proId]['total_suara'] += $row['total'];
        }

        $maxSuara = max(array_column($provinceVotes, 'total_suara'));
        $minSuara = min(array_column($provinceVotes, 'total_suara'));

        $mapData = [];
        foreach ($provinceVotes as $prov) {
            // Calculate gradient level (1-10)
            if ($maxSuara > $minSuara) {
                $level = ceil((($prov['total_suara'] - $minSuara) / ($maxSuara - $minSuara)) * 10);
            } else {
                $level = 5;
            }
            $level = max(1, min(10, $level));

            $opacity = 0.1 + ($level * 0.09);

            $mapData[] = [
                'nama' => $prov['nama'],
                'kode' => $prov['kode'],
                'total_suara' => $prov['total_suara'],
                'level' => $level,
                'color' => $this->adjustColorOpacity('#3B82F6', $opacity),
            ];
        }

        return view('data-dapil', [
            'partaiList' => $partaiList,
            'dapilData' => $dapilData,
            'totalRow' => $totalRow,
            'mapData' => $mapData,
        ]);
    }

    public function detail($proId, $dapilNama)
    {
        // Decode URL parameter
        $dapilNama = urldecode($dapilNama);

        // Get province info
        $province = Wilayah::where('kode', $proId)->where('tipe', 'provinsi')->first();

        if (!$province) {
            abort(404, 'Province not found');
        }

        // Get all parties
        $partaiList = DB::table('partai')
            ->select('nomor_urut', 'partai_singkat', 'nama', 'warna')
            ->whereIn('nomor_urut', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,24])
            ->orderBy('nomor_urut')
            ->get();

        // Get total seats for this dapil from dapil_dpr_ri table
        $jmlKursi = DB::table('dapil_dpr_ri')
            ->where('pro_id', $proId)
            ->where('dapil_nama', $dapilNama)
            ->value('jumlah_kursi') ?? 0;

        // Get votes per party
        $votes = [];
        foreach ($partaiList as $partai) {
            $suara = DB::table('caleg_dpr_ri')
                ->where('pro_id', $proId)
                ->where('dapil_nama', $dapilNama)
                ->where('partai_id', $partai->nomor_urut)
                ->where('caleg_id', '<>', 333333)
                ->sum('suara');

            $votes[] = [
                'partai_id' => $partai->nomor_urut,
                'partai_nama' => $partai->nama,
                'partai_singkat' => $partai->partai_singkat,
                'warna' => $partai->warna,
                'suara' => $suara,
            ];
        }

        // Calculate total votes
        $totalVotes = array_sum(array_column($votes, 'suara'));

        // Calculate seat allocation using Sainte-Laguë method
        $seatAllocation = $this->calculateSainteLague($votes, $jmlKursi);

        return view('data-dapil-detail', [
            'province' => $province,
            'dapilNama' => $dapilNama,
            'jmlKursi' => $jmlKursi,
            'seatAllocation' => $seatAllocation,
            'totalVotes' => $totalVotes,
        ]);
    }

    private function calculateSainteLague($votes, $totalSeats)
    {
        $results = [];
        $divisors = [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23, 25]; // Extend if needed

        foreach ($votes as $party) {
            $results[] = [
                'partai_id' => $party['partai_id'],
                'partai_nama' => $party['partai_nama'],
                'partai_singkat' => $party['partai_singkat'],
                'warna' => $party['warna'],
                'suara' => $party['suara'],
                'kursi_1' => 0,
                'sisa_suara_1' => 0,
                'kursi_2' => 0,
                'sisa_suara_2' => 0,
                'kursi_3' => 0,
                'total_kursi' => 0,
            ];
        }

        // Calculate quotient for each seat allocation
        $quotients = [];

        foreach ($results as $idx => $party) {
            if ($party['suara'] > 0) {
                // First division by 1
                $quotients[] = [
                    'party_idx' => $idx,
                    'quotient' => $party['suara'] / 1,
                    'divisor' => 1,
                ];
            }
        }

        // Sort by quotient descending
        usort($quotients, function($a, $b) {
            return $b['quotient'] <=> $a['quotient'];
        });

        // Allocate seats based on highest quotient
        $seatsAllocated = 0;
        $seatRound = 1; // Track which round of allocation

        while ($seatsAllocated < $totalSeats && !empty($quotients)) {
            // Take the highest quotient
            $winner = array_shift($quotients);
            $partyIdx = $winner['party_idx'];

            // Allocate seat
            if ($seatRound <= 3) {
                $results[$partyIdx]['kursi_' . $seatRound]++;
            }
            $results[$partyIdx]['total_kursi']++;
            $seatsAllocated++;

            // Calculate next quotient for this party
            $nextSeatNum = $results[$partyIdx]['total_kursi'];
            if ($nextSeatNum < count($divisors)) {
                $divisor = $divisors[$nextSeatNum]; // Next odd divisor
                $nextQuotient = $results[$partyIdx]['suara'] / $divisor;

                // Insert new quotient in sorted position
                $newQuotient = [
                    'party_idx' => $partyIdx,
                    'quotient' => $nextQuotient,
                    'divisor' => $divisor,
                ];

                // Find insertion point
                $inserted = false;
                for ($i = 0; $i < count($quotients); $i++) {
                    if ($nextQuotient > $quotients[$i]['quotient']) {
                        array_splice($quotients, $i, 0, [$newQuotient]);
                        $inserted = true;
                        break;
                    }
                }
                if (!$inserted) {
                    $quotients[] = $newQuotient;
                }
            }

            // Check if we need to move to next round
            if ($seatsAllocated % ceil($totalSeats / 3) == 0 && $seatRound < 3) {
                $seatRound++;
            }
        }

        // Calculate remaining votes (sisa suara) after each round
        foreach ($results as $idx => $party) {
            if ($party['kursi_1'] > 0) {
                $results[$idx]['sisa_suara_1'] = $party['suara'] - ($party['kursi_1'] * ($party['suara'] / $party['kursi_1']));
            }
            if ($party['kursi_2'] > 0) {
                $results[$idx]['sisa_suara_2'] = $results[$idx]['sisa_suara_1'] - ($party['kursi_2'] * ($party['suara'] / ($party['kursi_1'] + $party['kursi_2'])));
            }
        }

        // Calculate percentages
        $totalVotes = array_sum(array_column($results, 'suara'));
        foreach ($results as $idx => $party) {
            $results[$idx]['persentase'] = $totalVotes > 0 ? ($party['suara'] / $totalVotes * 100) : 0;
        }

        // Sort by total seats descending
        usort($results, function($a, $b) {
            if ($b['total_kursi'] == $a['total_kursi']) {
                return $b['suara'] <=> $a['suara'];
            }
            return $b['total_kursi'] <=> $a['total_kursi'];
        });

        return $results;
    }

    private function adjustColorOpacity($hexColor, $opacity)
    {
        $hex = str_replace('#', '', $hexColor);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $white = 255;
        $r = round($white + ($r - $white) * $opacity);
        $g = round($white + ($g - $white) * $opacity);
        $b = round($white + ($b - $white) * $opacity);

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
