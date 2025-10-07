<?php
$content = file_get_contents('resources/views/peta-suara-temp.blade.php');

// Update CSS styles
$old_style = '    <style>
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
    </style>';

$new_style = '    <style>
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
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>';

$content = str_replace($old_style, $new_style, $content);

// Replace the old header section
$old_header = '    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold text-gray-800">Peta Suara Indonesia</h1>
                <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    ← Kembali ke Data Wilayah
                </a>
            </div>
            <p class="text-gray-600">Arahkan mouse ke provinsi untuk melihat data detail dan 3 partai suara terbanyak. Warna provinsi menunjukkan partai pemenang.</p>
        </div>';

$new_header = '    <!-- Main Header -->
    <div class="bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 shadow-2xl border-b-4 border-cyan-500">
        <div class="container mx-auto px-6 py-6">
            <div class="flex items-center justify-between">
                <!-- Logo and Title -->
                <div class="flex items-center gap-6">
                    <img src="/logo-polmark.jpg" alt="Polmark Indonesia" class="h-16 w-auto">
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
                        <div class="dropdown-menu hidden absolute right-0 mt-2 w-56 bg-slate-800 rounded-lg shadow-2xl border border-cyan-500 overflow-hidden z-50">
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
                    <h2 class="text-3xl font-bold text-gray-800">Peta Suara DPR RI</h2>
                    <p class="text-gray-600 mt-2">Arahkan mouse ke provinsi untuk melihat data detail dan 3 partai suara terbanyak. Warna provinsi menunjukkan partai pemenang.</p>
                </div>
            </div>
        </div>';

$content = str_replace($old_header, $new_header, $content);

file_put_contents('resources/views/peta-suara-temp.blade.php', $content);
echo "Header updated successfully!\n";
