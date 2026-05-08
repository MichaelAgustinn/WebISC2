@extends('layouts.app')

@section('title', 'Verifikasi Anggota')

@section('content')

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Verifikasi Pengguna
            </h1>

            <p class="text-gray-500 text-sm">
                Aktivasi akun anggota baru Informatics Study Club.
            </p>
        </div>

        <form method="GET" action="{{ route('users.unverified') }}" class="relative w-full md:w-64">

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari email atau NIM..."
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">

            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />

            </svg>

        </form>

    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">

                    <tr>

                        <th class="px-6 py-4 font-semibold">
                            Data Pengguna
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 font-semibold text-center">
                            Verifikasi
                        </th>

                        <th class="px-6 py-4 font-semibold text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition duration-200">

                            {{-- DATA USER --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="h-12 w-12 flex-shrink-0">

                                        @if ($user->profile && $user->profile->photo)
                                            <img class="h-12 w-12 rounded-full object-cover"
                                                src="{{ asset('uploads/profiles/' . $user->profile->photo) }}"
                                                alt="">
                                        @else
                                            <img class="h-12 w-12 rounded-full object-cover"
                                                src="https://ui-avatars.com/api/?name={{ urlencode($user->email) }}&background=random"
                                                alt="">
                                        @endif

                                    </div>

                                    <div>

                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $user->email }}
                                        </div>

                                        <div class="text-sm text-gray-500 mt-1">
                                            Nama : {{ $user->name }}
                                        </div>

                                        <div class="text-sm text-gray-500 mt-1">
                                            NIM : {{ $user->nim }}
                                        </div>

                                        <div class="text-sm text-gray-500">
                                            No HP : {{ $user->phone_number }}
                                        </div>

                                        <div class="text-sm text-gray-500">
                                            Angkatan : {{ $user->angkatan }}
                                        </div>

                                    </div>

                                </div>

                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-5">

                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">

                                    Menunggu Verifikasi

                                </span>

                            </td>

                            {{-- BUTTON VERIFIKASI --}}
                            <td class="px-6 py-5 text-center">

                                <form action="{{ route('users.verify', $user->id) }}" method="POST" class="verify-form"
                                    data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                    data-nim="{{ $user->nim }}" data-phone="{{ $user->phone_number }}"
                                    data-angkatan="{{ $user->angkatan }}">

                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="role" value="anggota">

                                    <button type="submit"
                                        class="group relative overflow-hidden bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-200 transition-all duration-300 hover:scale-105">

                                        <span class="flex items-center gap-2">

                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />

                                            </svg>

                                            Aktifkan User

                                        </span>

                                    </button>

                                </form>

                            </td>

                            {{-- DELETE --}}
                            <td class="px-6 py-5 text-right">

                                <form action="{{ route('regist.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500 hover:text-red-700 transition">

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

                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">

                                Tidak ada pengguna menunggu verifikasi.

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

@section('scripts')

    {{-- SWEET ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.verify-form').forEach(form => {

            form.addEventListener('submit', function(e) {

                e.preventDefault();

                Swal.fire({

                    title: 'Verifikasi User?',
                    html: `

                        <div style="text-align:left; margin-top:15px;">

                            <p style="margin-bottom:8px;">
                                <b>Email :</b>
                                ${form.dataset.email}
                            </p>

                            <p style="margin-bottom:8px;">
                                <b>NIM :</b>
                                ${form.dataset.nim}
                            </p>

                            <p style="margin-bottom:8px;">
                                <b>No HP :</b>
                                ${form.dataset.phone}
                            </p>

                            <p>
                                <b>Angkatan :</b>
                                ${form.dataset.angkatan}
                            </p>

                        </div>

                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Aktifkan!',
                    cancelButtonText: 'Batal',
                    background: '#ffffff',
                    borderRadius: '18px'

                }).then((result) => {

                    if (result.isConfirmed) {

                        form.submit();

                    }

                });

            });

        });
    </script>

@endsection
