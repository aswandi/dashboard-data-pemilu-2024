<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Data Pemilu 2024</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-950 via-blue-950 to-purple-950 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-indigo-900/50 to-purple-900/50 backdrop-blur-sm border-b border-white/10">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white tracking-tight">Pusat Data Pemilu 2024</h1>
                        <p class="text-indigo-200 text-sm">Sistem Informasi Data Wilayah Indonesia</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/peta-suara" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-2 rounded-lg transition shadow-lg">
                        🗺️ Peta Suara
                    </a>
                    <div class="flex items-center space-x-2">
                        <div class="h-2 w-2 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-green-300 text-sm font-medium">Live Data</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistics Cards -->
        <div class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $statsCards = [
                        ['title' => 'Total Provinsi', 'value' => $statistics['total_provinsi'], 'icon' => '🏛️', 'gradient' => 'from-blue-500 to-cyan-500'],
                        ['title' => 'Total Kabupaten', 'value' => $statistics['total_kabupaten'], 'icon' => '🏙️', 'gradient' => 'from-purple-500 to-pink-500'],
                        ['title' => 'Total Kecamatan', 'value' => $statistics['total_kecamatan'], 'icon' => '🏘️', 'gradient' => 'from-green-500 to-emerald-500'],
                        ['title' => 'Total Kelurahan', 'value' => $statistics['total_kelurahan'], 'icon' => '🏡', 'gradient' => 'from-orange-500 to-red-500'],
                        ['title' => 'Total TPS', 'value' => $statistics['total_tps'], 'icon' => '🗳️', 'gradient' => 'from-indigo-500 to-blue-500'],
                        ['title' => 'Total DPT', 'value' => $statistics['total_dpt'], 'icon' => '👥', 'gradient' => 'from-pink-500 to-rose-500'],
                    ];
                @endphp

                @foreach($statsCards as $index => $stat)
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md border border-white/20 p-6 hover:scale-105 transition-all duration-300 hover:shadow-2xl hover:shadow-purple-500/20">
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-4xl p-3 rounded-xl bg-gradient-to-br {{ $stat['gradient'] }} shadow-lg">
                                {{ $stat['icon'] }}
                            </div>
                            <div class="px-3 py-1 rounded-full bg-gradient-to-r {{ $stat['gradient'] }} text-white text-xs font-bold">
                                LIVE
                            </div>
                        </div>
                        <h3 class="text-white/70 text-sm font-medium mb-2">{{ $stat['title'] }}</h3>
                        <p class="text-3xl font-bold bg-gradient-to-r {{ $stat['gradient'] }} bg-clip-text text-transparent">
                            {{ number_format($stat['value'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md rounded-2xl border border-white/20 overflow-hidden shadow-2xl">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-indigo-900/50 to-purple-900/50 px-6 py-4 border-b border-white/10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">Data Wilayah per Provinsi</h2>
                        <p class="text-indigo-200 text-sm">Menampilkan {{ count($provinsiData) }} provinsi</p>
                    </div>
                    <div class="relative">
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Cari provinsi..."
                            class="w-full md:w-64 px-4 py-2 pl-10 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-purple-500"
                        />
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full" id="dataTable">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-900/30 to-purple-900/30 border-b border-white/10">
                            <th class="px-6 py-4 text-left text-xs font-bold text-indigo-200 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-indigo-200 uppercase">Provinsi</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-indigo-200 uppercase">Dapil</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-indigo-200 uppercase">Kabupaten</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-indigo-200 uppercase">Kecamatan</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-indigo-200 uppercase">Kelurahan</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-indigo-200 uppercase">TPS</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-indigo-200 uppercase">DPT</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($provinsiData as $index => $item)
                        <tr class="hover:bg-white/5 transition-colors duration-200 group data-row">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-sm font-bold">
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            <td class="px-6 py-4 provinsi-name">
                                <div class="text-white font-semibold">{{ $item['provinsi'] }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                    {{ number_format($item['jumlah_dapil'], 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-300 border border-purple-500/30">
                                    {{ number_format($item['jumlah_kabupaten'], 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-300 border border-green-500/30">
                                    {{ number_format($item['jumlah_kecamatan'], 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-500/20 text-orange-300 border border-orange-500/30">
                                    {{ number_format($item['jumlah_kelurahan'], 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                                    {{ number_format($item['total_tps'], 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-500/20 text-pink-300 border border-pink-500/30">
                                    {{ number_format($item['total_dpt'], 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-indigo-900/30 to-purple-900/30 backdrop-blur-sm border-t border-white/10 mt-20">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center text-indigo-200 text-sm">
                <p>&copy; 2024 Pusat Data Pemilu. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('.data-row');

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();

            rows.forEach(row => {
                const provinsiName = row.querySelector('.provinsi-name').textContent.toLowerCase();
                if (provinsiName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
