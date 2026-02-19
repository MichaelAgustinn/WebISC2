@extends('layouts.app')

@section('title', 'Upload Dokumen')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Upload Dokumen Baru</h3>
                <a href="{{ route('documents.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Kembali</a>
            </div>

            <div class="p-6">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Dokumen</label>
                        <input type="text" name="name"
                            class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                            placeholder="Contoh: KRS Semester 5 - 2024" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Dokumen</label>
                        <select name="type"
                            class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                            <option value="krs">Kartu Rencana Studi (KRS)</option>
                            <option value="kartu_kontrol">Kartu Kontrol</option>
                            <option value="lainnya">Lainnya (Sertifikat/Surat)</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">File</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition cursor-pointer relative">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="file-upload"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Upload sebuah file</span>
                                        <input id="file-upload" name="file" type="file" class="sr-only" required
                                            accept=".pdf,.doc,.docx,.jpg,.png,.xls,.xlsx">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, IMG up to 5MB</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-lg transition shadow-sm">
                        Simpan Dokumen
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
