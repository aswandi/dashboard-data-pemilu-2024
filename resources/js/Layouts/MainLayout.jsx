import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';

export default function MainLayout({ children, title = 'Pusat Data Pemilu 2024' }) {
    const [isDataUtamaOpen, setIsDataUtamaOpen] = useState(false);

    return (
        <>
            <Head title={title} />
            <div className="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
                {/* Header */}
                <header className="relative bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 border-b border-white/20 shadow-2xl">
                    {/* Decorative gradient overlay */}
                    <div className="absolute inset-0 bg-gradient-to-r from-blue-600/10 via-cyan-500/10 to-blue-600/10 backdrop-blur-sm"></div>

                    <div className="relative mx-auto px-4 sm:px-6 lg:px-8 py-6">
                        <div className="flex items-center justify-between">
                            {/* Logo and Title Section */}
                            <div className="flex items-center space-x-6">
                                {/* PolMark Logo */}
                                <div className="bg-white/95 backdrop-blur-md rounded-2xl px-6 py-3 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-300 hover:scale-105">
                                    <img
                                        src="/lampiran/logo-polmark-tp.png"
                                        alt="PolMark Indonesia"
                                        className="h-12 w-auto"
                                    />
                                </div>

                                {/* Divider */}
                                <div className="h-16 w-px bg-gradient-to-b from-transparent via-white/30 to-transparent"></div>

                                {/* Title Section */}
                                <div>
                                    <h1 className="text-3xl font-bold bg-gradient-to-r from-white via-blue-100 to-cyan-100 bg-clip-text text-transparent tracking-tight leading-tight">
                                        Pusat Data Pemilu 2024
                                    </h1>
                                    <p className="text-blue-200/80 text-sm mt-1 font-medium tracking-wide">
                                        Sistem Informasi Data Wilayah Indonesia
                                    </p>
                                </div>
                            </div>

                            {/* Live Data Indicator */}
                            <div className="flex items-center space-x-3 bg-gradient-to-r from-emerald-500/20 to-green-500/20 px-4 py-2 rounded-full border border-emerald-400/30 backdrop-blur-sm">
                                <div className="relative">
                                    <div className="h-2.5 w-2.5 bg-emerald-400 rounded-full animate-pulse"></div>
                                    <div className="absolute inset-0 h-2.5 w-2.5 bg-emerald-400 rounded-full animate-ping opacity-75"></div>
                                </div>
                                <span className="text-emerald-300 text-sm font-semibold">Live Data</span>
                            </div>
                        </div>
                    </div>

                    {/* Bottom gradient decoration */}
                    <div className="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 via-cyan-500 to-blue-600"></div>
                </header>

                {/* Navigation Menu */}
                <nav className="relative bg-gradient-to-r from-slate-800/80 via-blue-900/80 to-slate-800/80 backdrop-blur-md border-b border-white/10 shadow-lg z-50">
                    <div className="mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex space-x-8">
                            {/* Data Utama Menu */}
                            <div className="relative group z-50">
                                <button
                                    onClick={() => setIsDataUtamaOpen(!isDataUtamaOpen)}
                                    className="px-6 py-4 text-blue-100 hover:text-white hover:bg-gradient-to-r hover:from-blue-600/20 hover:to-cyan-600/20 transition-all duration-300 flex items-center space-x-2 font-semibold tracking-wide"
                                >
                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                    </svg>
                                    <span>DATA UTAMA</span>
                                    <svg className={`w-4 h-4 transition-transform duration-300 ${isDataUtamaOpen ? 'rotate-180' : ''}`} fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {/* Dropdown Menu */}
                                {isDataUtamaOpen && (
                                    <div className="absolute left-0 mt-0 w-64 bg-gradient-to-br from-slate-800/98 to-blue-900/98 backdrop-blur-xl border border-white/20 rounded-b-2xl shadow-2xl overflow-hidden">
                                        <Link
                                            href="#"
                                            className="group block px-5 py-3.5 text-blue-100 hover:text-white hover:bg-gradient-to-r hover:from-blue-600/30 hover:to-cyan-600/30 transition-all duration-300 border-b border-white/10 font-medium"
                                        >
                                            <div className="flex items-center space-x-3">
                                                <div className="w-2 h-2 bg-blue-400 rounded-full group-hover:scale-125 transition-transform duration-300"></div>
                                                <span>PILPRES</span>
                                            </div>
                                        </Link>
                                        <Link
                                            href="#"
                                            className="group block px-5 py-3.5 text-blue-100 hover:text-white hover:bg-gradient-to-r hover:from-blue-600/30 hover:to-cyan-600/30 transition-all duration-300 border-b border-white/10 font-medium"
                                        >
                                            <div className="flex items-center space-x-3">
                                                <div className="w-2 h-2 bg-cyan-400 rounded-full group-hover:scale-125 transition-transform duration-300"></div>
                                                <span>DPD</span>
                                            </div>
                                        </Link>
                                        <Link
                                            href={route('data-utama.dpr-ri')}
                                            className="group block px-5 py-3.5 text-blue-100 hover:text-white hover:bg-gradient-to-r hover:from-blue-600/30 hover:to-cyan-600/30 transition-all duration-300 border-b border-white/10 font-medium"
                                        >
                                            <div className="flex items-center space-x-3">
                                                <div className="w-2 h-2 bg-emerald-400 rounded-full group-hover:scale-125 transition-transform duration-300"></div>
                                                <span>DPR RI</span>
                                            </div>
                                        </Link>
                                        <Link
                                            href="#"
                                            className="group block px-5 py-3.5 text-blue-100 hover:text-white hover:bg-gradient-to-r hover:from-blue-600/30 hover:to-cyan-600/30 transition-all duration-300 border-b border-white/10 font-medium"
                                        >
                                            <div className="flex items-center space-x-3">
                                                <div className="w-2 h-2 bg-purple-400 rounded-full group-hover:scale-125 transition-transform duration-300"></div>
                                                <span>DPRD PROVINSI</span>
                                            </div>
                                        </Link>
                                        <Link
                                            href="#"
                                            className="group block px-5 py-3.5 text-blue-100 hover:text-white hover:bg-gradient-to-r hover:from-blue-600/30 hover:to-cyan-600/30 transition-all duration-300 rounded-b-2xl font-medium"
                                        >
                                            <div className="flex items-center space-x-3">
                                                <div className="w-2 h-2 bg-pink-400 rounded-full group-hover:scale-125 transition-transform duration-300"></div>
                                                <span>DPRD KAB/KOTA</span>
                                            </div>
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </nav>

                {/* Main Content */}
                <main className="mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {children}
                </main>

                {/* Footer */}
                <footer className="relative bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 border-t border-white/20 mt-20 shadow-2xl">
                    {/* Top gradient decoration */}
                    <div className="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 via-cyan-500 to-blue-600"></div>

                    <div className="mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div className="flex flex-col items-center justify-center space-y-4">
                            {/* Logo */}
                            <div className="bg-white/95 backdrop-blur-md rounded-xl px-5 py-2.5 shadow-lg border border-white/20">
                                <img
                                    src="/lampiran/logo-polmark-tp.png"
                                    alt="PolMark Indonesia"
                                    className="h-8 w-auto"
                                />
                            </div>

                            {/* Copyright */}
                            <div className="text-center">
                                <p className="text-blue-200/90 text-sm font-medium">
                                    &copy; 2024 Pusat Data Pemilu - PolMark Indonesia
                                </p>
                                <p className="text-blue-300/60 text-xs mt-1">
                                    Political Marketing Consulting
                                </p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}
