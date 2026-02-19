@extends('layouts.app')

@section('title', 'Arsip Dokumen Saya')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Arsip Dokumen</h1>
            <p class="text-gray-500 text-sm">Simpan KRS, Kartu Kontrol, dan berkas penting lainnya di sini.</p>
        </div>
        <a href="{{ route('documents.create') }}"
            class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 shadow-sm transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            Upload Dokumen
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($documents as $doc)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition group relative">

                <div class="flex items-start justify-between mb-4">
                    <div
                        class="p-3 rounded-lg 
                        @if (Str::endsWith($doc->file_path, ['.pdf'])) bg-red-50 text-red-600 
                        @elseif(Str::endsWith($doc->file_path, ['.doc', '.docx'])) bg-blue-50 text-blue-600 
                        @elseif(Str::endsWith($doc->file_path, ['.xls', '.xlsx'])) bg-green-50 text-green-600 
                        @else bg-gray-50 text-gray-600 @endif">

                        @if (Str::endsWith($doc->file_path, ['.pdf']))
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        @elseif(Str::endsWith($doc->file_path, ['.jpg', '.png', '.jpeg']))
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        @else
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        @endif
                    </div>

                    <span
                        class="px-2.5 py-1 text-xs font-semibold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase tracking-wide">
                        {{ str_replace('_', ' ', $doc->type) }}
                    </span>
                </div>

                <h3 class="font-bold text-gray-800 text-lg mb-1 truncate" title="{{ $doc->name }}">{{ $doc->name }}
                </h3>
                <p class="text-xs text-gray-400 mb-4">Diupload: {{ $doc->created_at->format('d M Y') }}</p>

                <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                    <a href="{{ route('documents.download', $doc->id) }}"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12" />
                        </svg>
                        Download
                    </a>

                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST"
                        onsubmit="return confirm('Hapus dokumen ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div
                class="col-span-full flex flex-col items-center justify-center py-12 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900">Belum ada dokumen</h3>
                <p class="text-gray-500 max-w-sm mt-1 mb-6">Upload KRS semester ini atau dokumen penting lainnya untuk
                    disimpan di arsip Anda.</p>
                <a href="{{ route('documents.create') }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Mulai Upload</a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $documents->links() }}
    </div>
@endsection
