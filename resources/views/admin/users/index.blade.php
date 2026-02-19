@extends('layouts.app')

@section('title', 'Verifikasi Anggota')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
            <p class="text-gray-500 text-sm">Verifikasi anggota baru dan atur hak akses pengguna.</p>
        </div>

        <form method="GET" action="{{ route('users.index') }}" class="relative w-full md:w-64">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-semibold">User Info</th>
                        <th class="px-6 py-4 font-semibold">Role Saat Ini</th>
                        <th class="px-6 py-4 font-semibold">Ubah Role</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        @if ($user->profile && $user->profile->photo)
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ asset('uploads/profiles/' . $user->profile->photo) }}"
                                                alt="">
                                        @else
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                                alt="">
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $user->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                @if ($user->role == 'admin')
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Admin
                                    </span>
                                @elseif($user->role == 'pengurus')
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                        Pengurus
                                    </span>
                                @elseif($user->role == 'anggota')
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Anggota Aktif
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        None (Belum Verif)
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <form action="{{ route('users.update-role', $user->id) }}" method="POST"
                                    class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')

                                    <select name="role"
                                        class="text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1.5 pl-2 pr-8">

                                        @if (Auth::user()->role == 'admin')
                                            <option value="none" {{ $user->role == 'none' ? 'selected' : '' }}>None
                                            </option>
                                            <option value="anggota" {{ $user->role == 'anggota' ? 'selected' : '' }}>
                                                Anggota</option>
                                            <option value="pengurus" {{ $user->role == 'pengurus' ? 'selected' : '' }}>
                                                Pengurus</option>
                                        @elseif(Auth::user()->role == 'pengurus')
                                            <option value="none" {{ $user->role == 'none' ? 'selected' : '' }}>None
                                                (Kick)
                                            </option>
                                            <option value="anggota" {{ $user->role == 'anggota' ? 'selected' : '' }}>
                                                Anggota (Verifikasi)</option>
                                        @endif
                                    </select>

                                    <button type="submit"
                                        class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 p-1.5 rounded-md transition"
                                        title="Simpan Role">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                </form>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini selamanya? Data profil juga akan hilang.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                                Tidak ada user ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
@endsection
