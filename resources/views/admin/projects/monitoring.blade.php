@extends('layouts.app')

@section('title', 'Project Monitoring')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Project Monitoring</h1>
            <p class="text-gray-500 text-sm">Pantau semua karya dan project yang telah disubmit.</p>
        </div>

        {{-- Search --}}
        {{-- Pastikan action route-nya disesuaikan dengan route method index/monitoring Anda --}}
        <form method="GET" action="{{ url()->current() }}" class="relative w-full md:w-64">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul project..."
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
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold w-32">Gambar</th>
                        <th class="px-6 py-4 font-semibold w-32">Creator</th>
                        <th class="px-6 py-4 font-semibold">Detail Project</th>
                        <th class="px-6 py-4 font-semibold w-32">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 transition-colors">

                            <!-- Menampilkan Image -->
                            <td class="px-6 py-4 align-top">
                                @if ($project->image)
                                    <img src="{{ asset('uploads/projects/' . $project->image) }}"
                                        class="h-16 w-24 object-cover rounded-lg border border-gray-200 shadow-sm">
                                @else
                                    <div
                                        class="h-16 w-24 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 text-xs text-center p-2">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 align-top">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <h3 class="text-sm font-bold text-gray-900">{{ $project->owner->name }}</h3>
                                </div>
                            </td>

                            <!-- Menampilkan Detail (Title, Division, Description, Link) -->
                            <td class="px-6 py-4 align-top">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <h3 class="text-sm font-bold text-gray-900">{{ $project->title }}</h3>

                                    @if ($project->division)
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase tracking-wide">
                                            {{ $project->division }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Deskripsi dengan line-clamp agar tidak terlalu panjang ke bawah -->
                                <p class="text-xs text-gray-500 mb-2 line-clamp-2" title="{{ $project->description }}">
                                    {{ $project->description ?? 'Tidak ada deskripsi yang ditambahkan.' }}
                                </p>


                                <a href="{{ $project->slug }}" target="_blank"
                                    class="inline-flex items-center gap-1 text-xs font-medium text-blue-600 hover:text-blue-800 hover:underline transition">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    Lihat Detial
                                </a>

                            </td>

                            <!-- Tanggal Dibuat -->
                            <td class="px-6 py-4 align-top">
                                <div class="text-sm text-gray-700 whitespace-nowrap">
                                    {{ $project->created_at->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-400 mt-0.5">
                                    {{ $project->created_at->format('H:i') }} WIB
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-gray-500 font-medium">Belum ada karya yang disubmit.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($projects->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $projects->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
