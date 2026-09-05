<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SiapLapor - Platform pelaporan dan pemantauan infrastruktur kota berbasis prioritas untuk mewujudkan kota berkelanjutan (SDG 11)">
    <title>SiapLapor - Platform Pelaporan Infrastruktur Kota</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    {!! app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']) !!}
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="antialiased bg-slate-50">
    <div class="min-h-screen flex flex-col relative overflow-hidden">
        <!-- Colorful Background Elements -->
        <div class="absolute top-0 inset-x-0 h-[600px] bg-gradient-to-br from-indigo-500/20 via-purple-500/10 to-teal-500/20 blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute top-40 -left-40 w-96 h-96 bg-teal-400/20 rounded-full blur-3xl pointer-events-none -z-10"></div>

        <!-- Navbar -->
        <nav class="relative z-10 flex items-center justify-between px-6 lg:px-12 py-6">
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-teal-500/30">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-slate-800 font-extrabold text-2xl tracking-tight">SiapLapor</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-teal-600 transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-400 hover:to-blue-500 rounded-xl transition-all duration-200 shadow-lg shadow-teal-500/25 hover:-translate-y-0.5">
                    Daftar Gratis
                </a>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-1 relative z-10 px-6 lg:px-12 pt-20 pb-24 flex flex-col items-center justify-center">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/60 backdrop-blur-md border border-white rounded-full mb-8 text-sm font-semibold text-teal-700 shadow-sm">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-teal-500"></span>
                    </span>
                    Sistem Aktif — SDG 11 Kota Berkelanjutan
                </div>
                <h1 class="text-5xl sm:text-6xl font-extrabold text-slate-800 leading-[1.15] tracking-tight mb-6">
                    Laporkan Infrastruktur Kota
                    <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-500 to-blue-600">Lebih Cerdas & Responsif</span>
                </h1>
                <p class="text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto mb-10 leading-relaxed font-medium">
                    Platform partisipasi warga untuk melaporkan jalan rusak, fasilitas publik, atau masalah infrastruktur lainnya dengan kalkulasi prioritas penanganan otomatis.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-400 hover:to-blue-500 rounded-xl transition-all duration-200 shadow-lg shadow-teal-500/30 hover:-translate-y-0.5">
                        Mulai Melapor Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-slate-700 bg-white/80 hover:bg-white border border-slate-200 rounded-xl transition-all duration-200 shadow-sm backdrop-blur-md hover:-translate-y-0.5">
                        Masuk ke Akun
                    </a>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="w-full max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mt-24">
                <div class="bg-white/80 backdrop-blur-xl p-8 rounded-2xl shadow-xl shadow-slate-200/50 border border-white flex flex-col hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex items-center justify-center mb-6 shadow-md shadow-indigo-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Peta Interaktif</h3>
                    <p class="text-slate-500 leading-relaxed font-medium">Tandai lokasi masalah langsung di peta. Koordinat terekam otomatis untuk akurasi pelaporan maksimal.</p>
                </div>

                <div class="bg-white/80 backdrop-blur-xl p-8 rounded-2xl shadow-xl shadow-slate-200/50 border border-white flex flex-col hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center mb-6 shadow-md shadow-amber-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Skor Prioritas</h3>
                    <p class="text-slate-500 leading-relaxed font-medium">Sistem pintar yang menilai kedaruratan masalah berdasarkan bobot kategori dan sebaran laporan di area yang sama.</p>
                </div>

                <div class="bg-white/80 backdrop-blur-xl p-8 rounded-2xl shadow-xl shadow-slate-200/50 border border-white flex flex-col hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-400 to-emerald-500 rounded-xl flex items-center justify-center mb-6 shadow-md shadow-teal-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Lacak Real-Time</h3>
                    <p class="text-slate-500 leading-relaxed font-medium">Pantau terus status perbaikan. Semua histori penanganan oleh petugas dicatat transparan dari awal hingga selesai.</p>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative z-10 bg-white/50 backdrop-blur-md px-6 lg:px-12 py-8 mt-auto border-t border-slate-200/60">
            <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-teal-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="font-bold text-slate-800">SiapLapor</span>
                </div>
                <p class="text-slate-500 text-sm font-medium">© {{ date('Y') }} Platform Pelaporan Infrastruktur Kota.</p>
            </div>
        </footer>
    </div>
</body>
</html>
