@extends('layouts.app')

@section('title', 'Event Saya')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Event Saya</h1>
            <p class="text-gray-500 text-sm">Daftar semua acara dan kegiatan yang telah Anda ikuti.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold w-32">Poster</th>
                        <th class="px-6 py-4 font-semibold">Detail Event</th>
                        <th class="px-6 py-4 font-semibold w-48">Waktu Pelaksanaan</th>
                        <th class="px-6 py-4 font-semibold w-40">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($events as $event)
                        <tr class="hover:bg-gray-50 transition-colors">

                            <!-- Menampilkan Gambar/Poster Event (Asumsi ada field 'image' atau 'poster') -->
                            <td class="px-6 py-4 align-top">
                                @if ($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}"
                                        class="h-20 w-20 object-cover rounded-lg border border-gray-200 shadow-sm">
                                @else
                                    <div
                                        class="h-20 w-20 bg-gray-100 rounded-lg border border-gray-200 flex flex-col items-center justify-center text-gray-400 text-xs text-center p-2">
                                        <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        No Image
                                    </div>
                                @endif
                            </td>

                            <!-- Menampilkan Detail Event (Nama & Deskripsi Singkat) -->
                            <td class="px-6 py-4 align-top">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <h3 class="text-sm font-bold text-gray-900">{{ $event->title ?? $event->name }}</h3>

                                    {{-- Asumsi ada field tipe event (Internal/Umum) --}}
                                    @if (isset($event->type))
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase tracking-wide">
                                            {{ $event->type }}
                                        </span>
                                    @endif
                                </div>

                                <p class="text-xs text-gray-500 mb-2 line-clamp-2" title="{{ $event->description }}">
                                    {{ $event->description ?? 'Tidak ada deskripsi untuk event ini.' }}
                                </p>
                            </td>

                            <!-- Waktu Pelaksanaan Event (Asumsi ada field 'start_date' atau 'date') -->
                            <td class="px-6 py-4 align-top">
                                @if (isset($event->start_date))
                                    <div class="flex items-center gap-2 text-sm text-gray-700 mb-1">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">TBA</span>
                                @endif

                                {{-- Jika ada field lokasi --}}
                                @if (isset($event->location))
                                    <div class="flex items-start gap-2 text-xs text-gray-500 mt-2">
                                        <svg class="w-3.5 h-3.5 mt-0.5 text-gray-400 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="line-clamp-1">{{ $event->location }}</span>
                                    </div>
                                @endif
                            </td>

                            <!-- Tanggal Mendaftar/Join (Diambil dari pivot table user_event) -->
                            <td class="px-6 py-4 align-top">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-md bg-green-50 text-green-700 border border-green-100">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Terdaftar
                                </span>
                                <div class="text-xs text-gray-400 mt-2">
                                    {{ $event->pivot->created_at ? $event->pivot->created_at->format('d M Y, H:i') : '-' }}
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500 font-medium">Anda belum mengikuti event apapun.</p>
                                <a href="{{ route('events.public') }}"
                                    class="mt-2 inline-block text-sm text-indigo-600 hover:text-indigo-800 font-medium">Cari
                                    Event Sekarang &rarr;</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($events->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $events->links() }}
            </div>
        @endif
    </div>
@endsection
