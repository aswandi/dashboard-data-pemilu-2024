<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Suara - Pusat Data Pemilu 2024</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map {
            height: 600px;
            width: 100%;
        }
        .leaflet-tooltip {
            background-color: white;
            border: 2px solid #1E40AF;
            border-radius: 8px;
            padding: 0;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
        .leaflet-tooltip-top:before {
            border-top-color: #1E40AF;
        }
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
        /* Tambahkan area invisible untuk mencegah menu hilang */
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
    <!-- Main Header -->
    <div class="bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 shadow-2xl border-b-4 border-cyan-500">
        <div class="container mx-auto px-6 py-6">
            <div class="flex items-center justify-between">
                <!-- Logo and Title -->
                <a href="/" class="flex items-center gap-6 hover:opacity-80 transition-opacity duration-300">
                    <img src="/lampiran/logo-polmark-tp.png" alt="Polmark Indonesia" class="h-16 w-auto object-contain drop-shadow-[0_0_25px_rgba(56,189,248,0.8)] brightness-110">
                    <div>
                        <h1 class="text-3xl font-extrabold bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent tracking-tight">
                            DASHBOARD DATA PEMILU 2024
                        </h1>
                        <p class="text-orange-400 font-bold text-lg tracking-widest mt-1">POLMARK INDONESIA</p>
                    </div>
                </a>

                <!-- Navigation Menu -->
                <div class="flex items-center gap-4">
                    <!-- Dropdown Menu DATA -->
                    <div class="relative dropdown">
                        <button class="bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-bold px-6 py-3 rounded-lg shadow-lg transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            DATA
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute right-0 mt-2 w-56 bg-slate-800 rounded-lg shadow-2xl border border-cyan-500 overflow-hidden" style="z-index: 9999;">
                            <a href="/data-utama/nasional" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">NASIONAL</div>
                                <div class="text-xs text-gray-400">Data Nasional</div>
                            </a>
                            <a href="/data-utama/partai" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">PARTAI</div>
                                <div class="text-xs text-gray-400">Data per Partai</div>
                            </a>
                            <a href="/data-utama/provinsi" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">PROVINSI</div>
                                <div class="text-xs text-gray-400">Data per Provinsi</div>
                            </a>
                            <a href="/data-utama/dapil" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200">
                                <div class="font-bold">DAPIL</div>
                                <div class="text-xs text-gray-400">Data per Dapil</div>
                            </a>
                        </div>
                    </div>

                    <!-- Dropdown Menu PETA SUARA -->
                    <div class="relative dropdown">
                        <button class="bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-bold px-6 py-3 rounded-lg shadow-lg transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            PETA SUARA
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute right-0 mt-2 w-56 bg-slate-800 rounded-lg shadow-2xl border border-cyan-500 overflow-hidden" style="z-index: 9999;">
                            <a href="/peta-suara/pilpres" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">PILPRES</div>
                                <div class="text-xs text-gray-400">Pemilihan Presiden</div>
                            </a>
                            <a href="/peta-suara/dpd" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">DPD</div>
                                <div class="text-xs text-gray-400">Dewan Perwakilan Daerah</div>
                            </a>
                            <a href="/peta-suara" class="block px-6 py-3 text-cyan-400 bg-gradient-to-r from-cyan-600/20 to-blue-600/20 hover:from-cyan-600 hover:to-blue-600 hover:text-white transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">DPR RI</div>
                                <div class="text-xs">Dewan Perwakilan Rakyat</div>
                            </a>
                            <a href="/peta-suara/dprd-prov" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">DPRD PROVINSI</div>
                                <div class="text-xs text-gray-400">DPRD Tingkat Provinsi</div>
                            </a>
                            <a href="/peta-suara/dprd-kabkota" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200">
                                <div class="font-bold">DPRD KAB/KOTA</div>
                                <div class="text-xs text-gray-400">DPRD Kabupaten/Kota</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Page Title -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Peta Suara DPR RI</h2>
                    <p class="text-gray-600 mt-2">Arahkan mouse ke provinsi untuk melihat data detail dan 3 partai suara terbanyak. Warna provinsi menunjukkan partai pemenang.</p>
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div id="map" class="rounded-lg"></div>
            
            <!-- Map Legend -->
            <div class="relative mt-6 p-6 bg-gradient-to-br from-white via-blue-50 to-cyan-50 rounded-xl border-2 border-blue-200 shadow-lg overflow-hidden">
                <!-- Animated Background -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-cyan-200/20 to-blue-300/20 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-blue-200/20 to-purple-200/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>

                <h3 class="relative text-lg font-bold bg-gradient-to-r from-blue-700 to-cyan-600 bg-clip-text text-transparent mb-4">Legend Partai Pemenang</h3>
                <div id="mapLegend" class="relative grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                    <!-- Legend items will be populated by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Bar Chart Section -->
        <div class="relative bg-gradient-to-br from-white via-blue-50 to-cyan-50 rounded-2xl shadow-2xl p-8 border border-blue-200 mb-6 overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
                <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-cyan-200/30 to-blue-300/30 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-blue-200/30 to-cyan-300/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-gradient-to-r from-indigo-200/20 to-purple-200/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            </div>

            <h2 class="relative text-3xl font-bold bg-gradient-to-r from-blue-700 via-cyan-600 to-blue-700 bg-clip-text text-transparent mb-8 drop-shadow-sm">
                GRAFIK SUARA PARTAI
            </h2>

            <div class="relative w-full">
                <div class="flex justify-between items-end gap-1 w-full">
                    @php
                        $maxSuara = max(array_column($totalSuaraPartai, 'total_suara'));
                    @endphp

                    @foreach($totalSuaraPartai as $partai)
                    @php
                        $heightPercent = $maxSuara > 0 ? ($partai['total_suara'] / $maxSuara * 100) : 0;
                    @endphp
                    <div class="flex flex-col items-center flex-1 max-w-[5.5%]">
                        <!-- Percentage Label -->
                        <div class="text-gray-800 font-bold text-[10px] mb-1 h-5 bg-white/70 backdrop-blur-sm px-1 py-0.5 rounded shadow-sm whitespace-nowrap">
                            {{ number_format($partai['persentase'], 1) }}%
                        </div>

                        <!-- Bar Container -->
                        <div class="relative w-full h-56 bg-gradient-to-b from-gray-100 to-gray-200 rounded-lg border border-white shadow-lg flex items-end p-0.5 backdrop-blur-sm">
                            <div class="w-full rounded-t-lg transition-all duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer transform"
                                 style="height: {{ $heightPercent }}%; background: linear-gradient(180deg, {{ $partai['warna'] }}, {{ $partai['warna'] }}dd); box-shadow: 0 -5px 25px {{ $partai['warna'] }}60, 0 0 15px {{ $partai['warna'] }}40;"
                                 title="{{ $partai['nama'] }}: {{ number_format($partai['total_suara']) }} suara">
                            </div>
                        </div>

                        <!-- Party Logo -->
                        <div class="mt-2 w-9 h-9 rounded-full flex items-center justify-center border border-white shadow-md bg-white overflow-hidden"
                             style="box-shadow: 0 2px 10px {{ $partai['warna'] }}60;">
                            <img src="/lampiran/partai/{{ $partai['nomor_urut'] }}.jpg"
                                 alt="{{ $partai['partai_singkat'] }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center font-bold text-white text-[10px]\' style=\'background-color: {{ $partai['warna'] }};\'>{{ $partai['nomor_urut'] }}</div>';">
                        </div>

                        <!-- Party Name -->
                        <div class="text-gray-700 text-[10px] font-bold mt-1 text-center leading-tight">
                            {{ $partai['partai_singkat'] }}
                        </div>

                        <!-- Total Votes -->
                        <div class="text-blue-700 text-[9px] font-bold mt-0.5 bg-white/60 backdrop-blur-sm px-1 py-0.5 rounded shadow-sm whitespace-nowrap">
                            {{ number_format($partai['total_suara']) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Party Votes Table -->
        <div class="relative bg-gradient-to-br from-white via-blue-50 to-cyan-50 rounded-2xl shadow-2xl p-8 border border-blue-200 overflow-hidden">
            <!-- Animated Background -->
            <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
                <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-cyan-200/30 to-blue-300/30 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-blue-200/30 to-cyan-300/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-gradient-to-r from-indigo-200/20 to-purple-200/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            </div>

            <!-- Filter and Controls -->
            <div class="relative flex items-center justify-between mb-6 gap-4">
                <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-700 via-cyan-600 to-blue-700 bg-clip-text text-transparent drop-shadow-sm">
                    Data Suara Partai per Provinsi
                </h2>

                <div class="flex items-center gap-4">
                    <!-- Filter Provinsi -->
                    <div class="flex items-center gap-2">
                        <label class="text-gray-700 text-sm font-semibold">Provinsi:</label>
                        <select id="provinceFilter" class="bg-white/80 backdrop-blur-sm text-gray-800 border-2 border-blue-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 shadow-sm">
                            <option value="">Semua Provinsi</option>
                            @foreach($provinces as $prov)
                            <option value="{{ $prov['nama'] }}">{{ $prov['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rows per page -->
                    <div class="flex items-center gap-2">
                        <label class="text-gray-700 text-sm font-semibold">Tampilkan:</label>
                        <select id="rowsPerPage" class="bg-white/80 backdrop-blur-sm text-gray-800 border-2 border-blue-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 shadow-sm">
                            <option value="10">10 baris</option>
                            <option value="15">15 baris</option>
                            <option value="20">20 baris</option>
                            <option value="38">Semua</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="relative flex items-center justify-end mb-6">
                <div class="flex gap-4 text-xs bg-white/60 backdrop-blur-sm px-4 py-2 rounded-lg shadow-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded bg-gradient-to-r from-yellow-400 to-yellow-500 shadow-lg shadow-yellow-500/50"></div>
                        <span class="text-gray-700 font-semibold">Peringkat 1</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded bg-gradient-to-r from-gray-300 to-gray-400 shadow-lg shadow-gray-400/50"></div>
                        <span class="text-gray-700 font-semibold">Peringkat 2</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded bg-gradient-to-r from-orange-600 to-orange-700 shadow-lg shadow-orange-600/50"></div>
                        <span class="text-gray-700 font-semibold">Peringkat 3</span>
                    </div>
                </div>
            </div>
            <div class="relative overflow-x-auto rounded-xl border-2 border-white shadow-lg">
                <table class="min-w-full divide-y divide-blue-200 text-xs">
                    <thead class="bg-gradient-to-r from-blue-100 via-cyan-100 to-blue-100">
                        <tr>
                            <th class="px-4 py-4 text-left font-bold text-blue-800 uppercase tracking-wider sticky left-0 bg-blue-100 z-10 border-r border-blue-200">No</th>
                            <th class="px-4 py-4 text-left font-bold text-blue-800 uppercase tracking-wider sticky left-12 bg-blue-100 z-10 border-r border-blue-200" style="min-width: 200px;">Provinsi</th>
                            <th class="px-4 py-4 text-right font-bold text-blue-800 uppercase tracking-wider border-r border-blue-200">Jumlah DPT</th>
                            @foreach($partaiList as $partai)
                            <th class="px-4 py-4 text-center font-bold text-blue-800 uppercase tracking-wider border-r border-blue-200" title="{{ $partai->nama }}">
                                <div class="flex flex-col items-center gap-1">
                                    <div class="w-6 h-6 rounded-full border-2 border-white shadow-md" style="background-color: {{ $partai->warna }}; box-shadow: 0 0 10px {{ $partai->warna }}60;"></div>
                                    <span>{{ $partai->partai_singkat }}</span>
                                </div>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white/80 backdrop-blur-sm divide-y divide-blue-100" id="tableBody">
                        <!-- Total Row -->
                        <tr class="bg-gradient-to-r from-blue-200/60 via-cyan-200/60 to-blue-200/60 font-bold border-y-2 border-blue-300" id="totalRow">
                            <td class="px-4 py-4 whitespace-nowrap sticky left-0 bg-blue-200/60 backdrop-blur-sm z-10 border-r border-blue-300"></td>
                            <td class="px-4 py-4 whitespace-nowrap text-gray-900 sticky left-12 bg-blue-200/60 backdrop-blur-sm z-10 border-r border-blue-300 text-lg">TOTAL</td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-blue-900 border-r border-blue-300 text-sm">
                                {{ number_format(array_sum(array_column($provinces->toArray(), 'total_dpt'))) }}
                            </td>
                            @foreach($partaiList as $partai)
                            @php
                                // Ambil dari totalSuaraPartai yang sudah dihitung dengan benar di controller
                                $totalPartaiData = collect($totalSuaraPartai)->firstWhere('nomor_urut', $partai->nomor_urut);
                                $totalPartai = $totalPartaiData['total_suara'] ?? 0;
                            @endphp
                            <td class="px-4 py-4 whitespace-nowrap text-right border-r border-blue-300 text-sm">
                                <span class="inline-block px-3 py-1.5 rounded-lg bg-white/80 shadow-sm text-gray-900">
                                    {{ number_format($totalPartai) }}
                                </span>
                            </td>
                            @endforeach
                        </tr>

                        @foreach($provinces as $index => $prov)
                        <tr class="hover:bg-blue-100/50 transition-colors duration-200" data-province="{{ json_encode($prov['partai_votes']) }}">
                            <td class="px-4 py-4 whitespace-nowrap text-gray-700 sticky left-0 bg-white/80 backdrop-blur-sm z-10 border-r border-blue-200">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gradient-to-br from-blue-100 to-cyan-100 font-bold text-blue-800 shadow-sm">{{ $index + 1 }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap font-bold text-gray-800 sticky left-12 bg-white/80 backdrop-blur-sm z-10 border-r border-blue-200">{{ $prov['nama'] }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-blue-700 font-bold border-r border-blue-200">{{ number_format($prov['total_dpt']) }}</td>
                            @foreach($partaiList as $partai)
                            <td class="px-4 py-4 whitespace-nowrap text-right border-r border-blue-200 party-cell" data-party="{{ $partai->partai_singkat }}" data-votes="{{ $prov['partai_votes'][$partai->partai_singkat] ?? 0 }}">
                                <span class="inline-block px-3 py-1.5 rounded-lg font-bold transition-all duration-300">
                                    {{ number_format($prov['partai_votes'][$partai->partai_singkat] ?? 0) }}
                                </span>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Controls -->
            <div id="paginationControls" class="relative flex items-center justify-between mt-6 pt-6 border-t border-blue-200">
                <div class="text-gray-700 text-sm font-semibold bg-white/60 backdrop-blur-sm px-4 py-2 rounded-lg shadow-sm">
                    Menampilkan <span id="showingStart">1</span> - <span id="showingEnd">10</span> dari <span id="totalRows">38</span> provinsi
                </div>
                <div class="flex items-center gap-2">
                    <button id="prevPage" class="bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white px-4 py-2 rounded-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <div id="pageNumbers" class="flex gap-1"></div>
                    <button id="nextPage" class="bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white px-4 py-2 rounded-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize the map centered on Indonesia
        const map = L.map('map').setView([-2.5, 118], 5);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(map);

        // Province data
        const provinces = @json($provinces);

        // Create a lookup object for province data by kode
        const provinceLookup = {};
        provinces.forEach(function(prov) {
            provinceLookup[prov.kode] = prov;
        });

        // Load GeoJSON boundary data
        fetch('/indonesia-provinces.geojson')
            .then(response => response.json())
            .then(geojsonData => {
                // Add GeoJSON layer with styling
                L.geoJSON(geojsonData, {
                    style: function(feature) {
                        const kode = feature.properties.kode;
                        const provData = provinceLookup[kode];
                        const fillColor = provData && provData.warna ? provData.warna : '#3B82F6';

                        return {
                            fillColor: fillColor,
                            weight: 2,
                            opacity: 1,
                            color: '#1E40AF',
                            fillOpacity: 0.5
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const kode = feature.properties.kode;
                        const nama = feature.properties.nama;
                        const provData = provinceLookup[kode];
                        const fillColor = provData && provData.warna ? provData.warna : '#3B82F6';

                        // Create tooltip content
                        let tooltipContent = '<div class="p-3" style="min-width: 300px;">' +
                            '<h3 class="font-bold text-lg mb-3 text-blue-700" style="border-bottom: 2px solid #ddd; padding-bottom: 8px;">' + nama + '</h3>';

                        if (provData) {
                            tooltipContent += '<table class="text-sm w-full mb-3">' +
                                '<tr style="border-bottom: 1px solid #eee;"><td class="font-semibold" style="padding: 4px 12px 4px 0;">Jumlah Kab/Kota:</td><td style="text-align: right; padding: 4px 0;">' + parseInt(provData.total_kabupaten).toLocaleString('id-ID') + '</td></tr>' +
                                '<tr style="border-bottom: 1px solid #eee;"><td class="font-semibold" style="padding: 4px 12px 4px 0;">Total DPT:</td><td style="text-align: right; padding: 4px 0;">' + parseInt(provData.total_dpt).toLocaleString('id-ID') + '</td></tr>' +
                                '</table>';

                            // Add top 3 parties
                            if (provData.top_partai && provData.top_partai.length > 0) {
                                tooltipContent += '<div style="margin-top: 12px; padding-top: 12px; border-top: 2px solid #ddd;">' +
                                    '<h4 class="font-semibold text-sm mb-2" style="color: #374151;">3 Partai Suara Terbanyak:</h4>';

                                provData.top_partai.forEach(function(partai, index) {
                                    const medal = index === 0 ? '🥇' : (index === 1 ? '🥈' : '🥉');
                                    tooltipContent += '<div style="display: flex; justify-content: space-between; align-items: center; padding: 4px 0; font-size: 12px;">' +
                                        '<span style="font-weight: 500;">' + medal + ' ' + partai.nama + '</span>' +
                                        '<span style="color: #2563EB; font-weight: bold;">' + parseInt(partai.suara).toLocaleString('id-ID') + '</span>' +
                                        '</div>';
                                });

                                tooltipContent += '</div>';
                            }
                        }

                        tooltipContent += '</div>';

                        // Bind tooltip (shows on hover)
                        layer.bindTooltip(tooltipContent, {
                            permanent: false,
                            sticky: true,
                            direction: 'top',
                            offset: [0, -10]
                        });

                        // Add hover effect
                        layer.on({
                            mouseover: function(e) {
                                const layer = e.target;
                                layer.setStyle({
                                    fillColor: fillColor,
                                    fillOpacity: 0.8,
                                    weight: 3
                                });
                            },
                            mouseout: function(e) {
                                const layer = e.target;
                                layer.setStyle({
                                    fillColor: fillColor,
                                    fillOpacity: 0.5,
                                    weight: 2
                                });
                            }
                        });
                    }
                }).addTo(map);

                // Generate dynamic legend
                const partyColors = {};
                
                provinces.forEach(prov => {
                    if (prov.warna && prov.top_partai && prov.top_partai.length > 0) {
                        const partaiSingkat = prov.top_partai[0].nama; // Already partai_singkat from controller
                        if (!partyColors[partaiSingkat]) {
                            partyColors[partaiSingkat] = prov.warna;
                        }
                    }
                });

                const legendContainer = document.getElementById('mapLegend');
                legendContainer.innerHTML = '';

                Object.keys(partyColors).sort().forEach(partyName => {
                    const color = partyColors[partyName];
                    const legendItem = document.createElement('div');
                    legendItem.className = 'flex items-center gap-2 text-sm bg-white/60 backdrop-blur-sm px-3 py-2 rounded-lg shadow-sm hover:shadow-md transition-shadow';
                    legendItem.innerHTML = `
                        <div class="w-6 h-6 rounded-full border-2 border-white shadow-md" style="background-color: ${color}; box-shadow: 0 0 10px ${color}60;"></div>
                        <span class="text-gray-800 font-semibold">${partyName}</span>
                    `;
                    legendContainer.appendChild(legendItem);
                });
            })
            .catch(error => {
                console.error('Error loading GeoJSON:', error);
            });

        // Highlight top 3 parties for each province
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('.party-cell');
                const votesData = [];

                // Collect all party votes with their cells
                cells.forEach(cell => {
                    const votes = parseInt(cell.getAttribute('data-votes'));
                    votesData.push({ cell, votes });
                });

                // Sort by votes descending
                votesData.sort((a, b) => b.votes - a.votes);

                // Apply styles to top 3
                votesData.forEach((item, index) => {
                    const span = item.cell.querySelector('span');
                    if (index === 0 && item.votes > 0) {
                        // Gold for 1st place
                        span.classList.add('bg-gradient-to-r', 'from-yellow-400', 'to-yellow-500', 'text-gray-900', 'shadow-lg', 'shadow-yellow-500/50', 'scale-110', 'font-extrabold');
                        span.style.animation = 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite';
                    } else if (index === 1 && item.votes > 0) {
                        // Silver for 2nd place
                        span.classList.add('bg-gradient-to-r', 'from-gray-300', 'to-gray-400', 'text-gray-900', 'shadow-lg', 'shadow-gray-400/50', 'scale-105', 'font-extrabold');
                    } else if (index === 2 && item.votes > 0) {
                        // Bronze for 3rd place
                        span.classList.add('bg-gradient-to-r', 'from-orange-600', 'to-orange-700', 'text-white', 'shadow-lg', 'shadow-orange-600/50', 'font-extrabold');
                    } else {
                        // Default style for others
                        span.classList.add('text-gray-400');
                    }
                });
            });

            // Pagination and Filter Logic
            let currentPage = 1;
            let rowsPerPage = 10;
            // Exclude total row from pagination
            let allRows = Array.from(document.querySelectorAll('#tableBody tr:not(#totalRow)'));
            let filteredRows = allRows;

            function applyTopThreeStyling(rows) {
                rows.forEach(row => {
                    const cells = row.querySelectorAll('.party-cell');
                    const votesData = [];

                    cells.forEach(cell => {
                        const span = cell.querySelector('span');
                        // Clear existing classes
                        span.className = 'inline-block px-3 py-1.5 rounded-lg font-bold transition-all duration-300';
                        const votes = parseInt(cell.getAttribute('data-votes'));
                        votesData.push({ cell, votes, span });
                    });

                    votesData.sort((a, b) => b.votes - a.votes);

                    votesData.forEach((item, index) => {
                        if (index === 0 && item.votes > 0) {
                            item.span.classList.add('bg-gradient-to-r', 'from-yellow-400', 'to-yellow-500', 'text-gray-900', 'shadow-lg', 'shadow-yellow-500/50', 'scale-110', 'font-extrabold');
                            item.span.style.animation = 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite';
                        } else if (index === 1 && item.votes > 0) {
                            item.span.classList.add('bg-gradient-to-r', 'from-gray-300', 'to-gray-400', 'text-gray-900', 'shadow-lg', 'shadow-gray-400/50', 'scale-105', 'font-extrabold');
                        } else if (index === 2 && item.votes > 0) {
                            item.span.classList.add('bg-gradient-to-r', 'from-orange-600', 'to-orange-700', 'text-white', 'shadow-lg', 'shadow-orange-600/50', 'font-extrabold');
                        } else {
                            item.span.classList.add('text-gray-600');
                        }
                    });
                });
            }

            function renderTable() {
                // Hide all province rows (exclude total row)
                allRows.forEach(row => row.style.display = 'none');

                // Ensure total row is always visible
                const totalRow = document.getElementById('totalRow');
                if (totalRow) totalRow.style.display = '';

                // Calculate pagination
                const start = (currentPage - 1) * rowsPerPage;
                const end = rowsPerPage === filteredRows.length ? filteredRows.length : start + rowsPerPage;

                // Show only current page rows
                const pageRows = filteredRows.slice(start, end);
                pageRows.forEach((row, index) => {
                    row.style.display = '';
                    // Update row numbers - hanya di kolom pertama (td pertama)
                    const numberCell = row.querySelector('td:first-child span');
                    if (numberCell) numberCell.textContent = start + index + 1;
                });

                // Apply top 3 styling to visible rows
                applyTopThreeStyling(pageRows);

                // Update pagination info
                document.getElementById('showingStart').textContent = filteredRows.length > 0 ? start + 1 : 0;
                document.getElementById('showingEnd').textContent = Math.min(end, filteredRows.length);
                document.getElementById('totalRows').textContent = filteredRows.length;

                // Render page numbers
                renderPageNumbers();

                // Update prev/next buttons
                document.getElementById('prevPage').disabled = currentPage === 1;
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                document.getElementById('nextPage').disabled = currentPage >= totalPages || totalPages === 0;
            }

            function renderPageNumbers() {
                const pageNumbersDiv = document.getElementById('pageNumbers');
                pageNumbersDiv.innerHTML = '';
                
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                
                for (let i = 1; i <= totalPages; i++) {
                    const button = document.createElement('button');
                    button.textContent = i;
                    button.className = i === currentPage
                        ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white px-4 py-2 rounded-lg font-bold shadow-md'
                        : 'bg-white/80 backdrop-blur-sm hover:bg-blue-100 text-gray-700 hover:text-blue-800 px-4 py-2 rounded-lg transition-all duration-200 shadow-sm';
                    button.onclick = () => {
                        currentPage = i;
                        renderTable();
                    };
                    pageNumbersDiv.appendChild(button);
                }
            }

            // Filter by province
            document.getElementById('provinceFilter').addEventListener('change', function() {
                const filterValue = this.value.toLowerCase();
                
                if (filterValue === '') {
                    filteredRows = allRows;
                } else {
                    filteredRows = allRows.filter(row => {
                        const provinceName = row.cells[1].textContent.toLowerCase();
                        return provinceName.includes(filterValue);
                    });
                }
                
                currentPage = 1;
                renderTable();
            });

            // Change rows per page
            document.getElementById('rowsPerPage').addEventListener('change', function() {
                rowsPerPage = parseInt(this.value);
                if (rowsPerPage === filteredRows.length) {
                    rowsPerPage = filteredRows.length;
                }
                currentPage = 1;
                renderTable();
            });

            // Previous page
            document.getElementById('prevPage').addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                }
            });

            // Next page
            document.getElementById('nextPage').addEventListener('click', function() {
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                }
            });

            // Initial render
            renderTable();
        });
    </script>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 border-t-4 border-cyan-500 mt-12">
        <div class="container mx-auto px-6 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-center md:text-left">
                    <p class="text-cyan-400 font-bold text-lg">© 2025 POLMARK INDONESIA</p>
                    <p class="text-gray-400 text-sm mt-1">Dashboard Data Pemilu 2024</p>
                </div>
                <div>
                    <a href="/changelog" class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-semibold px-6 py-2 rounded-lg shadow-lg transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Changelog
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
