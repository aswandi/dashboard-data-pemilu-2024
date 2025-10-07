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
        .leaflet-popup-content {
            min-width: 250px;
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
            <p class="text-gray-600">Visualisasi data pemilu berdasarkan provinsi di Indonesia</p>
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

        // Province data with approximate coordinates
        const provinces = @json($provinces);

        // Approximate coordinates for Indonesian provinces (capital cities)
        const provinceCoordinates = {
            'ACEH': [5.5483, 95.3238],
            'SUMATERA UTARA': [3.5952, 98.6722],
            'SUMATERA BARAT': [-0.9471, 100.4172],
            'RIAU': [0.5071, 101.4478],
            'JAMBI': [-1.6101, 103.6131],
            'SUMATERA SELATAN': [-2.9761, 104.7754],
            'BENGKULU': [-3.7928, 102.2608],
            'LAMPUNG': [-5.4294, 105.2628],
            'KEPULAUAN BANGKA BELITUNG': [-2.7411, 106.4406],
            'KEPULAUAN RIAU': [1.0456, 104.0305],
            'DKI JAKARTA': [-6.2088, 106.8456],
            'JAWA BARAT': [-6.9175, 107.6191],
            'JAWA TENGAH': [-7.0051, 110.4381],
            'DI YOGYAKARTA': [-7.7956, 110.3695],
            'JAWA TIMUR': [-7.2575, 112.7521],
            'BANTEN': [-6.1204, 106.1503],
            'BALI': [-8.3405, 115.0920],
            'NUSA TENGGARA BARAT': [-8.5833, 116.1167],
            'NUSA TENGGARA TIMUR': [-8.6529, 121.0794],
            'KALIMANTAN BARAT': [-0.0263, 109.3425],
            'KALIMANTAN TENGAH': [-1.6815, 113.3824],
            'KALIMANTAN SELATAN': [-3.0926, 115.2838],
            'KALIMANTAN TIMUR': [0.5387, 116.4194],
            'KALIMANTAN UTARA': [3.0731, 116.0413],
            'SULAWESI UTARA': [1.4748, 124.8421],
            'SULAWESI TENGAH': [-0.8999, 119.8707],
            'SULAWESI SELATAN': [-5.1477, 119.4327],
            'SULAWESI TENGGARA': [-4.1448, 122.1747],
            'GORONTALO': [0.5435, 123.0595],
            'SULAWESI BARAT': [-2.8441, 119.2320],
            'MALUKU': [-3.6954, 128.1814],
            'MALUKU UTARA': [0.7893, 127.3896],
            'PAPUA BARAT': [-1.3361, 133.1747],
            'PAPUA': [-2.5920, 140.6571],
            'PAPUA SELATAN': [-6.0801, 140.4438],
            'PAPUA TENGAH': [-3.3194, 136.2324],
            'PAPUA PEGUNUNGAN': [-4.0615, 138.9545],
            'PAPUA BARAT DAYA': [-1.8906, 132.2994]
        };

        // Add markers for each province
        provinces.forEach(function(prov) {
            const coords = provinceCoordinates[prov.nama.toUpperCase()];
            if (coords) {
                const marker = L.marker(coords).addTo(map);
                marker.bindPopup(`
                    <div class="p-2">
                        <h3 class="font-bold text-lg mb-2">${prov.nama}</h3>
                        <table class="text-sm w-full">
                            <tr><td class="font-semibold pr-2">Kabupaten:</td><td>${prov.total_kabupaten.toLocaleString('id-ID')}</td></tr>
                            <tr><td class="font-semibold pr-2">Kecamatan:</td><td>${prov.total_kecamatan.toLocaleString('id-ID')}</td></tr>
                            <tr><td class="font-semibold pr-2">Kelurahan:</td><td>${prov.total_kelurahan.toLocaleString('id-ID')}</td></tr>
                            <tr><td class="font-semibold pr-2">Total TPS:</td><td>${prov.total_tps.toLocaleString('id-ID')}</td></tr>
                            <tr><td class="font-semibold pr-2">Total DPT:</td><td>${prov.total_dpt.toLocaleString('id-ID')}</td></tr>
                        </table>
                    </div>
                `);
            }
        });
    </script>
</body>
</html>
