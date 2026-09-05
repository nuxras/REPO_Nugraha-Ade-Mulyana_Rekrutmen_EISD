@section('title', 'Edit Profil')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Profil</h1>

    <form action="{{ route('warga.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-5">
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all duration-200 text-slate-700 @error('name') border-red-300 @enderror">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                <input type="email" value="{{ $user->email }}" disabled
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 cursor-not-allowed">
                <p class="text-xs text-slate-400 mt-1">Email tidak dapat diubah.</p>
            </div>

            <div>
                <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor Telepon</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all duration-200 text-slate-700 @error('phone') border-red-300 @enderror">
                @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="address" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat</label>
                <textarea name="address" id="address" rows="3" placeholder="Alamat lengkap Anda"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all duration-200 text-slate-700 @error('address') border-red-300 @enderror">{{ old('address', $user->address) }}</textarea>
                @error('address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="border-t border-slate-100 pt-5">
                <h3 class="text-sm font-semibold text-slate-700 mb-3">Ubah Password <span class="text-xs text-slate-400">(opsional)</span></h3>

                <div class="space-y-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-600 mb-1.5">Password Baru</label>
                        <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all duration-200 text-slate-700 @error('password') border-red-300 @enderror">
                        @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-600 mb-1.5">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all duration-200 text-slate-700">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-semibold rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 hover:-translate-y-0.5">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')