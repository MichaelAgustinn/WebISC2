@extends('layouts.app')

@section('title', 'Kelola Form Pendaftaran')

@section('content')
    <div class="max-w-7xl mx-auto py-8">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Formulir</h1>
            <a href="{{ route('forms.create') }}"
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition font-medium flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Form Baru
            </a>
        </div>

        @if (session('success'))
            <div
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-sm">
                            <th class="px-6 py-4 font-semibold text-gray-700">Judul Formulir</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Pertanyaan</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Responden</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Tgl Dibuat</th>
                            <th class="px-6 py-4 font-semibold text-gray-700 text-center w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($forms as $form)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($form->cover_image)
                                            <img src="{{ asset($form->cover_image) }}" alt="Cover"
                                                class="w-10 h-10 rounded object-cover border border-gray-200 shrink-0">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded bg-indigo-50 border border-indigo-100 shrink-0 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-bold text-gray-800 text-base leading-tight">{{ $form->title }}
                                            </h3>
                                            <p class="text-xs text-gray-500 truncate max-w-[200px] mt-0.5">
                                                {{ $form->description ?? 'Tidak ada deskripsi' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-middle">
                                    <span
                                        class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full border border-blue-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                        {{ $form->fields_count }} Item
                                    </span>
                                </td>

                                <td class="px-6 py-4 align-middle">
                                    <a href="{{ route('forms.responses', $form->id) }}" title="Lihat Rekap Jawaban"
                                        class="inline-flex items-center gap-1 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white transition text-xs font-semibold px-2.5 py-1.5 rounded-full border border-emerald-200 hover:border-emerald-600 cursor-pointer shadow-sm group">

                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                            </path>
                                        </svg>

                                        {{ $form->responses()->count() ?? 0 }} Jawaban

                                        <svg class="w-3.5 h-3.5 opacity-0 group-hover:opacity-100 -ml-1 transition-opacity duration-200"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500 font-medium align-middle whitespace-nowrap">
                                    {{ $form->created_at->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4 text-center align-middle">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('landing.forms.show', $form->slug) }}" target="_blank"
                                            class="p-2 text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-600 hover:text-white transition group"
                                            title="Lihat Tampilan Form">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>

                                        <a href="{{ route('forms.edit', $form->id) }}"
                                            class="p-2 text-amber-600 bg-amber-50 rounded-lg hover:bg-amber-500 hover:text-white transition group"
                                            title="Edit Form">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('forms.destroy', $form->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus formulir ini beserta semua pertanyaannya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-600 hover:text-white transition group"
                                                title="Hapus Form">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-600">Belum ada formulir yang dibuat.</p>
                                        <p class="text-sm mt-1 mb-4">Mulai kumpulkan data dengan membuat formulir baru.</p>
                                        <a href="{{ route('forms.create') }}"
                                            class="text-indigo-600 font-semibold hover:text-indigo-800 hover:underline">
                                            + Buat Formulir Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $forms->links() }}
        </div>
    </div>
@endsection
