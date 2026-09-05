<nav class="bg-gradient-to-r from-teal-700 via-teal-600 to-blue-700 shadow-lg" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="text-white font-bold text-xl tracking-tight">SiapLapor</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:ml-8 sm:space-x-1">
                    @auth
                        @if(auth()->user()->role === 'warga')
                            <a href="{{ route('warga.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('warga.dashboard') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                                Dashboard
                            </a>
                            <a href="{{ route('warga.reports.create') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('warga.reports.create') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                                Buat Laporan
                            </a>
                            <a href="{{ route('warga.reports.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('warga.reports.index') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                                Riwayat Saya
                            </a>
                        @elseif(auth()->user()->role === 'petugas')
                            <a href="{{ route('petugas.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('petugas.dashboard') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                                Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.reports.*') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                                Semua Laporan
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                                Kategori
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                                Pengguna
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = ! open" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/10 rounded-lg transition-all duration-200">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                            <span class="font-bold text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 w-48 mt-2 origin-top-right bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-50"
                         style="display: none;">
                        
                        @if(auth()->user()->role === 'warga')
                        <a href="{{ route('warga.profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-teal-600 transition-colors">
                            Profil Saya
                        </a>
                        @endif
                        
                        <div class="border-t border-slate-100 my-1"></div>
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-logout')" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            Logout
                        </button>
                    </div>
                </div>
                @else
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-teal-100 hover:text-white transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium bg-white text-teal-700 hover:bg-teal-50 px-4 py-2 rounded-xl transition-all shadow-sm">Daftar</a>
                </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-lg text-white hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" x-cloak class="sm:hidden border-t border-white/10 bg-teal-700/95">
        <div class="px-4 pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->role === 'warga')
                    <a href="{{ route('warga.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('warga.dashboard') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                        Dashboard
                    </a>
                    <a href="{{ route('warga.reports.create') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('warga.reports.create') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                        Buat Laporan
                    </a>
                    <a href="{{ route('warga.reports.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('warga.reports.index') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                        Riwayat Saya
                    </a>
                    <a href="{{ route('warga.profile.edit') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('warga.profile.edit') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                        Profil Saya
                    </a>
                @elseif(auth()->user()->role === 'petugas')
                    <a href="{{ route('petugas.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('petugas.dashboard') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                        Dashboard
                    </a>
                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('admin.reports.*') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                        Semua Laporan
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                        Kategori
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('admin.users.*') ? 'bg-white/20 text-white' : 'text-teal-100 hover:bg-white/10 hover:text-white' }} transition-all duration-200">
                        Pengguna
                    </a>
                @endif

                <div class="border-t border-white/10 my-2 pt-2 flex items-center justify-between px-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                            <span class="font-bold text-white text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <span class="text-sm font-medium text-white">{{ auth()->user()->name }}</span>
                    </div>
                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-logout')" class="text-sm font-semibold text-red-200 hover:text-red-100 transition-colors">
                        Logout
                    </button>
                </div>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-teal-100 hover:bg-white/10 hover:text-white transition-all duration-200">Masuk</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-teal-100 hover:bg-white/10 hover:text-white transition-all duration-200">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Logout Confirmation Modal -->
<x-modal name="confirm-user-logout" focusable>
    <form method="POST" action="{{ route('logout') }}" class="p-6">
        @csrf
        <h2 class="text-lg font-medium text-slate-900">
            Apakah Anda yakin ingin keluar?
        </h2>
        <p class="mt-1 text-sm text-slate-600">
            Sesi Anda saat ini akan diakhiri dan Anda harus masuk kembali untuk mengakses fitur sistem.
        </p>
        <div class="mt-6 flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')">
                Batal
            </x-secondary-button>
            <x-danger-button>
                Ya, Logout
            </x-danger-button>
        </div>
    </form>
</x-modal>
