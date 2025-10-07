<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChangelogController extends Controller
{
    public function index()
    {
        $changelogs = [
            [
                'version' => 'v1.5.0',
                'date' => '2025-01-15',
                'changes' => [
                    'Menambahkan halaman Data Provinsi dengan breakdown per dapil',
                    'Menambahkan footer dengan copyright dan link changelog',
                    'Menambahkan peta provinsi dengan batas kabupaten/kota',
                ]
            ],
            [
                'version' => 'v1.4.0',
                'date' => '2025-01-14',
                'changes' => [
                    'Menambahkan halaman Data Partai dengan analisis per provinsi dan dapil',
                    'Menambahkan dual map system (absolut dan persentase)',
                    'Implementasi color gradation 10 level untuk visualisasi peta',
                    'Perbaikan algoritma warna gradasi (darker = more votes)',
                ]
            ],
            [
                'version' => 'v1.3.0',
                'date' => '2025-01-13',
                'changes' => [
                    'Menambahkan logo partai pada grafik (menggantikan angka)',
                    'Optimasi responsive layout untuk 18 partai dalam grafik',
                    'Perbaikan bug pagination saat menampilkan semua data',
                    'Perbaikan bug nilai PKB yang berubah jadi nomor urut',
                ]
            ],
            [
                'version' => 'v1.2.0',
                'date' => '2025-01-12',
                'changes' => [
                    'Perbaikan perhitungan DPT menggunakan data provinsi langsung',
                    'Menambahkan baris total suara partai di tabel provinsi',
                    'Filter data untuk exclude caleg_id 333333 (total agregat)',
                    'Perbaikan operator query dari != ke <> untuk konsistensi data',
                ]
            ],
            [
                'version' => 'v1.1.0',
                'date' => '2025-01-11',
                'changes' => [
                    'Redesign tampilan dari dark theme ke light/modern theme',
                    'Menambahkan animasi dan gradasi background',
                    'Update header dengan logo Polmark Indonesia baru',
                    'Menambahkan dropdown menu navigasi DATA dan PETA SUARA',
                ]
            ],
            [
                'version' => 'v1.0.0',
                'date' => '2025-01-10',
                'changes' => [
                    'Rilis awal Dashboard Data Pemilu 2024',
                    'Implementasi peta suara DPR RI interaktif',
                    'Visualisasi grafik suara partai',
                    'Tabel data suara partai per provinsi dengan pagination',
                ]
            ],
        ];

        return view('changelog', compact('changelogs'));
    }
}
