@section('title', 'Riwayat Laporan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Riwayat Laporan</h1>
            <p class="text-slate-500 mt-1 font-medium">Semua laporan yang pernah Anda buat.</p>
        </div>
        <a href="{{ route('warga.reports.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-semibold rounded-xl shadow-[0_8px_30px_rgb(79,70,229,0.2)] hover:from-teal-400 hover:to-emerald-400 transition-all duration-200 hover:-translate-y-0.5 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Laporan
        </a>
    </div>

    <div class="space-y-4">
        @forelse($reports as $report)
            <a href="{{ route('warga.reports.show', $report) }}" class="block bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:border-indigo-300 transition-all duration-200">
                <div class="flex items-start gap-4">
                    <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto" class="w-20 h-20 rounded-xl object-cover flex-shrink-0 border border-slate-100">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-3">
                            <h3 class="font-bold text-slate-800 truncate">{{ $report->title }}</h3>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <x-priority-badge :report="$report" mode="label" size="sm" />
                                <x-status-badge :report="$report" size="sm" />
                            </div>
                        </div>
                        <p class="text-sm text-slate-500 mt-1 truncate">{{ $report->address }}</p>
                        <div class="flex flex-wrap gap-1.5 mt-3">
                            @foreach($report->categories as $cat)
                                <span class="px-2.5 py-0.5 text-xs font-semibold bg-teal-50 text-teal-700 rounded-full">{{ $cat->name }}</span>
                            @endforeach
                        </div>
                        <p class="text-xs font-medium text-slate-400 mt-3">{{ $report->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-16 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-slate-600 font-bold">Belum ada laporan</p>
                <p class="text-sm text-slate-500 mt-1">Mulai buat laporan pertama Anda!</p>
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