@section('title', 'Dashboard Petugas')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Dashboard Petugas</h1>
        <p class="text-slate-500 mt-1">Daftar semua laporan warga, diurutkan berdasarkan prioritas tertinggi.</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
        <form method="GET" action="{{ route('petugas.dashboard') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[180px]">
                <label for="category" class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori</label>
                <select name="category" id="category" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-sm text-slate-700">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[180px]">
                <label for="status" class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                <select name="status" id="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-sm text-slate-700">
                    <option value="">Semua Status</option>
                    <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-5 py-2.5 bg-teal-500 hover:bg-teal-400 text-white font-semibold rounded-xl text-sm transition-colors">
                    Filter
                </button>
                <a href="{{ route('petugas.dashboard') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl text-sm transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Reports List -->
    <div class="space-y-4">
        @forelse($reports as $report)
            <a href="{{ route('petugas.reports.show', $report) }}" class="block bg-white rounded-2xl shadow-sm border border-slate-100 p-5 hover:shadow-md hover:border-teal-200 transition-all duration-200">
                <div class="flex items-start gap-4">
                    <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto" class="w-24 h-24 rounded-xl object-cover flex-shrink-0 border border-slate-200">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-semibold text-slate-800">{{ $report->title }}</h3>
                                <p class="text-sm text-slate-500 mt-0.5">Pelapor: {{ $report->user->name }}</p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <x-priority-badge :report="$report" />
                                <x-status-badge :report="$report" />
                            </div>
                        </div>
                        <p class="text-sm text-slate-500 mt-1 truncate">📍 {{ $report->address }}</p>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            @foreach($report->categories as $cat)
                                <span class="px-2 py-0.5 text-xs font-medium bg-teal-50 text-teal-700 rounded-full">{{ $cat->name }}</span>
                            @endforeach
                        </div>
                        <p class="text-xs text-slate-400 mt-2">{{ $report->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-16 text-center">
                <p class="text-slate-500 font-medium">Tidak ada laporan ditemukan.</p>
            </div>
        @endif

        @if($reports->hasPages())
            <div class="mt-6">
                {{ $reports->links() }}

            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')