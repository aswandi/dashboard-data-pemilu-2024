<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Suara DPRD Provinsi - Pusat Data Pemilu 2024</title>
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
                <div class="flex items-center gap-6">
                    <img src="/logo-polmark.png" alt="Polmark Indonesia" class="h-16 w-auto object-contain">
                    <div>
                        <h1 class="text-3xl font-extrabold bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent tracking-tight">
                            DASHBOARD DATA PEMILU 2024
                        </h1>
                        <p class="text-orange-400 font-bold text-lg tracking-widest mt-1">POLMARK INDONESIA</p>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="flex items-center gap-4">
                    <!-- Dropdown Menu -->
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
                            <a href="/peta-suara" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">DPR RI</div>
                                <div class="text-xs text-gray-400">Dewan Perwakilan Rakyat</div>
                            </a>
                            <a href="/peta-suara/dprd-prov" class="block px-6 py-3 text-cyan-400 bg-gradient-to-r from-cyan-600/20 to-blue-600/20 hover:from-cyan-600 hover:to-blue-600 hover:text-white transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">DPRD PROVINSI</div>
                                <div class="text-xs">DPRD Tingkat Provinsi</div>
                            </a>
                            <a href="/peta-suara/dprd-kabkota" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200">
                                <div class="font-bold">DPRD KAB/KOTA</div>
                                <div class="text-xs text-gray-400">DPRD Kabupaten/Kota</div>
                            </a>
                        </div>
                    </div>

                    <a href="/" class="bg-slate-700 hover:bg-slate-600 text-white font-bold px-6 py-3 rounded-lg transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Page Title -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Peta Suara DPRD Provinsi</h2>
                    <p class="text-gray-600 mt-2">Arahkan mouse ke provinsi untuk melihat data detail dan 3 partai suara terbanyak. Warna provinsi menunjukkan partai pemenang.</p>
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div id="map" class="rounded-lg"></div>
        </div>

        <!-- Party Votes Table -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl shadow-2xl p-8 border border-slate-700">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                    Data Suara Partai per Provinsi
                </h2>
                <div class="flex gap-4 text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded bg-gradient-to-r from-yellow-400 to-yellow-500 shadow-lg shadow-yellow-500/50"></div>
                        <span class="text-gray-300">Peringkat 1</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded bg-gradient-to-r from-gray-300 to-gray-400 shadow-lg shadow-gray-400/50"></div>
                        <span class="text-gray-300">Peringkat 2</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded bg-gradient-to-r from-orange-600 to-orange-700 shadow-lg shadow-orange-600/50"></div>
                        <span class="text-gray-300">Peringkat 3</span>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto rounded-xl border border-slate-700">
                <table class="min-w-full divide-y divide-slate-700 text-xs">
                    <thead class="bg-gradient-to-r from-slate-800 to-slate-900">
                        <tr>
                            <th class="px-4 py-4 text-left font-bold text-cyan-400 uppercase tracking-wider sticky left-0 bg-slate-900 z-10 border-r border-slate-700">No</th>
                            <th class="px-4 py-4 text-left font-bold text-cyan-400 uppercase tracking-wider sticky left-12 bg-slate-900 z-10 border-r border-slate-700" style="min-width: 200px;">Provinsi</th>
                            <th class="px-4 py-4 text-right font-bold text-cyan-400 uppercase tracking-wider border-r border-slate-700">Jumlah DPT</th>
                            @foreach($partaiList as $partai)
                            <th class="px-4 py-4 text-center font-bold text-cyan-400 uppercase tracking-wider border-r border-slate-700" title="{{ $partai->nama }}">
                                <div class="flex flex-col items-center gap-1">
                                    <div class="w-6 h-6 rounded-full" style="background-color: {{ $partai->warna }}; box-shadow: 0 0 10px {{ $partai->warna }}40;"></div>
                                    <span>{{ $partai->partai_singkat }}</span>
                                </div>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-slate-900 divide-y divide-slate-800" id="tableBody">
                        @foreach($provinces as $index => $prov)
                        <tr class="hover:bg-slate-800 transition-colors duration-200" data-province="{{ json_encode($prov['partai_votes']) }}">
                            <td class="px-4 py-4 whitespace-nowrap text-gray-300 sticky left-0 bg-slate-900 z-10 border-r border-slate-800">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gradient-to-br from-slate-700 to-slate-800 font-bold">{{ $index + 1 }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap font-bold text-white sticky left-12 bg-slate-900 z-10 border-r border-slate-800">{{ $prov['nama'] }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-cyan-400 font-bold border-r border-slate-800">{{ number_format($prov['total_dpt']) }}</td>
                            @foreach($partaiList as $partai)
                            <td class="px-4 py-4 whitespace-nowrap text-right border-r border-slate-800 party-cell" data-party="{{ $partai->partai_singkat }}" data-votes="{{ $prov['partai_votes'][$partai->partai_singkat] ?? 0 }}">
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
                                '<tr style="border-bottom: 1px solid #eee;"><td class="font-semibold" style="padding: 4px 12px 4px 0;">Jumlah Kab/Kota:</td><td style="text-align: right; padding: 4px 0;">' + provData.total_kabupaten.toLocaleString('id-ID') + '</td></tr>' +
                                '<tr style="border-bottom: 1px solid #eee;"><td class="font-semibold" style="padding: 4px 12px 4px 0;">Total DPT:</td><td style="text-align: right; padding: 4px 0;">' + provData.total_dpt.toLocaleString('id-ID') + '</td></tr>' +
                                '</table>';

                            // Add top 3 parties
                            if (provData.top_partai && provData.top_partai.length > 0) {
                                tooltipContent += '<div style="margin-top: 12px; padding-top: 12px; border-top: 2px solid #ddd;">' +
                                    '<h4 class="font-semibold text-sm mb-2" style="color: #374151;">3 Partai Suara Terbanyak:</h4>';

                                provData.top_partai.forEach(function(partai, index) {
                                    const medal = index === 0 ? '🥇' : (index === 1 ? '🥈' : '🥉');
                                    tooltipContent += '<div style="display: flex; justify-content: space-between; align-items: center; padding: 4px 0; font-size: 12px;">' +
                                        '<span style="font-weight: 500;">' + medal + ' ' + partai.nama + '</span>' +
                                        '<span style="color: #2563EB; font-weight: bold;">' + partai.suara.toLocaleString('id-ID') + '</span>' +
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
        });
    </script>
</body>
</html>
