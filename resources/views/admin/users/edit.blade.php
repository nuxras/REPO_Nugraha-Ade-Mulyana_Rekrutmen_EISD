@section('title', 'Edit Pengguna')

@section('content')
<div class="max-w-xl mx-auto">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-teal-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
    <h1 class="text-2xl font-bold text-slate-800 mt-2 mb-6">Edit Pengguna: {{ $user->name }}</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-5">
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-slate-700 @error('name') border-red-300 @enderror">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-slate-700 @error('email') border-red-300 @enderror">
                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Telepon</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-slate-700 @error('phone') border-red-300 @enderror">
                @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="address" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat</label>
                <textarea name="address" id="address" rows="2"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-slate-700 @error('address') border-red-300 @enderror">{{ old('address', $user->address) }}</textarea>
                @error('address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                <select name="role" id="role" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-slate-700 @error('role') border-red-300 @enderror">
                    <option value="warga" {{ old('role', $user->role) === 'warga' ? 'selected' : '' }}>Warga</option>
                    <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="border-t border-slate-100 pt-5">
                <h3 class="text-sm font-semibold text-slate-700 mb-3">Ubah Password <span class="text-xs text-slate-400">(kosongkan jika tidak ingin mengubah)</span></h3>
                <div class="space-y-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-600 mb-1.5">Password Baru</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-slate-700 @error('password') border-red-300 @enderror">
                        @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-600 mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all text-slate-700">
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.users.index') }}" class="px-6 py-3 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">Batal</a>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-semibold rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 hover:-translate-y-0.5">Perbarui</button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')