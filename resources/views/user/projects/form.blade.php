@extends('layouts.app')

@section('title', isset($project) ? 'Edit Karya' : 'Tulis Karya Baru')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/compressorjs/1.2.1/compressor.min.js"></script>

    <div class="max-w-6xl mx-auto" x-data="projectForm()">

        <form action="{{ isset($project) ? route('projects.update', $project->id) : route('projects.store') }}" method="POST"
            enctype="multipart/form-data" @submit.prevent="submitForm">
            @csrf
            @if (isset($project))
                @method('PUT')
            @endif

            <div class="flex flex-col lg:flex-row gap-8">

                <div class="lg:w-2/3">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 min-h-[80vh]">

                        <input type="text" name="title" placeholder="Judul Karya..."
                            value="{{ old('title', $project->title ?? '') }}"
                            class="w-full text-4xl font-bold text-gray-800 placeholder-gray-300 border-none focus:ring-0 p-0 mb-6"
                            required>

                        <div class="h-px bg-gray-100 mb-6 w-20"></div>

                        <textarea name="description" x-ref="descInput" @input="resizeTextarea"
                            placeholder="Ceritakan tentang karyamu di sini..."
                            class="w-full text-lg text-gray-600 placeholder-gray-300 border-none focus:ring-0 p-0 resize-none min-h-[500px]"
                            required>{{ old('description', $project->description ?? '') }}</textarea>
                    </div>
                </div>

                <div class="lg:w-1/3 space-y-6">

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h3 class="font-bold text-gray-800 mb-4">Publikasi</h3>
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition flex justify-center items-center gap-2">
                            <span x-show="!isCompressing">Simpan Karya</span>
                            <span x-show="isCompressing">Mengompres Gambar...</span>
                        </button>
                        <a href="{{ route('myproject.index') }}"
                            class="block text-center text-gray-500 text-sm mt-3 hover:underline">Batal</a>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h3 class="font-bold text-gray-800 mb-4">Cover Image</h3>

                        <div class="relative group cursor-pointer" @click="$refs.fileInput.click()">
                            <div
                                class="aspect-video rounded-lg bg-gray-50 border-2 border-dashed border-gray-300 flex flex-col items-center justify-center overflow-hidden hover:bg-gray-100 transition">

                                <template x-if="previewUrl">
                                    <img :src="previewUrl" class="w-full h-full object-cover">
                                </template>

                                <template x-if="!previewUrl">
                                    @if (isset($project) && $project->image)
                                        <img src="{{ asset('uploads/projects/' . $project->image) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="text-center p-6 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-10 w-10 mx-auto mb-2 text-gray-300" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-xs">Klik untuk upload</p>
                                        </div>
                                    @endif
                                </template>
                            </div>
                        </div>

                        <input type="file" x-ref="fileInput" @change="handleImageUpload" accept="image/*" class="hidden">
                        <input type="file" name="image" x-ref="finalInput" class="hidden">

                        <p class="text-xs text-gray-400 mt-2 text-center">Format: JPG, PNG. Max Compressed.</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h3 class="font-bold text-gray-800 mb-3">Kategori Divisi</h3>
                        <div class="space-y-2">
                            @foreach (['mobile' => 'Mobile Dev', 'website' => 'Web Dev', 'iot' => 'IoT', 'uiux' => 'UI/UX', 'sistem_cerdas' => 'AI'] as $key => $label)
                                <label
                                    class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="division" value="{{ $key }}"
                                        class="text-indigo-600 focus:ring-indigo-500"
                                        {{ old('division', $project->division ?? '') == $key ? 'checked' : '' }} required>
                                    <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5" x-data="{ searchQuery: '' }">
                        <h3 class="font-bold text-gray-800 mb-1">Anggota Tim</h3>
                        <p class="text-xs text-gray-500 mb-3">Pilih anggota tambahan (Kamu otomatis terdaftar).</p>

                        <div class="relative mb-3">
                            <input type="text" x-model="searchQuery" placeholder="Cari nama anggota..."
                                class="w-full text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 pl-8 py-2">
                            <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <div class="max-h-48 overflow-y-auto space-y-1 border border-gray-200 rounded-lg p-2">
                            @foreach ($users as $user)
                                <label
                                    class="flex items-center gap-2 p-2 hover:bg-gray-50 rounded cursor-pointer transition"
                                    x-show="'{{ strtolower($user->name) }}'.includes(searchQuery.toLowerCase())"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100">

                                    <input type="checkbox" name="team_members[]" value="{{ $user->id }}"
                                        class="rounded text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        {{ isset($currentTeam) && in_array($user->id, $currentTeam) ? 'checked' : '' }}>

                                    <div class="flex items-center gap-2">
                                        @if ($user->profile && $user->profile->photo)
                                            <img src="{{ asset('uploads/profiles/' . $user->profile->photo) }}"
                                                class="w-6 h-6 rounded-full object-cover">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=24&background=random"
                                                class="w-6 h-6 rounded-full">
                                        @endif
                                        <span class="text-sm text-gray-700 font-medium">{{ $user->name }}</span>
                                    </div>
                                </label>
                            @endforeach

                            @if ($users->isEmpty())
                                <p class="text-xs text-center py-4 text-gray-400">Belum ada user lain untuk ditambahkan.
                                </p>
                            @else
                                <p class="text-xs text-center py-4 text-gray-400"
                                    x-show="$el.parentElement.querySelectorAll('label[style*=\'display: none\']').length === {{ $users->count() }}">
                                    Tidak ditemukan.
                                </p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script>
        function projectForm() {
            return {
                previewUrl: null,
                isCompressing: false,

                init() {
                    this.resizeTextarea(); // Init height saat load
                },

                resizeTextarea() {
                    const el = this.$refs.descInput;
                    if (el) {
                        el.style.height = 'auto';
                        el.style.height = el.scrollHeight + 'px';
                    }
                },

                handleImageUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    // 1. Tampilkan Preview segera
                    this.previewUrl = URL.createObjectURL(file);

                    // 2. Mulai Kompresi
                    this.isCompressing = true;

                    new Compressor(file, {
                        quality: 0.6, // Kompres kualitas jadi 60%
                        maxWidth: 1280, // Resize lebar max
                        success: (result) => {
                            // 3. Masukkan file hasil kompresi ke input hidden 'image'
                            const dataTransfer = new DataTransfer();
                            // Kita harus rename file agar tetap memiliki ekstensi yang benar
                            const newFile = new File([result], result.name, {
                                type: result.type
                            });

                            dataTransfer.items.add(newFile);
                            this.$refs.finalInput.files = dataTransfer.files;

                            this.isCompressing = false;
                            console.log('Kompresi Berhasil:', result.size / 1024, 'KB');
                        },
                        error: (err) => {
                            console.error(err.message);
                            alert('Gagal mengompres gambar');
                            this.isCompressing = false;
                        },
                    });
                },

                submitForm(e) {
                    if (this.isCompressing) {
                        alert('Tunggu sebentar, gambar sedang diproses...');
                        return;
                    }

                    @if (!isset($project))
                        if (this.$refs.finalInput.files.length === 0) {
                            alert('Silakan upload gambar cover terlebih dahulu.');
                            return;
                        }
                    @endif

                    e.target.submit();
                }
            }
        }
    </script>
@endsection
