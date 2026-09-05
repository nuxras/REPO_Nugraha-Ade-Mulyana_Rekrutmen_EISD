@section('title', 'Semua Laporan')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Semua Laporan</h1>
        <p class="text-slate-500 mt-1 font-medium">Daftar seluruh laporan yang masuk ke sistem (read-only).</p>
    </div>

    <div class="space-y-4">
        @forelse($reports as $report)
            <a href="{{ route('admin.reports.show', $report) }}" class="block bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:border-indigo-300 transition-all duration-200">
                <div class="flex items-start gap-4">
                    <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto" class="w-20 h-20 rounded-xl object-cover flex-shrink-0 border border-slate-100 shadow-sm">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-bold text-slate-800">{{ $report->title }}</h3>
                                <p class="text-sm font-medium text-slate-500 mt-1">Pelapor: {{ $report->user->name }}</p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <x-priority-badge :report="$report" mode="score" />
                                <x-status-badge :report="$report" />
                            </div>
                        </div>
                        <p class="text-sm font-medium text-slate-500 mt-2 truncate">📍 {{ $report->address }}</p>
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
                <p class="text-slate-500 font-semibold">Belum ada laporan.</p>
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