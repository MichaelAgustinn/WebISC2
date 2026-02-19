@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <style>
        /* Container Cropper di Modal */
        .cropper-holder {
            width: 100%;
            height: 400px !important;
            background-color: #000;
            /* Background hitam agar fokus */
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 0.5rem;
            position: relative;
        }

        .cropper-holder img {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }

        /* Styling Kotak Crop (Indigo) */
        .cropper-view-box {
            outline: 2px solid #6366f1;
            outline-color: #6366f1;
        }

        .cropper-line,
        .cropper-point {
            background-color: #6366f1;
        }

        .cropper-modal {
            background-color: rgba(0, 0, 0, 0.85);
            opacity: 1;
        }
    </style>

    <div class="max-w-6xl mx-auto" x-data="imageCropper()">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Pengaturan Akun</h1>
            <p class="text-gray-500 text-sm">Kelola informasi profil dan bio Anda untuk ditampilkan kepada anggota lain.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center sticky top-6">

                        <div class="relative mx-auto w-32 h-32 mb-4 group cursor-pointer" @click="$refs.fileInput.click()">
                            <div
                                class="w-32 h-32 rounded-full overflow-hidden border-4 border-indigo-50 shadow-inner bg-gray-100">
                                <template x-if="previewUrl">
                                    <img :src="previewUrl" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!previewUrl">
                                    @if ($user->profile && $user->profile->photo)
                                        <img src="{{ asset('uploads/profiles/' . $user->profile->photo) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff"
                                            class="w-full h-full object-cover">
                                    @endif
                                </template>
                            </div>

                            <div
                                class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none">
                                <span class="text-white text-xs font-semibold">Ubah Foto</span>
                            </div>
                        </div>

                        <h2 class="text-lg font-bold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-sm text-indigo-600 font-medium mb-1">{{ ucfirst($user->role) }}</p>

                        <div class="mt-6 border-t border-gray-100 pt-4 text-left">
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Upload Foto Baru</label>

                            <input type="file" name="photo" x-ref="fileInput" @change="fileChosen"
                                accept="image/png, image/jpeg, image/jpg"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer">
                            <p class="text-[10px] text-gray-400 mt-1">*Maksimal 2MB (JPG/PNG)</p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Informasi Pribadi
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                                <input type="text" name="nim" value="{{ old('nim', $user->profile->nim ?? '') }}"
                                    placeholder="D02..."
                                    class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                                <input type="text" name="phone_number"
                                    value="{{ old('phone_number', $user->profile->phone_number ?? '') }}"
                                    placeholder="08..."
                                    class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bio / Tentang Saya</label>
                                <textarea name="bio" rows="4"
                                    class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Ceritakan sedikit tentang diri Anda, minat, atau keahlian...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                                <p class="text-xs text-gray-400 mt-1">Bio ini akan ditampilkan di halaman detail anggota.
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 border-t border-gray-100 pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Data Keanggotaan
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                                    <input type="number" name="angkatan"
                                        value="{{ old('angkatan', $user->profile->angkatan ?? '') }}" placeholder="202X"
                                        class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Divisi Peminatan</label>
                                    <select name="division"
                                        class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                        <option value="">-- Pilih Divisi --</option>
                                        @foreach (['mobile' => 'Mobile Development', 'website' => 'Website Development', 'uiux' => 'UI/UX Design', 'iot' => 'Internet of Things', 'sistem_cerdas' => 'Sistem Cerdas'] as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('division', $user->profile->division ?? '') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tim Khusus
                                        (Opsional)</label>
                                    <select name="special_team"
                                        class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                        <option value="">Tidak ada</option>
                                        <option value="Tim Marketing"
                                            {{ old('special_team', $user->profile->special_team ?? '') == 'Tim Marketing' ? 'selected' : '' }}>
                                            Tim Marketing</option>
                                        <option value="Tim Kreatif"
                                            {{ old('special_team', $user->profile->special_team ?? '') == 'Tim Kreatif' ? 'selected' : '' }}>
                                            Tim Kreatif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 flex justify-end">
                            <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 font-medium text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-90 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modal-title">
                            Sesuaikan Area Foto
                        </h3>

                        <div class="cropper-holder relative">
                            <img x-ref="imageToCrop" alt="Foto Crop" style="opacity: 0;">
                        </div>

                        <p class="text-xs text-gray-500 mt-3 text-center">
                            Geser kotak biru untuk memilih area foto.
                        </p>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" @click="cropAndSave"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:w-auto sm:text-sm">
                            Potong & Simpan
                        </button>
                        <button type="button" @click="closeModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        function imageCropper() {
            return {
                showModal: false,
                previewUrl: null,
                cropper: null,
                file: null,

                fileChosen(event) {
                    this.file = event.target.files[0];
                    if (!this.file) return;

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        // Reset Gambar & Opacity
                        const img = this.$refs.imageToCrop;
                        img.src = e.target.result;
                        img.style.opacity = '1';

                        this.showModal = true;

                        // PENTING: Tunggu Modal Render baru jalan
                        this.$nextTick(() => {
                            this.initCropper();
                        });
                    };
                    reader.readAsDataURL(this.file);
                },

                initCropper() {
                    if (this.cropper) {
                        this.cropper.destroy();
                    }

                    const image = this.$refs.imageToCrop;

                    this.cropper = new Cropper(image, {
                        aspectRatio: 1, // Output Wajib Kotak (1:1)
                        viewMode: 1, // Mode 1: Box tidak boleh keluar dari gambar

                        // --- KUNCI MATI GAMBAR (Statis) ---
                        dragMode: 'none',
                        toggleDragModeOnDblclick: false,
                        movable: false,
                        zoomable: false,
                        scalable: false,
                        rotatable: false,

                        // --- FITUR KOTAK CROP (Dinamis) ---
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        autoCropArea: 0.8, // 80%

                        // --- VISUAL ---
                        guides: true,
                        center: true,
                        background: false, // Hilangkan checkerboard
                        modal: true,

                        // --- FIX RENDER ---
                        ready() {
                            this.cropper.clear();
                            this.cropper.crop();
                        }
                    });
                },

                cropAndSave() {
                    if (!this.cropper) return;

                    const canvas = this.cropper.getCroppedCanvas({
                        width: 400,
                        height: 400,
                        fillColor: '#ffffff'
                    });

                    this.previewUrl = canvas.toDataURL('image/jpeg');

                    canvas.toBlob((blob) => {
                        const dataTransfer = new DataTransfer();
                        const fileName = "avatar-" + Date.now() + ".jpg";
                        const newFile = new File([blob], fileName, {
                            type: "image/jpeg"
                        });

                        dataTransfer.items.add(newFile);
                        this.$refs.fileInput.files = dataTransfer.files;

                        this.closeModal();
                    }, 'image/jpeg', 0.85);
                },

                closeModal() {
                    this.showModal = false;
                    setTimeout(() => {
                        if (this.cropper) {
                            this.cropper.destroy();
                            this.cropper = null;
                        }
                        // Jika user batal tapi belum ada preview (belum jadi crop), reset input
                        if (!this.previewUrl) {
                            this.$refs.fileInput.value = '';
                        }
                        this.$refs.imageToCrop.src = '';
                    }, 300);
                }
            }
        }
    </script>
@endsection
