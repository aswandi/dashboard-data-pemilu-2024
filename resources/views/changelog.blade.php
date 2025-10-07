<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changelog - Dashboard Data Pemilu 2024</title>
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
                            <a href="/peta-suara" class="block px-6 py-3 text-white hover:bg-gradient-to-r hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 border-b border-slate-700">
                                <div class="font-bold">DPR RI</div>
                                <div class="text-xs text-gray-400">Dewan Perwakilan Rakyat</div>
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
        <div class="relative bg-gradient-to-br from-white via-blue-50 to-cyan-50 rounded-2xl shadow-2xl p-8 border border-blue-200 mb-8 overflow-hidden">
            <!-- Animated Background -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-cyan-200/20 to-blue-300/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-blue-200/20 to-purple-200/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>

            <div class="relative flex items-center gap-4">
                <div class="bg-gradient-to-br from-cyan-500 to-blue-600 p-4 rounded-xl shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-4xl font-extrabold bg-gradient-to-r from-blue-700 to-cyan-600 bg-clip-text text-transparent">
                        Changelog
                    </h2>
                    <p class="text-gray-600 mt-2">Catatan Update dan Perbaikan Sistem</p>
                </div>
            </div>
        </div>

        <!-- Changelog Items -->
        <div class="space-y-6">
            @foreach($changelogs as $changelog)
            <div class="relative bg-gradient-to-br from-white via-blue-50/50 to-cyan-50/50 rounded-xl shadow-lg p-6 border border-blue-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- Version Badge -->
                <div class="absolute top-4 right-4">
                    <span class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white px-4 py-2 rounded-lg font-bold text-sm shadow-md">
                        {{ $changelog['version'] }}
                    </span>
                </div>

                <!-- Date -->
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-gray-700 font-semibold">{{ \Carbon\Carbon::parse($changelog['date'])->format('d F Y') }}</span>
                </div>

                <!-- Changes List -->
                <div class="space-y-3 mt-4">
                    @foreach($changelog['changes'] as $change)
                    <div class="flex items-start gap-3 group">
                        <div class="mt-1.5">
                            <div class="w-2 h-2 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-full group-hover:scale-125 transition-transform duration-200"></div>
                        </div>
                        <p class="text-gray-700 leading-relaxed flex-1">{{ $change }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-cyan-500 p-6 rounded-lg">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-cyan-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="font-bold text-gray-800 mb-2">Informasi Update</h4>
                    <p class="text-gray-600">
                        Sistem ini terus dikembangkan dan diperbarui untuk memberikan pengalaman terbaik dalam mengakses data Pemilu 2024.
                        Semua perbaikan dan penambahan fitur akan dicatat di halaman ini.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 border-t-4 border-cyan-500 mt-12">
        <div class="container mx-auto px-6 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-center md:text-left">
                    <p class="text-cyan-400 font-bold text-lg">© 2025 POLMARK INDONESIA</p>
                    <p class="text-gray-400 text-sm mt-1">Dashboard Data Pemilu 2024</p>
                </div>
                <div>
                    <a href="/changelog" class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-lg">
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
