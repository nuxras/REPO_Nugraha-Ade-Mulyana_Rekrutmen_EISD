@extends('layouts.app')
@section('title', 'Dashboard Warga')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-slate-500 mt-1">Pantau laporan infrastruktur yang telah Anda buat.</p>
        </div>
        <a href="{{ route('warga.reports.create') }}" class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-semibold rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Laporan Baru
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $reports->total() }}</p>
                    <p class="text-sm text-slate-500">Total Laporan</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $reports->where('status', 'diproses')->count() }}</p>
                    <p class="text-sm text-slate-500">Sedang Diproses</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $reports->where('status', 'selesai')->count() }}</p>
                    <p class="text-sm text-slate-500">Selesai</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports List -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-lg font-bold text-slate-800">Laporan Terbaru Anda</h2>
        </div>

        @forelse($reports as $report)
            <a href="{{ route('warga.reports.show', $report) }}" class="block px-6 py-4 border-b border-slate-50 hover:bg-slate-50 transition-colors duration-200">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-slate-800 truncate">{{ $report->title }}</h3>
                        <p class="text-sm text-slate-500 mt-1 truncate">{{ $report->address }}</p>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            @foreach($report->categories as $cat)
                                <span class="px-2.5 py-0.5 text-xs font-semibold bg-teal-50 text-teal-700 rounded-full border border-teal-100">{{ $cat->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2 flex-shrink-0">
                        <x-status-badge :report="$report" />
                        <span class="text-xs font-medium text-slate-400">{{ $report->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="px-6 py-16 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-slate-600 font-bold">Belum ada laporan</p>
                <p class="text-sm text-slate-500 mt-1">Mulai buat laporan pertama Anda!</p>
            </div>
        @endforelse

        @if($reports->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection