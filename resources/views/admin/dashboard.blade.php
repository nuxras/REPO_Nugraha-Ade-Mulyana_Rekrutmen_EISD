@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dashboard Admin</h1>
            <p class="text-slate-500 mt-1">Ringkasan statistik sistem SiapLapor.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Total Laporan -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalReports }}</p>
                    <p class="text-sm text-slate-500">Total Laporan</p>
                </div>
            </div>
        </div>

        <!-- Laporan Diterima -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $reportDiterima }}</p>
                    <p class="text-sm text-slate-500">Laporan Diterima</p>
                </div>
            </div>
        </div>

        <!-- Laporan Diproses -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $reportDiproses }}</p>
                    <p class="text-sm text-slate-500">Laporan Diproses</p>
                </div>
            </div>
        </div>

        <!-- Laporan Selesai -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $reportSelesai }}</p>
                    <p class="text-sm text-slate-500">Laporan Selesai</p>
                </div>
            </div>
        </div>

        <!-- Total Pengguna -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalUsers }}</p>
                    <p class="text-sm text-slate-500">Total Pengguna</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Laporan per Kategori -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-1">Laporan per Kategori</h2>
            <p class="text-sm text-slate-500 mb-4">Jumlah laporan yang masuk untuk tiap kategori masalah ({{ $totalCategories }} kategori).</p>
            @if($categoriesWithCount->isEmpty())
                <p class="text-sm text-slate-500">Belum ada kategori.</p>
            @else
                <div class="h-64">
                    <canvas id="categoryChart"></canvas>
                </div>
            @endif
        </div>

        <!-- Distribusi Status -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-1">Distribusi Status</h2>
            <p class="text-sm text-slate-500 mb-4">Proporsi laporan berdasarkan status.</p>
            @if($totalReports === 0)
                <p class="text-sm text-slate-500">Belum ada laporan.</p>
            @else
                <div class="h-64">
                    <canvas id="statusChart"></canvas>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    @if($categoriesWithCount->isNotEmpty())
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($categoriesWithCount->pluck('name')) !!},
            datasets: [{
                label: 'Jumlah Laporan',
                data: {!! json_encode($categoriesWithCount->pluck('reports_count')) !!},
                backgroundColor: '#14b8a6',
                borderRadius: 6,
                maxBarThickness: 40,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });
    @endif

    @if($totalReports > 0)
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Diterima', 'Diproses', 'Selesai'],
            datasets: [{
                data: [{{ $reportDiterima }}, {{ $reportDiproses }}, {{ $reportSelesai }}],
                backgroundColor: ['#94a3b8', '#f59e0b', '#10b981'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
    @endif
</script>
@endpush
@endsection