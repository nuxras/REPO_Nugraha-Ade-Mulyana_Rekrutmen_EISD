@section('title', 'Detail Laporan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('warga.reports.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-slate-500 hover:text-teal-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Riwayat
    </a>

    <!-- Report Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-start justify-between gap-4 mb-4">
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">{{ $report->title }}</h1>
            <div class="flex items-center gap-2 flex-shrink-0">
                <x-priority-badge :report="$report" mode="label-score" />
                <x-status-badge :report="$report" />
            </div>
        </div>
        <div class="flex flex-wrap gap-1.5 mb-4">
            @foreach($report->categories as $cat)
                <span class="px-3 py-1.5 text-xs font-semibold bg-teal-50 text-teal-700 rounded-full">{{ $cat->name }}</span>
            @endforeach
        </div>
        <p class="text-slate-600 leading-relaxed font-medium">{{ $report->description }}</p>
        <p class="text-sm font-medium text-slate-400 mt-4 pt-4 border-t border-slate-100">Dibuat pada {{ $report->created_at->format('d F Y, H:i') }} oleh {{ $report->user->name }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Photo -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-lg font-bold text-slate-800">📷 Foto Bukti</h2>
            </div>
            <div class="p-4">
                <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto Laporan" class="w-full rounded-xl object-cover max-h-72 border border-slate-200 shadow-sm">
            </div>
        </div>

        <!-- Mini Map -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-lg font-bold text-slate-800">📍 Lokasi</h2>
            </div>
            <div class="p-4">
                <div id="mini-map" class="w-full h-52 rounded-xl border border-slate-200 shadow-sm" style="z-index: 0;"></div>
                <p class="text-sm font-medium text-slate-600 mt-3">{{ $report->address }}</p>
                <p class="text-xs font-medium text-slate-400 mt-1">Koordinat: {{ $report->latitude }}, {{ $report->longitude }}</p>
            </div>
        </div>
    </div>

    <!-- Status Timeline -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-lg font-bold text-slate-800 mb-6">📋 Riwayat Status</h2>

        <div class="relative">
            <!-- Vertical line -->
            <div class="absolute left-5 top-2 bottom-2 w-0.5 bg-slate-100"></div>

            <div class="space-y-6">
                @foreach($report->statusHistories->sortByDesc('created_at') as $history)
                    <div class="relative flex items-start gap-4 pl-2">
                        <!-- Circle -->
                        <div class="relative z-10 flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center border-2 border-white shadow-sm
                            @if($history->status === 'selesai') bg-emerald-500
                            @elseif($history->status === 'diproses') bg-amber-500
                            @else bg-zinc-400 @endif">
                            @if($history->status === 'selesai')
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            @elseif($history->status === 'diproses')
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @else
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="font-bold text-sm capitalize
                                    @if($history->status === 'selesai') text-emerald-700
                                    @elseif($history->status === 'diproses') text-amber-700
                                    @else text-slate-700 @endif">
                                    {{ ucfirst($history->status) }}

                                </span>
                                <span class="text-xs font-medium text-slate-400">{{ $history->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            @if($history->note)
                                <p class="text-sm font-medium text-slate-600 bg-white p-3 rounded-lg border border-slate-100 mt-2 mb-2">{{ $history->note }}</p>
                            @endif
                            <p class="text-xs font-medium text-slate-400 mt-1 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Oleh: {{ $history->updater->name }}

                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Mini map
    const miniMap = L.map('mini-map', { scrollWheelZoom: false, dragging: false, zoomControl: false }).setView([{{ $report->latitude }}, {{ $report->longitude }}], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OSM',
        maxZoom: 19
    }).addTo(miniMap);
    L.marker([{{ $report->latitude }}, {{ $report->longitude }}]).addTo(miniMap);
</script>
@endpush
@endsection

@extends('layouts.app')