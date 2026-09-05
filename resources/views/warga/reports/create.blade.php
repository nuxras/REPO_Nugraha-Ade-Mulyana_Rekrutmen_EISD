@section('title', 'Buat Laporan Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('warga.dashboard') }}" class="inline-flex items-center gap-1 text-sm font-medium text-slate-500 hover:text-teal-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Dashboard
        </a>
        <h1 class="text-2xl font-bold text-slate-800 mt-2 tracking-tight">Buat Laporan Baru</h1>
        <p class="text-slate-500 mt-1 font-medium">Laporkan masalah infrastruktur yang Anda temukan di kota.</p>
    </div>

    <form action="{{ route('warga.reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-5">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-slate-700 mb-1.5">Judul Laporan <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Contoh: Jalan Berlubang di Jl. Merdeka"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-indigo-100 transition-all duration-200 text-slate-800 placeholder-zinc-400 @error('title') border-red-300 @enderror">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="4" placeholder="Jelaskan kondisi masalah secara detail..."
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-indigo-100 transition-all duration-200 text-slate-800 placeholder-zinc-400 @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Categories (Multi-select checkboxes) -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Masalah <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach($categories as $category)
                        <label class="flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-teal-50/30 cursor-pointer transition-all duration-200 @if(in_array($category->id, old('categories', []))) border-indigo-400 bg-teal-50/50 @endif">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}

                                class="w-4 h-4 text-teal-600 border-zinc-300 rounded focus:ring-teal-500">
                            <div>
                                <span class="text-sm font-semibold text-slate-700">{{ $category->name }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('categories')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Photo Upload -->
            <div>
                <label for="photo" class="block text-sm font-semibold text-slate-700 mb-1.5">Foto Bukti <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="file" name="photo" id="photo" accept="image/*"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-indigo-100 transition-all duration-200 text-slate-700 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-white file:border-slate-200 file:border file:text-slate-700 hover:file:bg-slate-50 @error('photo') border-red-300 @enderror">
                </div>
                <p class="text-xs font-medium text-slate-400 mt-1.5">Format: JPG, PNG, GIF. Maksimal 5MB.</p>
                @error('photo')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                <div id="photo-preview" class="mt-4 hidden">
                    <img id="preview-image" src="" alt="Preview" class="w-full max-w-sm rounded-xl border border-slate-200 shadow-sm">
                </div>
            </div>
        </div>

        <!-- Map & Location -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-5">
            <h2 class="text-lg font-bold text-slate-800">📍 Lokasi Masalah</h2>
            <p class="text-sm font-medium text-slate-500 -mt-3">Klik pada peta untuk menandai lokasi masalah. Koordinat akan terisi otomatis.</p>

            <!-- Map -->
            <div id="map" class="w-full h-80 rounded-xl border border-slate-200 z-0" style="z-index: 0;"></div>
            @error('latitude')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="latitude" class="block text-sm font-semibold text-slate-700 mb-1.5">Latitude</label>
                    <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 text-sm cursor-not-allowed">
                </div>
                <div>
                    <label for="longitude" class="block text-sm font-semibold text-slate-700 mb-1.5">Longitude</label>
                    <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 text-sm cursor-not-allowed">
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat <span class="text-red-500">*</span></label>
                <input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="Masukkan alamat lokasi atau klik peta untuk auto-isi"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-indigo-100 transition-all duration-200 text-slate-800 placeholder-zinc-400 @error('address') border-red-300 @enderror">
                @error('address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('warga.dashboard') }}" class="px-6 py-3 text-sm font-semibold text-slate-600 hover:text-slate-800 transition-colors">Batal</a>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-semibold rounded-xl shadow-[0_8px_30px_rgb(79,70,229,0.2)] transition-all duration-200 hover:-translate-y-0.5">
                Kirim Laporan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Initialize Leaflet Map centered on Bandung
    const map = L.map('map').setView([-6.9175, 107.6191], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    let marker = null;

    // If old values exist, place marker
    @if(old('latitude') && old('longitude'))
        marker = L.marker([{{ old('latitude') }}, {{ old('longitude') }}]).addTo(map);
        map.setView([{{ old('latitude') }}, {{ old('longitude') }}], 16);
    @endif

    map.on('click', function(e) {
        const lat = e.latlng.lat.toFixed(7);
        const lng = e.latlng.lng.toFixed(7);

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }

        // Reverse geocoding via Nominatim
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
            .then(res => res.json())
            .then(data => {
                if (data.display_name) {
                    document.getElementById('address').value = data.display_name;
                }
            })
            .catch(() => {});
    });

    // Photo preview
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('preview-image').src = ev.target.result;
                document.getElementById('photo-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection

@extends('layouts.app')