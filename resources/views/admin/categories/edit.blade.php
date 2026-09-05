@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-xl mx-auto">
    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-teal-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
    <h1 class="text-2xl font-bold text-slate-800 mt-2 mb-6">Edit Kategori: {{ $category->name }}</h1>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-5">
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-slate-700 @error('name') border-red-300 @enderror">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="priority_weight" class="block text-sm font-semibold text-slate-700 mb-1.5">Bobot Prioritas <span class="text-red-500">*</span></label>
                <input type="number" name="priority_weight" id="priority_weight" value="{{ old('priority_weight', $category->priority_weight) }}" min="1" max="100"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-slate-700 @error('priority_weight') border-red-300 @enderror">
                @error('priority_weight')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">Batal</a>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-semibold rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 hover:-translate-y-0.5">
                Perbarui
            </button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')