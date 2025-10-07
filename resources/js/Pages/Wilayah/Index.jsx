import { useState } from 'react';
import MainLayout from '@/Layouts/MainLayout';

export default function Index({ statistics, provinsiData }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
    const itemsPerPage = 10;

    // Filter data based on search
    const filteredData = provinsiData.filter(item =>
        item.provinsi.toLowerCase().includes(searchTerm.toLowerCase())
    );

    // Pagination
    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const paginatedData = filteredData.slice(startIndex, startIndex + itemsPerPage);

    const formatNumber = (num) => {
        return new Intl.NumberFormat('id-ID').format(num || 0);
    };

    const statsCards = [
        {
            title: 'Total Provinsi',
            value: statistics.total_provinsi,
            icon: '🏛️',
            gradient: 'from-blue-500 to-cyan-500',
            bgGradient: 'from-blue-500/20 to-cyan-500/20',
        },
        {
            title: 'Total Kabupaten',
            value: statistics.total_kabupaten,
            icon: '🏙️',
            gradient: 'from-purple-500 to-pink-500',
            bgGradient: 'from-purple-500/20 to-pink-500/20',
        },
        {
            title: 'Total Kecamatan',
            value: statistics.total_kecamatan,
            icon: '🏘️',
            gradient: 'from-green-500 to-emerald-500',
            bgGradient: 'from-green-500/20 to-emerald-500/20',
        },
        {
            title: 'Total Kelurahan',
            value: statistics.total_kelurahan,
            icon: '🏡',
            gradient: 'from-orange-500 to-red-500',
            bgGradient: 'from-orange-500/20 to-red-500/20',
        },
        {
            title: 'Total TPS',
            value: statistics.total_tps,
            icon: '🗳️',
            gradient: 'from-indigo-500 to-blue-500',
            bgGradient: 'from-indigo-500/20 to-blue-500/20',
        },
        {
            title: 'Total DPT',
            value: statistics.total_dpt,
            icon: '👥',
            gradient: 'from-pink-500 to-rose-500',
            bgGradient: 'from-pink-500/20 to-rose-500/20',
        },
    ];

    return (
        <MainLayout title="Data Wilayah - Pemilu 2024">
            {/* Statistics Cards */}
            <div className="mb-8">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in">
                    {statsCards.map((stat, index) => (
                        <div
                            key={index}
                            className="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md border border-white/20 p-6 hover:scale-105 transition-all duration-300 hover:shadow-2xl hover:shadow-purple-500/20"
                            style={{
                                animationDelay: `${index * 0.1}s`,
                            }}
                        >
                            <div className={`absolute inset-0 bg-gradient-to-br ${stat.bgGradient} opacity-0 group-hover:opacity-100 transition-opacity duration-300`}></div>

                            <div className="relative z-10">
                                <div className="flex items-center justify-between mb-4">
                                    <div className={`text-4xl p-3 rounded-xl bg-gradient-to-br ${stat.gradient} shadow-lg transform group-hover:scale-110 transition-transform duration-300`}>
                                        {stat.icon}
                                    </div>
                                    <div className={`px-3 py-1 rounded-full bg-gradient-to-r ${stat.gradient} text-white text-xs font-bold`}>
                                        LIVE
                                    </div>
                                </div>

                                <h3 className="text-white/70 text-sm font-medium mb-2 group-hover:text-white transition-colors">
                                    {stat.title}
                                </h3>

                                <p className={`text-3xl font-bold bg-gradient-to-r ${stat.gradient} bg-clip-text text-transparent`}>
                                    {formatNumber(stat.value)}
                                </p>
                            </div>

                            {/* Animated border */}
                            <div className={`absolute inset-0 rounded-2xl bg-gradient-to-r ${stat.gradient} opacity-0 group-hover:opacity-20 blur-xl transition-opacity duration-300`}></div>
                        </div>
                    ))}
                </div>
            </div>

            {/* Table Section */}
            <div className="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md rounded-2xl border border-white/20 overflow-hidden shadow-2xl">
                {/* Table Header */}
                <div className="bg-gradient-to-r from-indigo-900/50 to-purple-900/50 px-6 py-4 border-b border-white/10">
                    <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 className="text-2xl font-bold text-white mb-1">
                                Data Wilayah per Provinsi
                            </h2>
                            <p className="text-indigo-200 text-sm">
                                Menampilkan {filteredData.length} dari {provinsiData.length} provinsi
                            </p>
                        </div>

                        {/* Search Box */}
                        <div className="relative">
                            <input
                                type="text"
                                placeholder="Cari provinsi..."
                                value={searchTerm}
                                onChange={(e) => {
                                    setSearchTerm(e.target.value);
                                    setCurrentPage(1);
                                }}
                                className="w-full md:w-64 px-4 py-2 pl-10 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            />
                            <svg className="absolute left-3 top-2.5 w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {/* Table Content */}
                <div className="overflow-x-auto">
                    <table className="w-full">
                        <thead>
                            <tr className="bg-gradient-to-r from-indigo-900/30 to-purple-900/30 border-b border-white/10">
                                <th className="px-6 py-4 text-left text-xs font-bold text-indigo-200 uppercase tracking-wider">
                                    No
                                </th>
                                <th className="px-6 py-4 text-left text-xs font-bold text-indigo-200 uppercase tracking-wider">
                                    Provinsi
                                </th>
                                <th className="px-6 py-4 text-center text-xs font-bold text-indigo-200 uppercase tracking-wider">
                                    Dapil
                                </th>
                                <th className="px-6 py-4 text-center text-xs font-bold text-indigo-200 uppercase tracking-wider">
                                    Kabupaten
                                </th>
                                <th className="px-6 py-4 text-center text-xs font-bold text-indigo-200 uppercase tracking-wider">
                                    Kecamatan
                                </th>
                                <th className="px-6 py-4 text-center text-xs font-bold text-indigo-200 uppercase tracking-wider">
                                    Kelurahan
                                </th>
                                <th className="px-6 py-4 text-center text-xs font-bold text-indigo-200 uppercase tracking-wider">
                                    TPS
                                </th>
                                <th className="px-6 py-4 text-center text-xs font-bold text-indigo-200 uppercase tracking-wider">
                                    DPT
                                </th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-white/5">
                            {paginatedData.map((item, index) => (
                                <tr
                                    key={index}
                                    className="hover:bg-white/5 transition-colors duration-200 group"
                                >
                                    <td className="px-6 py-4 whitespace-nowrap">
                                        <div className="flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-sm font-bold shadow-lg group-hover:scale-110 transition-transform">
                                            {startIndex + index + 1}
                                        </div>
                                    </td>
                                    <td className="px-6 py-4">
                                        <div className="text-white font-semibold group-hover:text-indigo-300 transition-colors">
                                            {item.provinsi}
                                        </div>
                                    </td>
                                    <td className="px-6 py-4 text-center">
                                        <span className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                            {formatNumber(item.jumlah_dapil)}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 text-center">
                                        <span className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-300 border border-purple-500/30">
                                            {formatNumber(item.jumlah_kabupaten)}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 text-center">
                                        <span className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-300 border border-green-500/30">
                                            {formatNumber(item.jumlah_kecamatan)}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 text-center">
                                        <span className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-500/20 text-orange-300 border border-orange-500/30">
                                            {formatNumber(item.jumlah_kelurahan)}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 text-center">
                                        <span className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                                            {formatNumber(item.total_tps)}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 text-center">
                                        <span className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-500/20 text-pink-300 border border-pink-500/30">
                                            {formatNumber(item.total_dpt)}
                                        </span>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                {/* Pagination */}
                {totalPages > 1 && (
                    <div className="bg-gradient-to-r from-indigo-900/30 to-purple-900/30 px-6 py-4 border-t border-white/10">
                        <div className="flex items-center justify-between">
                            <div className="text-sm text-indigo-200">
                                Halaman {currentPage} dari {totalPages}
                            </div>

                            <div className="flex gap-2">
                                <button
                                    onClick={() => setCurrentPage(prev => Math.max(prev - 1, 1))}
                                    disabled={currentPage === 1}
                                    className="px-4 py-2 bg-white/10 hover:bg-white/20 disabled:bg-white/5 disabled:cursor-not-allowed text-white rounded-lg transition-all duration-200 border border-white/20 hover:border-white/40 disabled:border-white/10"
                                >
                                    ← Previous
                                </button>

                                {[...Array(totalPages)].map((_, i) => {
                                    const page = i + 1;
                                    if (
                                        page === 1 ||
                                        page === totalPages ||
                                        (page >= currentPage - 1 && page <= currentPage + 1)
                                    ) {
                                        return (
                                            <button
                                                key={page}
                                                onClick={() => setCurrentPage(page)}
                                                className={`px-4 py-2 rounded-lg transition-all duration-200 border ${
                                                    currentPage === page
                                                        ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white border-transparent shadow-lg'
                                                        : 'bg-white/10 hover:bg-white/20 text-white border-white/20 hover:border-white/40'
                                                }`}
                                            >
                                                {page}
                                            </button>
                                        );
                                    } else if (page === currentPage - 2 || page === currentPage + 2) {
                                        return <span key={page} className="px-2 text-white">...</span>;
                                    }
                                    return null;
                                })}

                                <button
                                    onClick={() => setCurrentPage(prev => Math.min(prev + 1, totalPages))}
                                    disabled={currentPage === totalPages}
                                    className="px-4 py-2 bg-white/10 hover:bg-white/20 disabled:bg-white/5 disabled:cursor-not-allowed text-white rounded-lg transition-all duration-200 border border-white/20 hover:border-white/40 disabled:border-white/10"
                                >
                                    Next →
                                </button>
                            </div>
                        </div>
                    </div>
                )}
            </div>

            <style>{`
                @keyframes fade-in {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .animate-fade-in > * {
                    animation: fade-in 0.6s ease-out forwards;
                    opacity: 0;
                }
            `}</style>
        </MainLayout>
    );
}
