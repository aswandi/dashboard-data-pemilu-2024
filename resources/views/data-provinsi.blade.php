<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Provinsi - {{ $selectedProvince->nama ?? 'Provinsi' }}</title>
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
    <!-- Header (sama dengan data-partai.blade.php) -->
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
                            <a href="/data-utama/provinsi" class="block px-6 py-3 text-cyan-400 bg-gradient-to-r from-cyan-600/20 to-blue-600/20 hover:from-cyan-600 hover:to-blue-600 hover:text-white transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">PROVINSI</div>
                                <div class="text-xs">Data per Provinsi</div>
                            </a>
                            <a href="/data-utama/dapil" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200">
                                <div class="font-bold">DAPIL</div>
                                <div class="text-xs text-gray-400">Data per Dapil</div>
                            </a>
                        </div>
                    </div>

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
                            <a href="/peta-suara" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">DPR RI</div>
                                <div class="text-xs text-gray-400">Dewan Perwakilan Rakyat</div>
                            </a>
                            <a href="/peta-suara/dprd-prov" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200">
                                <div class="font-bold">DPRD PROVINSI</div>
                                <div class="text-xs text-gray-400">DPRD Tingkat Provinsi</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Page Header with Province Selector -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Data Suara per Provinsi</h2>
                    <p class="text-gray-600">Analisis suara partai per dapil di provinsi terpilih</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Provinsi:</label>
                    <select id="provinsiSelector" class="px-6 py-3 text-lg font-bold rounded-lg border-2 border-blue-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 cursor-pointer bg-blue-600 text-white">
                        @foreach($provinces as $prov)
                        <option value="{{ $prov->kode }}" {{ $prov->kode == $selectedProvince->kode ? 'selected' : '' }}>
                            {{ $prov->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6 overflow-x-auto">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Suara per Partai dan Dapil</h3>
            <table class="min-w-full divide-y divide-gray-200 text-xs">
                <thead class="bg-gradient-to-r from-blue-600 to-cyan-600">
                    <tr>
                        <th class="px-3 py-3 text-left font-bold text-white uppercase tracking-wider sticky left-0 bg-blue-600 z-10">No</th>
                        <th class="px-3 py-3 text-left font-bold text-white uppercase tracking-wider sticky left-12 bg-blue-600 z-10" style="min-width: 120px;">Dapil</th>
                        @foreach($partaiList as $partai)
                        <th class="px-3 py-3 text-center font-bold text-white uppercase tracking-wider" title="{{ $partai->nama }}">
                            <div class="flex flex-col items-center gap-1">
                                <img src="/lampiran/partai/{{ $partai->nomor_urut }}.jpg" alt="{{ $partai->partai_singkat }}" class="w-6 h-6 rounded-full">
                                <span>{{ $partai->partai_singkat }}</span>
                            </div>
                        </th>
                        @endforeach
                        <th class="px-3 py-3 text-right font-bold text-white uppercase tracking-wider bg-blue-700">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Total Row -->
                    <tr class="bg-yellow-100 font-bold text-sm">
                        <td class="px-3 py-3 sticky left-0 bg-yellow-100 z-10"></td>
                        <td class="px-3 py-3 text-gray-900 sticky left-12 bg-yellow-100 z-10">TOTAL</td>
                        @foreach($partaiList as $partai)
                        <td class="px-3 py-3 text-right">{{ number_format($partyTotals[$partai->nomor_urut]) }}</td>
                        @endforeach
                        <td class="px-3 py-3 text-right bg-yellow-200">{{ number_format($grandTotal) }}</td>
                    </tr>

                    @foreach($dapilData as $index => $dapil)
                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                        <td class="px-3 py-3 text-gray-700 sticky left-0 bg-white z-10">{{ $index + 1 }}</td>
                        <td class="px-3 py-3 font-semibold text-gray-900 sticky left-12 bg-white z-10">{{ $dapil['nama'] }}</td>
                        @foreach($partaiList as $partai)
                        <td class="px-3 py-3 text-right text-gray-700">
                            {{ number_format($dapil['votes'][$partai->nomor_urut] ?? 0) }}
                        </td>
                        @endforeach
                        <td class="px-3 py-3 text-right font-bold text-blue-700 bg-blue-50">{{ number_format($dapil['total']) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Chart Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Grafik Perbandingan Suara Partai di {{ $selectedProvince->nama }}</h3>
            <canvas id="partyChart" height="80"></canvas>
        </div>

        <!-- Map Section -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Peta Wilayah {{ $selectedProvince->nama }}</h3>
            <p class="text-gray-600 mb-4">Peta menunjukkan batas wilayah kabupaten/kota di provinsi {{ $selectedProvince->nama }}</p>
            <div id="map" class="rounded-lg border-2 border-gray-200"></div>
        </div>
    </div>

    <script>
        // Province selector change
        document.getElementById('provinsiSelector').addEventListener('change', function() {
            window.location.href = '?provinsi=' + this.value;
        });

        // Chart.js - Bar Chart
        const chartData = @json($chartData);
        const ctx = document.getElementById('partyChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.map(d => d.partai),
                datasets: [{
                    label: 'Total Suara',
                    data: chartData.map(d => d.total_suara),
                    backgroundColor: chartData.map(d => d.warna),
                    borderColor: chartData.map(d => d.warna),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const data = chartData[context.dataIndex];
                                return data.nama + ': ' + context.parsed.y.toLocaleString('id-ID') + ' suara';
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Leaflet Map
        const provinceBoundary = @json($provinceBoundary);
        const kabupatenBoundaries = @json($kabupatenBoundaries);

        // Helper function to convert path string to Leaflet coordinates
        function parsePathToLatLngs(pathString) {
            if (!pathString) return null;

            try {
                // Parse the path string to array
                const pathArray = JSON.parse(pathString);

                // Function to convert coordinate arrays to Leaflet format
                function convertCoords(coords) {
                    if (!Array.isArray(coords)) return null;

                    // Check if it's a single coordinate pair [lat, lng]
                    if (coords.length === 2 && typeof coords[0] === 'number') {
                        return [coords[0], coords[1]];
                    }

                    // Otherwise, recursively process nested arrays
                    return coords.map(c => convertCoords(c)).filter(c => c !== null);
                }

                return convertCoords(pathArray);
            } catch (e) {
                console.error('Error parsing path:', e);
                return null;
            }
        }

        // Initialize map centered on province
        let centerLat = {{ $selectedProvince->latitude ?? -2.5 }};
        let centerLng = {{ $selectedProvince->longitude ?? 118 }};

        // Use province boundary center if available
        if (provinceBoundary && provinceBoundary.lat && provinceBoundary.lng) {
            centerLat = provinceBoundary.lat;
            centerLng = provinceBoundary.lng;
        }

        const map = L.map('map').setView([centerLat, centerLng], 8);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(map);

        // Draw province boundary
        if (provinceBoundary && provinceBoundary.path) {
            const provinceCoords = parsePathToLatLngs(provinceBoundary.path);
            if (provinceCoords) {
                L.polygon(provinceCoords, {
                    fillColor: '#3B82F6',
                    weight: 3,
                    opacity: 1,
                    color: '#1E40AF',
                    fillOpacity: 0.2
                }).addTo(map).bindPopup(`<strong>${provinceBoundary.nama}</strong>`);
            }
        }

        // Draw kabupaten boundaries
        if (kabupatenBoundaries && kabupatenBoundaries.length > 0) {
            kabupatenBoundaries.forEach((kab, index) => {
                if (kab.path) {
                    const kabCoords = parsePathToLatLngs(kab.path);
                    if (kabCoords) {
                        // Generate different colors for each kabupaten
                        const colors = [
                            '#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#6366F1',
                            '#8B5CF6', '#EC4899', '#F97316', '#14B8A6', '#06B6D4'
                        ];
                        const color = colors[index % colors.length];

                        L.polygon(kabCoords, {
                            fillColor: color,
                            weight: 2,
                            opacity: 1,
                            color: '#1F2937',
                            fillOpacity: 0.4
                        }).addTo(map).bindPopup(`<strong>${kab.nama}</strong>`);
                    }
                }
            });
        }
    </script>
</body>
</html>
