<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Partai - {{ $selectedPartai->partai_singkat ?? 'Partai' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #map, #mapPercentage {
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
                            <a href="/data-utama/partai" class="block px-6 py-3 text-cyan-400 bg-gradient-to-r from-cyan-600/20 to-blue-600/20 hover:from-cyan-600 hover:to-blue-600 hover:text-white transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">PARTAI</div>
                                <div class="text-xs">Data per Partai</div>
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
        <!-- Page Header with Party Selector -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Data Suara per Partai</h2>
                    <p class="text-gray-600">Analisis suara partai per provinsi dan dapil</p>
                </div>
                <div class="flex items-center gap-4">
                    @if($selectedPartai && $selectedPartai->logo_url)
                    <img src="/lampiran/partai/{{ $selectedPartai->nomor_urut }}.jpg" alt="{{ $selectedPartai->partai_singkat }}" class="w-16 h-16 rounded-full border-2 border-white shadow-lg">
                    @endif
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Partai:</label>
                        <select id="partaiSelector" class="px-6 py-3 text-lg font-bold rounded-lg border-2 border-blue-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 cursor-pointer" style="background-color: {{ $selectedPartai->warna ?? '#3B82F6' }}; color: white;">
                            @foreach($partaiList as $partai)
                            <option value="{{ $partai->nomor_urut }}" {{ $partai->nomor_urut == $selectedPartai->nomor_urut ? 'selected' : '' }}>
                                {{ $partai->partai_singkat }} - {{ $partai->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6 overflow-x-auto">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Suara per Provinsi dan Dapil</h3>
            <table class="min-w-full divide-y divide-gray-200 text-xs">
                <thead class="bg-gradient-to-r from-blue-600 to-cyan-600">
                    <tr>
                        <th class="px-3 py-3 text-left font-bold text-white uppercase tracking-wider sticky left-0 bg-blue-600 z-10">No</th>
                        <th class="px-3 py-3 text-left font-bold text-white uppercase tracking-wider sticky left-12 bg-blue-600 z-10" style="min-width: 150px;">Provinsi</th>
                        <th class="px-3 py-3 text-center font-bold text-white uppercase tracking-wider">Jumlah Dapil</th>
                        @for($i = 1; $i <= $maxDapil; $i++)
                        <th class="px-3 py-3 text-center font-bold text-white uppercase tracking-wider">Dapil {{ $i }}</th>
                        @endfor
                        <th class="px-3 py-3 text-right font-bold text-white uppercase tracking-wider bg-blue-700">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($provinceData as $index => $prov)
                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                        <td class="px-3 py-3 text-gray-700 sticky left-0 bg-white z-10">{{ $index + 1 }}</td>
                        <td class="px-3 py-3 font-semibold text-gray-900 sticky left-12 bg-white z-10">{{ $prov['nama'] }}</td>
                        <td class="px-3 py-3 text-center text-gray-700">{{ $prov['jumlah_dapil'] }}</td>
                        @php
                            $dapilArray = array_values($prov['dapil_votes']);
                        @endphp
                        @for($i = 0; $i < $maxDapil; $i++)
                        <td class="px-3 py-3 text-right text-gray-700">
                            {{ isset($dapilArray[$i]) ? number_format($dapilArray[$i]->total_suara) : '-' }}
                        </td>
                        @endfor
                        <td class="px-3 py-3 text-right font-bold text-blue-700 bg-blue-50">{{ number_format($prov['total_suara']) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Chart Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Grafik Suara per Provinsi</h3>
            <canvas id="provinceChart" height="100"></canvas>
        </div>

        <!-- Percentage Chart Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Grafik Persentase Suara {{ $selectedPartai->partai_singkat ?? 'Partai' }} vs Partai Lain per Provinsi</h3>
            <p class="text-gray-600 mb-4">Menunjukkan persentase suara partai dibandingkan dengan total suara semua partai di provinsi yang sama</p>
            <canvas id="percentageChart" height="100"></canvas>
        </div>

        <!-- Map Section -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Peta Suara {{ $selectedPartai->partai_singkat ?? 'Partai' }}</h3>
            <p class="text-gray-600 mb-4">Gradasi warna menunjukkan intensitas suara (lebih gelap = lebih banyak suara)</p>

            <!-- Legend -->
            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-sm mb-2">Legenda Gradasi Warna:</h4>
                <div class="flex items-center gap-2">
                    @for($i = 1; $i <= 10; $i++)
                    @php
                        $opacity = 0.1 + ($i * 0.09);
                        $baseColor = $selectedPartai->warna ?? '#3B82F6';
                        $r = hexdec(substr(str_replace('#', '', $baseColor), 0, 2));
                        $g = hexdec(substr(str_replace('#', '', $baseColor), 2, 2));
                        $b = hexdec(substr(str_replace('#', '', $baseColor), 4, 2));

                        // Blend dengan putih untuk level rendah, full color untuk level tinggi
                        $white = 255;
                        $r = round($white + ($r - $white) * $opacity);
                        $g = round($white + ($g - $white) * $opacity);
                        $b = round($white + ($b - $white) * $opacity);
                        $color = sprintf('#%02x%02x%02x', $r, $g, $b);
                    @endphp
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded border border-gray-300" style="background-color: {{ $color }}"></div>
                        <span class="text-xs mt-1 font-semibold">{{ $i }}</span>
                    </div>
                    @endfor
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    <span class="font-semibold">Level 1 (Terang)</span> = Suara terendah |
                    <span class="font-semibold">Level 10 (Gelap)</span> = Suara tertinggi
                </p>
            </div>

            <div id="map" class="rounded-lg"></div>
        </div>

        <!-- Percentage Map Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Peta Persentase Suara {{ $selectedPartai->partai_singkat ?? 'Partai' }} vs Partai Lain</h3>
            <p class="text-gray-600 mb-4">Gradasi warna menunjukkan persentase suara partai dibandingkan total suara semua partai di provinsi yang sama (lebih gelap = persentase lebih tinggi)</p>

            <!-- Legend -->
            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-sm mb-2">Legenda Gradasi Warna:</h4>
                <div class="flex items-center gap-2">
                    @for($i = 1; $i <= 10; $i++)
                    @php
                        $opacity = 0.1 + ($i * 0.09);
                        $baseColor = $selectedPartai->warna ?? '#3B82F6';
                        $r = hexdec(substr(str_replace('#', '', $baseColor), 0, 2));
                        $g = hexdec(substr(str_replace('#', '', $baseColor), 2, 2));
                        $b = hexdec(substr(str_replace('#', '', $baseColor), 4, 2));

                        $white = 255;
                        $r = round($white + ($r - $white) * $opacity);
                        $g = round($white + ($g - $white) * $opacity);
                        $b = round($white + ($b - $white) * $opacity);
                        $color = sprintf('#%02x%02x%02x', $r, $g, $b);
                    @endphp
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded border border-gray-300" style="background-color: {{ $color }}"></div>
                        <span class="text-xs mt-1 font-semibold">{{ $i }}</span>
                    </div>
                    @endfor
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    <span class="font-semibold">Level 1 (Terang)</span> = Persentase terendah |
                    <span class="font-semibold">Level 10 (Gelap)</span> = Persentase tertinggi
                </p>
            </div>

            <div id="mapPercentage" class="rounded-lg"></div>
        </div>
    </div>

    <script>
        // Party selector change
        document.getElementById('partaiSelector').addEventListener('change', function() {
            window.location.href = '?partai=' + this.value;
        });

        // Chart.js - Bar Chart (Total Suara)
        const chartData = @json($chartData);
        const ctx = document.getElementById('provinceChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.map(d => d.nama),
                datasets: [{
                    label: 'Total Suara',
                    data: chartData.map(d => d.total_suara),
                    backgroundColor: '{{ $selectedPartai->warna ?? "#3B82F6" }}',
                    borderColor: '{{ $selectedPartai->warna ?? "#3B82F6" }}',
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
                                return 'Suara: ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Chart.js - Percentage Chart
        const percentageData = @json($chartPercentageData);
        const ctx2 = document.getElementById('percentageChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: percentageData.map(d => d.nama),
                datasets: [{
                    label: 'Persentase Suara (%)',
                    data: percentageData.map(d => d.persentase),
                    backgroundColor: '{{ $selectedPartai->warna ?? "#3B82F6" }}',
                    borderColor: '{{ $selectedPartai->warna ?? "#3B82F6" }}',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const data = percentageData[context.dataIndex];
                                return [
                                    'Persentase: ' + data.persentase + '%',
                                    'Suara Partai: ' + data.total_suara.toLocaleString('id-ID'),
                                    'Total Semua Partai: ' + data.total_all.toLocaleString('id-ID')
                                ];
                            }
                        }
                    }
                }
            }
        });

        // Leaflet Map
        const map = L.map('map').setView([-2.5, 118], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(map);

        const mapData = @json($mapData);

        // Load GeoJSON
        fetch('/indonesia-provinces.geojson')
            .then(response => response.json())
            .then(geojsonData => {
                const dataLookup = {};
                mapData.forEach(d => {
                    dataLookup[d.kode] = d;
                });

                L.geoJSON(geojsonData, {
                    style: function(feature) {
                        const data = dataLookup[feature.properties.kode];
                        return {
                            fillColor: data ? data.color : '#CCCCCC',
                            weight: 2,
                            opacity: 1,
                            color: '#333',
                            fillOpacity: 0.7
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const data = dataLookup[feature.properties.kode];
                        const content = `
                            <div class="p-3">
                                <h3 class="font-bold text-lg mb-2">${feature.properties.nama}</h3>
                                ${data ? `
                                    <p><strong>Total Suara:</strong> ${data.total_suara.toLocaleString('id-ID')}</p>
                                    <p><strong>Level:</strong> ${data.level}/10</p>
                                ` : '<p>Tidak ada data</p>'}
                            </div>
                        `;
                        layer.bindPopup(content);
                    }
                }).addTo(map);
            })
            .catch(error => console.error('Error loading GeoJSON:', error));

        // Leaflet Map - Percentage Map
        const mapPercentage = L.map('mapPercentage').setView([-2.5, 118], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(mapPercentage);

        const mapPercentageData = @json($mapPercentageData);

        // Load GeoJSON for percentage map
        fetch('/indonesia-provinces.geojson')
            .then(response => response.json())
            .then(geojsonData => {
                const dataLookup = {};
                mapPercentageData.forEach(d => {
                    dataLookup[d.kode] = d;
                });

                L.geoJSON(geojsonData, {
                    style: function(feature) {
                        const data = dataLookup[feature.properties.kode];
                        return {
                            fillColor: data ? data.color : '#CCCCCC',
                            weight: 2,
                            opacity: 1,
                            color: '#333',
                            fillOpacity: 0.7
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const data = dataLookup[feature.properties.kode];
                        const content = `
                            <div class="p-3">
                                <h3 class="font-bold text-lg mb-2">${feature.properties.nama}</h3>
                                ${data ? `
                                    <p><strong>Persentase:</strong> ${data.persentase}%</p>
                                    <p><strong>Suara Partai:</strong> ${data.total_suara.toLocaleString('id-ID')}</p>
                                    <p><strong>Total Semua Partai:</strong> ${data.total_all.toLocaleString('id-ID')}</p>
                                    <p><strong>Level:</strong> ${data.level}/10</p>
                                ` : '<p>Tidak ada data</p>'}
                            </div>
                        `;
                        layer.bindPopup(content);
                    }
                }).addTo(mapPercentage);
            })
            .catch(error => console.error('Error loading GeoJSON for percentage map:', error));
    </script>
</body>
</html>
