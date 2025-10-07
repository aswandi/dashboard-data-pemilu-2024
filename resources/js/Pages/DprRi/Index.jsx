import { useState, useEffect } from 'react';
import { router } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import { Chart as ChartJS, ArcElement, CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { Bar } from 'react-chartjs-2';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

ChartJS.register(ArcElement, CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend, ChartDataLabels);

// Cache untuk menyimpan gambar yang sudah dimuat
const imageCache = new Map();

// Preload images
const preloadImages = (urls) => {
    return Promise.all(
        urls.map(url => {
            if (!url) return Promise.resolve(null);
            if (imageCache.has(url)) return Promise.resolve(imageCache.get(url));

            return new Promise((resolve) => {
                const img = new Image();
                img.onload = () => {
                    imageCache.set(url, img);
                    resolve(img);
                };
                img.onerror = () => resolve(null);
                img.src = url;
            });
        })
    );
};

// Custom plugin untuk menampilkan logo partai
const logoPlugin = {
    id: 'logoPlugin',
    afterDatasetsDraw: (chart) => {
        const ctx = chart.ctx;
        const xAxis = chart.scales.x;
        const yAxis = chart.scales.y;

        chart.data.datasets[0].logoUrls?.forEach((logoUrl, index) => {
            if (logoUrl && imageCache.has(logoUrl)) {
                const img = imageCache.get(logoUrl);
                if (img && img.complete && img.naturalWidth > 0) {
                    const x = xAxis.getPixelForValue(index);
                    const logoSize = 45;
                    const logoX = x - logoSize / 2;
                    const logoY = yAxis.bottom + 8;

                    ctx.save();

                    // Draw white background circle for logo
                    ctx.fillStyle = 'rgba(255, 255, 255, 0.95)';
                    ctx.beginPath();
                    ctx.arc(x, logoY + logoSize / 2, logoSize / 2 + 3, 0, 2 * Math.PI);
                    ctx.fill();

                    // Create circular clipping path for logo
                    ctx.beginPath();
                    ctx.arc(x, logoY + logoSize / 2, logoSize / 2, 0, 2 * Math.PI);
                    ctx.clip();

                    // Draw logo (will be clipped to circle)
                    ctx.drawImage(img, logoX, logoY, logoSize, logoSize);

                    ctx.restore();
                }
            }
        });
    }
};

ChartJS.register(logoPlugin);

export default function Index({ calegData, filters, provinsiList, dapilList, partaiList, chartData, totalSuara, mapData }) {
    const [filterForm, setFilterForm] = useState({
        provinsi: filters.provinsi || '',
        dapil: filters.dapil || '',
        partai: filters.partai || '',
        per_page: filters.per_page || 10,
    });

    const [map, setMap] = useState(null);
    const [imagesLoaded, setImagesLoaded] = useState(false);
    const [chartKey, setChartKey] = useState(0);

    // Preload logo images
    useEffect(() => {
        const logoUrls = chartData.map(item => item.partai_logo);
        console.log('Loading logo images:', logoUrls);

        preloadImages(logoUrls).then(() => {
            console.log('All images loaded, cache:', imageCache);
            setImagesLoaded(true);
            // Force chart to re-render after images are loaded
            setTimeout(() => {
                setChartKey(prev => prev + 1);
            }, 100);
        });
    }, [chartData]);

    // Handle filter change
    const handleFilterChange = (e) => {
        const { name, value } = e.target;
        setFilterForm(prev => ({ ...prev, [name]: value }));
    };

    // Apply filters
    const applyFilters = () => {
        router.get(route('data-utama.dpr-ri'), filterForm, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    // Reset filters
    const resetFilters = () => {
        setFilterForm({
            provinsi: '',
            dapil: '',
            partai: '',
            per_page: 10,
        });
        router.get(route('data-utama.dpr-ri'), {}, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    // Generate chart title based on active filters
    const getChartTitle = () => {
        const activeFilters = [];
        if (filters.provinsi) activeFilters.push(`Provinsi: ${filters.provinsi}`);
        if (filters.dapil) activeFilters.push(`Dapil: ${filters.dapil}`);
        if (filters.partai) activeFilters.push(`Partai: ${filters.partai}`);

        if (activeFilters.length > 0) {
            return `Distribusi Suara per Partai (${activeFilters.join(', ')})`;
        }
        return 'Distribusi Suara per Partai (Seluruh Indonesia)';
    };

    // Chart data preparation dengan warna partai dan persentase
    const barChartData = {
        labels: chartData.map(item => item.partai_singkat || item.partai_politik),
        datasets: [
            {
                label: 'Total Suara',
                data: chartData.map(item => item.total_suara),
                backgroundColor: chartData.map(item => item.partai_warna || 'rgba(99, 102, 241, 0.8)'),
                borderColor: chartData.map(item => item.partai_warna || 'rgba(99, 102, 241, 1)'),
                borderWidth: 2,
                logoUrls: chartData.map(item => item.partai_logo),
            },
        ],
    };

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                bottom: 65, // Ruang untuk logo di bawah
            }
        },
        plugins: {
            legend: {
                display: false,
            },
            title: {
                display: true,
                text: getChartTitle(),
                color: '#bfdbfe',
                font: {
                    size: 16,
                    weight: 'bold',
                },
                padding: {
                    bottom: 20
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const value = context.parsed.y;
                        const percentage = totalSuara > 0 ? ((value / totalSuara) * 100).toFixed(2) : 0;
                        return `Suara: ${value.toLocaleString('id-ID')} (${percentage}%)`;
                    }
                }
            },
            datalabels: {
                anchor: 'end',
                align: 'top',
                formatter: function(value, context) {
                    const percentage = totalSuara > 0 ? ((value / totalSuara) * 100).toFixed(1) : 0;
                    return percentage + '%';
                },
                color: '#bfdbfe',
                font: {
                    weight: 'bold',
                    size: 12,
                },
                backgroundColor: 'rgba(30, 58, 138, 0.7)',
                borderRadius: 4,
                padding: {
                    top: 4,
                    bottom: 4,
                    left: 6,
                    right: 6
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#bfdbfe',
                    callback: function(value) {
                        return value.toLocaleString('id-ID');
                    },
                    font: {
                        size: 11
                    }
                },
                grid: {
                    color: 'rgba(255, 255, 255, 0.08)',
                },
            },
            x: {
                ticks: {
                    color: '#bfdbfe',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    padding: 55, // Ruang antara label dan logo
                },
                grid: {
                    display: false,
                },
            },
        },
    };

    // Initialize map
    useEffect(() => {
        if (!map) {
            const mapInstance = L.map('map').setView([-2.5, 118], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 18
            }).addTo(mapInstance);

            setMap(mapInstance);
        }

        return () => {
            if (map) {
                map.remove();
            }
        };
    }, []);

    // Update map with province boundaries and data
    useEffect(() => {
        if (map && mapData.length > 0) {
            // Clear existing GeoJSON layers
            map.eachLayer((layer) => {
                if (layer instanceof L.GeoJSON) {
                    map.removeLayer(layer);
                }
            });

            // Create province lookup
            const provinceLookup = {};
            mapData.forEach(prov => {
                provinceLookup[prov.kode] = prov;
            });

            // Load GeoJSON boundary data
            fetch('/indonesia-provinces.geojson')
                .then(response => response.json())
                .then(geojsonData => {
                    L.geoJSON(geojsonData, {
                        style: (feature) => {
                            const kode = feature.properties.kode;
                            const provData = provinceLookup[kode];
                            const fillColor = provData?.warna || '#6B7280';

                            return {
                                fillColor: fillColor,
                                weight: 2,
                                opacity: 1,
                                color: '#1E40AF',
                                fillOpacity: 0.6
                            };
                        },
                        onEachFeature: (feature, layer) => {
                            const kode = feature.properties.kode;
                            const nama = feature.properties.nama;
                            const provData = provinceLookup[kode];

                            // Create tooltip content
                            let tooltipContent = `
                                <div style="min-width: 300px; padding: 12px;">
                                    <h3 style="font-weight: bold; font-size: 18px; margin-bottom: 12px; color: #1E40AF; border-bottom: 2px solid #ddd; padding-bottom: 8px;">${nama}</h3>
                            `;

                            if (provData) {
                                tooltipContent += `
                                    <table style="width: 100%; font-size: 14px; margin-bottom: 12px;">
                                        <tr style="border-bottom: 1px solid #eee;">
                                            <td style="font-weight: 600; padding: 4px 12px 4px 0;">Total Suara:</td>
                                            <td style="text-align: right; padding: 4px 0;">${provData.total_suara.toLocaleString('id-ID')}</td>
                                        </tr>
                                    </table>
                                `;

                                // Add top 3 parties
                                if (provData.top_partai && provData.top_partai.length > 0) {
                                    tooltipContent += `
                                        <div style="margin-top: 12px; padding-top: 12px; border-top: 2px solid #ddd;">
                                            <h4 style="font-weight: 600; font-size: 14px; margin-bottom: 8px; color: #374151;">3 Partai Suara Terbanyak:</h4>
                                    `;

                                    provData.top_partai.forEach((partai, index) => {
                                        const medal = index === 0 ? '🥇' : (index === 1 ? '🥈' : '🥉');
                                        tooltipContent += `
                                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 4px 0; font-size: 12px;">
                                                <span style="font-weight: 500;">${medal} ${partai.nama}</span>
                                                <span style="color: #2563EB; font-weight: bold;">${partai.suara.toLocaleString('id-ID')}</span>
                                            </div>
                                        `;
                                    });

                                    tooltipContent += '</div>';
                                }
                            } else {
                                tooltipContent += '<p style="color: #6B7280; font-style: italic;">Tidak ada data untuk provinsi ini</p>';
                            }

                            tooltipContent += '</div>';

                            layer.bindPopup(tooltipContent);
                        }
                    }).addTo(map);
                })
                .catch(error => {
                    console.error('Error loading GeoJSON:', error);
                });
        }
    }, [map, mapData]);

    return (
        <MainLayout title="Data Caleg DPR RI">
            <div className="space-y-6">
                {/* Page Header */}
                <div className="relative bg-gradient-to-br from-slate-800/90 via-blue-900/90 to-slate-800/90 backdrop-blur-md border border-white/20 rounded-2xl p-8 shadow-2xl overflow-hidden">
                    {/* Decorative elements */}
                    <div className="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
                    <div className="absolute bottom-0 left-0 w-64 h-64 bg-cyan-500/10 rounded-full blur-3xl"></div>

                    <div className="relative">
                        <h2 className="text-4xl font-bold bg-gradient-to-r from-white via-blue-100 to-cyan-100 bg-clip-text text-transparent mb-3">
                            Data Caleg DPR RI
                        </h2>
                        <p className="text-blue-200/80 text-lg">Daftar lengkap calon legislatif DPR RI Pemilu 2024</p>
                    </div>
                </div>

                {/* Filters */}
                <div className="bg-gradient-to-br from-slate-800/90 via-blue-900/90 to-slate-800/90 backdrop-blur-md border border-white/20 rounded-2xl p-6 shadow-xl">
                    <h3 className="text-2xl font-bold bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent mb-5">Filter Data</h3>
                    <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label className="block text-blue-200 text-sm font-semibold mb-2">Provinsi</label>
                            <select
                                name="provinsi"
                                value={filterForm.provinsi}
                                onChange={handleFilterChange}
                                className="w-full px-4 py-2.5 bg-slate-900/70 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 hover:border-cyan-400/50"
                            >
                                <option value="">Semua Provinsi</option>
                                {provinsiList.map((prov) => (
                                    <option key={prov} value={prov}>{prov}</option>
                                ))}
                            </select>
                        </div>
                        <div>
                            <label className="block text-blue-200 text-sm font-semibold mb-2">Dapil</label>
                            <select
                                name="dapil"
                                value={filterForm.dapil}
                                onChange={handleFilterChange}
                                className="w-full px-4 py-2.5 bg-slate-900/70 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 hover:border-cyan-400/50"
                            >
                                <option value="">Semua Dapil</option>
                                {dapilList.map((dapil) => (
                                    <option key={dapil} value={dapil}>{dapil}</option>
                                ))}
                            </select>
                        </div>
                        <div>
                            <label className="block text-blue-200 text-sm font-semibold mb-2">Partai</label>
                            <select
                                name="partai"
                                value={filterForm.partai}
                                onChange={handleFilterChange}
                                className="w-full px-4 py-2.5 bg-slate-900/70 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 hover:border-cyan-400/50"
                            >
                                <option value="">Semua Partai</option>
                                {partaiList.map((partai) => (
                                    <option key={partai} value={partai}>{partai}</option>
                                ))}
                            </select>
                        </div>
                        <div>
                            <label className="block text-blue-200 text-sm font-semibold mb-2">Tampilkan</label>
                            <select
                                name="per_page"
                                value={filterForm.per_page}
                                onChange={handleFilterChange}
                                className="w-full px-4 py-2.5 bg-slate-900/70 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 hover:border-cyan-400/50"
                            >
                                <option value="10">10 data</option>
                                <option value="25">25 data</option>
                                <option value="50">50 data</option>
                                <option value="100">100 data</option>
                            </select>
                        </div>
                    </div>
                    <div className="flex space-x-4">
                        <button
                            onClick={applyFilters}
                            className="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 transform"
                        >
                            Terapkan Filter
                        </button>
                        <button
                            onClick={resetFilters}
                            className="px-8 py-3 bg-gradient-to-r from-slate-700 to-slate-600 hover:from-slate-600 hover:to-slate-500 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 transform"
                        >
                            Reset Filter
                        </button>
                    </div>
                </div>

                {/* Table */}
                <div className="bg-gradient-to-br from-slate-800/90 via-blue-900/90 to-slate-800/90 backdrop-blur-md border border-white/20 rounded-2xl overflow-hidden shadow-xl">
                    <div className="overflow-x-auto">
                        <table className="w-full">
                            <thead className="bg-slate-900/70 border-b border-white/20">
                                <tr>
                                    <th className="px-6 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">No</th>
                                    <th className="px-6 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Provinsi</th>
                                    <th className="px-6 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Dapil</th>
                                    <th className="px-6 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Partai</th>
                                    <th className="px-6 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">No. Urut</th>
                                    <th className="px-6 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Nama Caleg</th>
                                    <th className="px-6 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Jenis Kelamin</th>
                                    <th className="px-6 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Tempat Tinggal</th>
                                    <th className="px-6 py-4 text-right text-xs font-semibold text-blue-200 uppercase tracking-wider">Suara</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-white/10">
                                {calegData.data.map((caleg, index) => (
                                    <tr key={caleg.id} className="hover:bg-white/5 transition-colors duration-200">
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-white">
                                            {calegData.from + index}
                                        </td>
                                        <td className="px-6 py-4 text-sm text-white">{caleg.pro_nama}</td>
                                        <td className="px-6 py-4 text-sm text-white">{caleg.dapil_nama}</td>
                                        <td className="px-6 py-4 text-sm text-white">{caleg.partai_politik}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-white">{caleg.nomor_urut}</td>
                                        <td className="px-6 py-4 text-sm text-white">{caleg.nama}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-white">{caleg.jenis_kelamin}</td>
                                        <td className="px-6 py-4 text-sm text-white">{caleg.tempat_tinggal}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-white text-right">
                                            {caleg.suara ? caleg.suara.toLocaleString('id-ID') : '-'}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    {/* Pagination */}
                    <div className="bg-slate-900/50 px-6 py-4 flex items-center justify-between border-t border-white/20">
                        <div className="text-sm text-blue-200">
                            Menampilkan {calegData.from} sampai {calegData.to} dari {calegData.total} data
                        </div>
                        <div className="flex space-x-2">
                            {calegData.links.map((link, index) => (
                                <button
                                    key={index}
                                    onClick={() => link.url && router.get(link.url)}
                                    disabled={!link.url}
                                    className={`px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 ${
                                        link.active
                                            ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg'
                                            : link.url
                                            ? 'bg-slate-800/70 text-blue-200 hover:bg-slate-700/70 hover:text-white'
                                            : 'bg-slate-900/40 text-slate-500 cursor-not-allowed'
                                    }`}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                />
                            ))}
                        </div>
                    </div>
                </div>

                {/* Chart */}
                <div className="bg-gradient-to-br from-slate-800/90 via-blue-900/90 to-slate-800/90 backdrop-blur-md border border-white/20 rounded-2xl p-6 shadow-xl">
                    <h3 className="text-2xl font-bold bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent mb-4">Grafik Distribusi Suara</h3>
                    <div className="h-96">
                        {imagesLoaded ? (
                            <Bar key={`chart-${chartKey}`} data={barChartData} options={chartOptions} />
                        ) : (
                            <div className="flex items-center justify-center h-full">
                                <div className="flex flex-col items-center space-y-3">
                                    <div className="animate-spin rounded-full h-10 w-10 border-b-2 border-cyan-400"></div>
                                    <div className="text-blue-200">Memuat logo partai...</div>
                                </div>
                            </div>
                        )}
                    </div>
                </div>

                {/* Map */}
                <div className="bg-gradient-to-br from-slate-800/90 via-blue-900/90 to-slate-800/90 backdrop-blur-md border border-white/20 rounded-2xl p-6 shadow-xl">
                    <h3 className="text-2xl font-bold bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent mb-2">
                        {(() => {
                            const activeFilters = [];
                            if (filters.provinsi) activeFilters.push(`Provinsi: ${filters.provinsi}`);
                            if (filters.dapil) activeFilters.push(`Dapil: ${filters.dapil}`);
                            if (filters.partai) activeFilters.push(`Partai: ${filters.partai}`);

                            if (activeFilters.length > 0) {
                                return `Peta Sebaran Suara per Provinsi (${activeFilters.join(', ')})`;
                            }
                            return 'Peta Sebaran Suara per Provinsi (Seluruh Indonesia)';
                        })()}
                    </h3>
                    <p className="text-blue-200/80 text-sm mb-4">Klik pada provinsi untuk melihat detail. Warna menunjukkan partai dengan suara terbanyak di provinsi tersebut.</p>
                    <div id="map" className="h-[600px] rounded-2xl overflow-hidden border border-white/10"></div>
                    <div className="mt-4">
                        <p className="text-blue-200/80 text-xs text-center">
                            Warna provinsi menunjukkan partai pemenang di provinsi tersebut berdasarkan total suara yang diperoleh.
                        </p>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
