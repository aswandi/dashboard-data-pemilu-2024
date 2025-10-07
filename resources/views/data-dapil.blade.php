<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dapil - Pemilu 2024</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #map {
            height: 600px;
            width: 100%;
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
                <h2 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-600 mb-4">
                    DATA DAPIL DPR RI
                </h2>
                <p class="text-gray-600 text-lg">Pemilihan Umum 2024 - Data Per Daerah Pemilihan</p>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-8 border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Tabel Suara Per Dapil</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">NO</th>
                            <th class="px-4 py-3 text-left">PROVINSI</th>
                            <th class="px-4 py-3 text-left">DAPIL</th>
                            @foreach($partaiList as $partai)
                            <th class="px-2 py-3 text-center" title="{{ $partai->nama }}">
                                {{ $partai->partai_singkat }}
                            </th>
                            @endforeach
                            <th class="px-4 py-3 text-right font-bold">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Total Row (Baris ke-2) -->
                        <tr class="bg-yellow-50 font-bold border-b-2 border-yellow-400">
                            <td class="px-4 py-3" colspan="3">TOTAL NASIONAL</td>
                            @foreach($partaiList as $partai)
                            <td class="px-2 py-3 text-center">
                                {{ number_format($totalRow['partai_' . $partai->nomor_urut]) }}
                            </td>
                            @endforeach
                            <td class="px-4 py-3 text-right text-blue-600">{{ number_format($totalRow['total']) }}</td>
                        </tr>

                        @foreach($dapilData as $index => $row)
                        <tr class="border-b hover:bg-blue-50 transition-colors">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $row['provinsi'] }}</td>
                            <td class="px-4 py-3">
                                <a href="/data-utama/dapil/{{ $row['pro_id'] }}/{{ urlencode($row['dapil']) }}"
                                   class="text-blue-600 hover:text-blue-800 hover:underline font-semibold">
                                    {{ $row['dapil'] }}
                                </a>
                            </td>
                            @foreach($partaiList as $partai)
                            <td class="px-2 py-3 text-center">
                                {{ number_format($row['partai_' . $partai->nomor_urut]) }}
                            </td>
                            @endforeach
                            <td class="px-4 py-3 text-right font-semibold">{{ number_format($row['total']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-8 border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Grafik Distribusi Suara Per Partai</h3>
            <div style="height: 400px;">
                <canvas id="chartPartai"></canvas>
            </div>
        </div>

        <!-- Map Section -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Peta Sebaran Suara Nasional</h3>
            <div id="map" class="rounded-lg border-2 border-gray-300"></div>
        </div>
    </div>

    <script>
        // Chart.js - Bar Chart
        const ctx = document.getElementById('chartPartai').getContext('2d');
        const partaiData = @json($partaiList);
        const totalRow = @json($totalRow);

        const chartData = {
            labels: partaiData.map(p => p.partai_singkat),
            datasets: [{
                label: 'Total Suara',
                data: partaiData.map(p => totalRow['partai_' + p.nomor_urut]),
                backgroundColor: partaiData.map(p => p.warna || '#3B82F6'),
                borderColor: partaiData.map(p => p.warna || '#3B82F6'),
                borderWidth: 2
            }]
        };

        new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y.toLocaleString('id-ID') + ' suara';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Leaflet Map
        const map = L.map('map').setView([-2.5, 118], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        fetch('/indonesia-provinces.geojson')
            .then(response => response.json())
            .then(data => {
                const mapData = @json($mapData);
                const mapDict = {};
                mapData.forEach(item => {
                    mapDict[item.kode] = item;
                });

                L.geoJSON(data, {
                    style: function(feature) {
                        const kode = feature.properties.kode;
                        const provinceData = mapDict[kode];

                        return {
                            fillColor: provinceData ? provinceData.color : '#E5E7EB',
                            weight: 2,
                            opacity: 1,
                            color: '#1E40AF',
                            fillOpacity: 0.7
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const kode = feature.properties.kode;
                        const provinceData = mapDict[kode];

                        if (provinceData) {
                            layer.bindPopup(`
                                <div class="p-2">
                                    <h3 class="font-bold text-lg">${provinceData.nama}</h3>
                                    <p class="text-sm">Total Suara: <span class="font-bold">${provinceData.total_suara.toLocaleString('id-ID')}</span></p>
                                </div>
                            `);
                        }
                    }
                }).addTo(map);
            });
    </script>
</body>
</html>
