@extends('layouts.app')

@section('title', 'Pendaftar Event: ' . $event->name)

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin-events.index') }}"
                    class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center gap-1 font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Pendaftar Event</h1>
            <p class="text-gray-500 text-sm">Menampilkan daftar anggota yang terdaftar pada event
                <strong>{{ $event->name }}</strong>.</p>
        </div>

        <div
            class="bg-indigo-50 text-indigo-700 px-4 py-2 rounded-lg font-semibold border border-indigo-100 flex items-center gap-2">
            <i class="ri-group-fill"></i> Total Pendaftar: {{ $registrants->total() }}
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama Anggota</th>
                        <th class="px-6 py-4 font-semibold">Kontak & Email</th>
                        <th class="px-6 py-4 font-semibold">Divisi / Angkatan</th>
                        <th class="px-6 py-4 font-semibold text-right">Waktu Daftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($registrants as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($user->profile && $user->profile->photo)
                                        <img src="{{ asset('uploads/profiles/' . $user->profile->photo) }}"
                                            class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0f204b&color=fff"
                                            class="w-10 h-10 rounded-full border border-gray-200">
                                    @endif

                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">NIM: {{ $user->profile->nim ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-800">{{ $user->email }}</div>
                                <div class="text-xs text-gray-500">{{ $user->profile->phone_number ?? '-' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-800 font-medium">
                                    {{ $user->profile && $user->profile->division ? ucwords(str_replace('_', ' ', $user->profile->division)) : '-' }}
                                </div>
                                <div class="text-xs text-gray-500">Angkatan {{ $user->profile->angkatan ?? '-' }}</div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <!-- Mengambil waktu pendaftaran dari tabel pivot event_user -->
                                <div class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($user->pivot->created_at)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($user->pivot->created_at)->format('H:i') }} WIB
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="text-lg font-medium text-gray-900">Belum ada Pendaftar</p>
                                <p class="text-sm mt-1">Belum ada anggota yang mendaftar ke event ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($registrants->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $registrants->links() }}
            </div>
        @endif
    </div>
@endsection
