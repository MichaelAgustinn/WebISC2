@extends('layouts.app')

@section('title', 'Tambah Event Baru')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-8 px-4">
        <div class="max-w-4xl mx-auto">

            {{-- Header --}}
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800">
                        Tambah Event Baru
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Buat dan kelola event dengan mudah.
                    </p>
                </div>

                <a href="{{ route('admin-events.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-xl border border-gray-300 bg-white text-gray-700 hover:bg-gray-100 transition shadow-sm">
                    ← Kembali
                </a>
            </div>

            {{-- Card --}}
            <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

                {{-- Top Banner --}}
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 px-6 py-8 text-white">
                    <h2 class="text-2xl font-bold">
                        Form Tambah Event
                    </h2>
                    <p class="text-indigo-100 mt-1">
                        Isi informasi event dengan lengkap.
                    </p>
                </div>

                {{-- Form --}}
                <div class="p-6 sm:p-8">
                    <form action="{{ route('admin-events.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        {{-- Nama Event --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Event
                            </label>

                            <input type="text" name="name" value="{{ old('name') }}"
                                placeholder="Contoh: Seminar Nasional Teknologi 2026"
                                class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition shadow-sm"
                                required>

                            @error('name')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Deskripsi Event
                            </label>

                            <textarea name="deskripsi" rows="5" placeholder="Masukkan penjelasan tentang event ini..."
                                class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition shadow-sm resize-none"
                                required>{{ old('deskripsi') }}</textarea>

                            @error('deskripsi')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Link & Status --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Link WA --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Link Grup WhatsApp
                                </label>

                                <input type="url" name="link" value="{{ old('link', $event->link ?? '') }}"
                                    placeholder="https://chat.whatsapp.com/..."
                                    class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition shadow-sm"
                                    required>

                                @error('link')
                                    <p class="text-red-500 text-sm mt-2">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Status Pendaftaran
                                </label>

                                <select name="status"
                                    class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition shadow-sm">

                                    <option value="1">🟢 Buka Pendaftaran</option>
                                    <option value="0">🔴 Tutup Pendaftaran</option>

                                </select>
                            </div>
                        </div>

                        {{-- Upload Poster --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Upload Poster Event
                            </label>

                            <label for="file-upload"
                                class="group flex flex-col items-center justify-center w-full border-2 border-dashed border-indigo-300 rounded-3xl px-6 py-10 cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition">

                                <div
                                    class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center mb-4 group-hover:scale-110 transition">

                                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>

                                <p class="text-lg font-semibold text-gray-700">
                                    Klik untuk upload poster
                                </p>

                                <p class="text-sm text-gray-500 mt-1">
                                    JPG, PNG, JPEG • Maksimal 5MB
                                </p>

                                <input id="file-upload" name="photo" type="file" class="hidden"
                                    accept="image/jpeg,image/png,image/jpg" required>
                            </label>

                            {{-- Preview --}}
                            <div id="preview-container" class="hidden mt-5">
                                <p class="text-sm font-semibold text-gray-700 mb-2">
                                    Preview Poster
                                </p>

                                <img id="preview-image"
                                    class="w-full max-h-[400px] object-cover rounded-3xl border border-gray-200 shadow-lg">
                            </div>

                            @error('photo')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Button --}}
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold text-lg shadow-lg hover:scale-[1.01] hover:shadow-2xl transition-all duration-300">

                                Simpan Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const fileInput = document.getElementById('file-upload');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');

        fileInput.addEventListener('change', function() {

            const file = this.files[0];

            if (file) {

                const reader = new FileReader();

                reader.onload = function(e) {

                    previewImage.src = e.target.result;

                    previewContainer.classList.remove('hidden');
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
