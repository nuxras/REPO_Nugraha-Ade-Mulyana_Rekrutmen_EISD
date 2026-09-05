@section('title', 'Detail Laporan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('petugas.dashboard') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-teal-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Dashboard
    </a>

    <!-- Report Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-start justify-between gap-4 mb-4">
            <h1 class="text-2xl font-bold text-slate-800">{{ $report->title }}</h1>
            <div class="flex items-center gap-2 flex-shrink-0">
                <x-priority-badge :report="$report" />
                <x-status-badge :report="$report" />
            </div>
        </div>
        <div class="flex flex-wrap gap-1.5 mb-4">
            @foreach($report->categories as $cat)
                <span class="px-3 py-1 text-xs font-medium bg-teal-50 text-teal-700 rounded-full">{{ $cat->name }}</span>
            @endforeach
        </div>
        <p class="text-slate-600 leading-relaxed">{{ $report->description }}</p>
        <p class="text-sm text-slate-400 mt-3">Dilaporkan oleh <strong class="text-slate-600">{{ $report->user->name }}</strong> ({{ $report->user->email }}) pada {{ $report->created_at->format('d F Y, H:i') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Photo -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800">📷 Foto Bukti</h2>
            </div>
            <div class="p-4">
                <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto Laporan" class="w-full rounded-xl object-cover max-h-72 border border-slate-200">
            </div>
        </div>

        <!-- Mini Map -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800">📍 Lokasi</h2>
            </div>
            <div class="p-4">
                <div id="mini-map" class="w-full h-52 rounded-xl border border-slate-200" style="z-index: 0;"></div>
                <p class="text-sm text-slate-500 mt-2">{{ $report->address }}</p>
            </div>
        </div>
    </div>

    <!-- Update Status Form (only if not selesai) -->
    @if($report->status !== 'selesai')
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">⚡ Perbarui Status Laporan</h2>

            <form action="{{ route('petugas.reports.update-status', $report) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700 mb-1.5">Status Baru <span class="text-red-500">*</span></label>
                    <select name="status" id="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-slate-700 @error('status') border-red-300 @enderror">
                        @if($report->status === 'diterima')
                            <option value="">Pilih status...</option>
                            <option value="diproses" {{ old('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        @elseif($report->status === 'diproses')
                            <option value="">Pilih status...</option>
                            <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        @endif
                    </select>
                    @error('status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="note" class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan Penanganan <span class="text-red-500">*</span></label>
                    <textarea name="note" id="note" rows="3" placeholder="Jelaskan tindakan yang telah/sedang dilakukan..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-slate-700 placeholder-slate-400 @error('note') border-red-300 @enderror">{{ old('note') }}</textarea>
                    @error('note')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-teal-500 hover:from-blue-400 hover:to-teal-400 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/25 transition-all duration-200 hover:-translate-y-0.5">
                        Perbarui Status
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Status Timeline -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-6">📋 Riwayat Status</h2>

        <div class="relative">
            <div class="absolute left-5 top-2 bottom-2 w-0.5 bg-gradient-to-b from-teal-300 via-blue-300 to-slate-200"></div>

            <div class="space-y-6">
                @foreach($report->statusHistories->sortByDesc('created_at') as $history)
                    <div class="relative flex items-start gap-4 pl-2">
                        <div class="relative z-10 flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center
                            @if($history->status === 'selesai') bg-emerald-500
                            @elseif($history->status === 'diproses') bg-blue-500
                            @else bg-teal-500 @endif">
                            @if($history->status === 'selesai')
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @elseif($history->status === 'diproses')
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @else
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-semibold text-sm capitalize
                                    @if($history->status === 'selesai') text-emerald-700
                                    @elseif($history->status === 'diproses') text-blue-700
                                    @else text-teal-700 @endif">
                                    {{ ucfirst($history->status) }}

                                </span>
                                <span class="text-xs text-slate-400">{{ $history->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <p class="text-sm text-slate-600">{{ $history->note }}</p>
                            <p class="text-xs text-slate-400 mt-1">Oleh: {{ $history->updater->name }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const miniMap = L.map('mini-map', { scrollWheelZoom: false, dragging: false, zoomControl: false }).setView([{{ $report->latitude }}, {{ $report->longitude }}], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OSM', maxZoom: 19 }).addTo(miniMap);
    L.marker([{{ $report->latitude }}, {{ $report->longitude }}]).addTo(miniMap);
</script>
@endpush
@endsection

@extends('layouts.app')