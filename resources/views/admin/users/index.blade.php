@section('title', 'Kelola Pengguna')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Kelola Pengguna</h1>
            <p class="text-slate-500 mt-1 font-medium">Kelola akun Warga dan Petugas.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-semibold rounded-xl shadow-[0_8px_30px_rgb(79,70,229,0.2)] hover:from-teal-400 hover:to-emerald-400 transition-all duration-200 hover:-translate-y-0.5 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengguna
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50/50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Telepon</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-sm text-white
                                    @if($user->role === 'admin') bg-gradient-to-br from-purple-400 to-purple-600
                                    @elseif($user->role === 'petugas') bg-gradient-to-br from-teal-400 to-teal-600
                                    @else bg-gradient-to-br from-blue-400 to-blue-600 @endif">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-bold text-slate-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-medium text-sm">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-bold rounded-full capitalize
                                @if($user->role === 'admin') bg-purple-100 text-purple-700
                                @elseif($user->role === 'petugas') bg-teal-50 text-teal-700
                                @else bg-blue-50 text-blue-700 @endif">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-600">{{ $user->phone ?? '-' }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1.5 text-xs font-semibold text-teal-600 hover:text-indigo-800 bg-teal-50 hover:bg-indigo-100 rounded-lg transition-colors">Edit</a>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium">Belum ada pengguna.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $users->links() }}

            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')