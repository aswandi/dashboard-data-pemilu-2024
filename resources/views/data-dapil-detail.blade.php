<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Dapil {{ $dapilNama }} - {{ $province->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .dropdown::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            height: 0.5rem;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 shadow-2xl border-b-4 border-cyan-500">
        <div class="container mx-auto px-6 py-6">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center gap-6 hover:opacity-80 transition-opacity duration-300">
                    <img src="/lampiran/logo-polmark-tp.png" alt="Polmark Indonesia" class="h-16 w-auto object-contain drop-shadow-[0_0_25px_rgba(56,189,248,0.8)] brightness-110">
                    <div>
                        <h1 class="text-3xl font-extrabold bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent tracking-tight">
                            DASHBOARD DATA PEMILU 2024
                        </h1>
                        <p class="text-orange-400 font-bold text-lg tracking-widest mt-1">POLMARK INDONESIA</p>
                    </div>
                </a>

                <div class="flex items-center gap-4">
                    <div class="relative dropdown">
                        <button class="bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-bold px-6 py-3 rounded-lg shadow-lg transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            DPR RI
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute right-0 mt-2 w-56 bg-slate-800 rounded-lg shadow-2xl border border-cyan-500 overflow-hidden" style="z-index: 9999;">
                            <a href="/data-utama/partai" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">PARTAI</div>
                                <div class="text-xs text-gray-400">Data per Partai</div>
                            </a>
                            <a href="/data-utama/provinsi" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">PROVINSI</div>
                                <div class="text-xs text-gray-400">Data per Provinsi</div>
                            </a>
                            <a href="/data-utama/dapil" class="block px-6 py-3 text-cyan-400 bg-gradient-to-r from-cyan-600/20 to-blue-600/20 hover:from-cyan-600 hover:to-blue-600 hover:text-white transition-all duration-200">
                                <div class="font-bold">DAPIL</div>
                                <div class="text-xs">Data per Dapil</div>
                            </a>
                        </div>
                    </div>

                    <a href="/data-utama/dapil" class="bg-gray-600 hover:bg-gray-500 text-white font-bold px-6 py-3 rounded-lg shadow-lg transition-all duration-300">
                        &larr; Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <!-- Title Section -->
        <div class="relative bg-gradient-to-br from-white via-blue-50 to-cyan-50 rounded-2xl shadow-2xl p-8 border border-blue-200 mb-6 overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
                <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-cyan-200/30 to-blue-300/30 rounded-full blur-3xl animate-pulse"></div>
            </div>
            <div class="relative z-10">
                <h2 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-600 mb-2">
                    {{ $dapilNama }}
                </h2>
                <p class="text-gray-600 text-xl mb-2">{{ $province->nama }}</p>
                <p class="text-gray-500">Alokasi Kursi: <span class="font-bold text-2xl text-blue-600">{{ $jmlKursi }} Kursi</span></p>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-100 border-l-4 border-blue-600 p-4 mb-6 rounded-lg">
            <p class="text-blue-800">
                <strong>Metode Perhitungan:</strong> Sainte-Laguë (Divisor: 1, 3, 5, 7, ...)
            </p>
        </div>

        <!-- Seat Allocation Table -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Alokasi Kursi Per Partai</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">NO</th>
                            <th class="px-4 py-3 text-left">PARTAI</th>
                            <th class="px-4 py-3 text-right">SUARA</th>
                            <th class="px-4 py-3 text-right">% PARTAI</th>
                            <th class="px-4 py-3 text-center">KURSI 1</th>
                            <th class="px-4 py-3 text-right">SISA SUARA</th>
                            <th class="px-4 py-3 text-center">KURSI 2</th>
                            <th class="px-4 py-3 text-right">SISA SUARA</th>
                            <th class="px-4 py-3 text-center">KURSI 3</th>
                            <th class="px-4 py-3 text-center font-bold">TOTAL KURSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalSuara = 0;
                            $totalKursi = 0;
                        @endphp

                        @foreach($seatAllocation as $index => $party)
                            @php
                                $totalSuara += $party['suara'];
                                $totalKursi += $party['total_kursi'];
                            @endphp
                            <tr class="border-b hover:bg-blue-50 transition-colors {{ $party['total_kursi'] > 0 ? 'bg-green-50' : '' }}">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 h-4 rounded" style="background-color: {{ $party['warna'] }}"></div>
                                        <span class="font-semibold">{{ $party['partai_singkat'] }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right font-semibold">{{ number_format($party['suara']) }}</td>
                                <td class="px-4 py-3 text-right">{{ number_format($party['persentase'], 2) }}%</td>
                                <td class="px-4 py-3 text-center {{ $party['kursi_1'] > 0 ? 'bg-blue-100 font-bold' : '' }}">
                                    {{ $party['kursi_1'] }}
                                </td>
                                <td class="px-4 py-3 text-right text-gray-500">
                                    {{ $party['kursi_1'] > 0 ? number_format($party['sisa_suara_1']) : '-' }}
                                </td>
                                <td class="px-4 py-3 text-center {{ $party['kursi_2'] > 0 ? 'bg-blue-100 font-bold' : '' }}">
                                    {{ $party['kursi_2'] }}
                                </td>
                                <td class="px-4 py-3 text-right text-gray-500">
                                    {{ $party['kursi_2'] > 0 ? number_format($party['sisa_suara_2']) : '-' }}
                                </td>
                                <td class="px-4 py-3 text-center {{ $party['kursi_3'] > 0 ? 'bg-blue-100 font-bold' : '' }}">
                                    {{ $party['kursi_3'] }}
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-lg {{ $party['total_kursi'] > 0 ? 'text-blue-600' : 'text-gray-400' }}">
                                    {{ $party['total_kursi'] }}
                                </td>
                            </tr>
                        @endforeach

                        <!-- Total Row -->
                        <tr class="bg-yellow-50 font-bold border-t-2 border-yellow-400">
                            <td class="px-4 py-3" colspan="2">TOTAL</td>
                            <td class="px-4 py-3 text-right">{{ number_format($totalSuara) }}</td>
                            <td class="px-4 py-3 text-right">100.00%</td>
                            <td class="px-4 py-3 text-center">-</td>
                            <td class="px-4 py-3 text-right">-</td>
                            <td class="px-4 py-3 text-center">-</td>
                            <td class="px-4 py-3 text-right">-</td>
                            <td class="px-4 py-3 text-center">-</td>
                            <td class="px-4 py-3 text-center text-blue-600 text-xl">{{ $totalKursi }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Explanation -->
        <div class="mt-6 bg-gray-50 border border-gray-300 rounded-lg p-6">
            <h4 class="font-bold text-lg text-gray-800 mb-3">Penjelasan Metode Sainte-Laguë</h4>
            <ul class="list-disc list-inside space-y-2 text-gray-700">
                <li>Setiap partai mendapat kursi berdasarkan quotient tertinggi (suara dibagi divisor)</li>
                <li>Divisor yang digunakan: 1, 3, 5, 7, 9, ... (bilangan ganjil)</li>
                <li>Kursi 1, 2, 3 menunjukkan tahapan pembagian kursi</li>
                <li>Sisa suara dihitung setelah setiap pembagian kursi</li>
                <li>Partai dengan total kursi lebih banyak ditampilkan di atas</li>
            </ul>
        </div>
    </div>
</body>
</html>
