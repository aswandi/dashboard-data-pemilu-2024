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
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold text-gray-800">Peta Suara Indonesia</h1>
                <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    ← Kembali ke Data Wilayah
                </a>
            </div>
            <p class="text-gray-600">Arahkan mouse ke provinsi untuk melihat data detail dan 3 partai suara terbanyak</p>
        </div>

        <!-- Map Container -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div id="map" class="rounded-lg"></div>
        </div>

        <!-- Province List -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Data Provinsi</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Provinsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kabupaten</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kecamatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelurahan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total TPS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total DPT</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($provinces as $index => $prov)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $prov['nama'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($prov['total_kabupaten']) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($prov['total_kecamatan']) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($prov['total_kelurahan']) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($prov['total_tps']) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($prov['total_dpt']) }}</td>
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
                        return {
                            fillColor: '#3B82F6',
                            weight: 2,
                            opacity: 1,
                            color: '#1E40AF',
                            fillOpacity: 0.3
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const kode = feature.properties.kode;
                        const nama = feature.properties.nama;
                        const provData = provinceLookup[kode];

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
                                    fillColor: '#60A5FA',
                                    fillOpacity: 0.6,
                                    weight: 3
                                });
                            },
                            mouseout: function(e) {
                                const layer = e.target;
                                layer.setStyle({
                                    fillColor: '#3B82F6',
                                    fillOpacity: 0.3,
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
    </script>
</body>
</html>
