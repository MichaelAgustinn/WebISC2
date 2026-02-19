@extends('layouts.app')

@section('title', 'Kelola Pengurus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <style>
        .cropper-holder {
            width: 100%;
            height: 300px;
            background: #000;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
        }

        .cropper-holder img {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }
    </style>

    <div x-data="teamManager()">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Pengurus ISC</h1>
            <button @click="openModal()"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengurus
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Foto</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Jabatan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($teams as $team)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <img src="{{ asset('uploads/team/' . $team->photo) }}"
                                    class="w-12 h-12 rounded-full object-cover border border-gray-200">
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $team->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $team->role }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button @click="editData({{ $team }})"
                                    class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">Edit</button>
                                <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Hapus pengurus ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 font-medium text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada data pengurus.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <form :action="editMode ? '{{ url('admin/teams') }}/' + form.id : '{{ route('teams.store') }}'"
                        method="POST" enctype="multipart/form-data" @submit.prevent="submitForm($event)">
                        @csrf
                        <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>

                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4"
                                x-text="editMode ? 'Edit Pengurus' : 'Tambah Pengurus'"></h3>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profile</label>

                                <div x-show="imageSrc" class="mb-3">
                                    <div class="cropper-holder">
                                        <img x-ref="imageElement" :src="imageSrc" style="opacity: 0">
                                    </div>
                                    <button type="button" @click="resetImage"
                                        class="text-xs text-red-500 mt-2 underline">Hapus / Ganti Foto</button>
                                </div>

                                <div x-show="!imageSrc">
                                    <input type="file" x-ref="fileInput" @change="fileChosen" accept="image/*"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    <p class="text-xs text-gray-400 mt-1">*Wajib upload foto (kotak 1:1)</p>
                                </div>

                                <input type="file" name="photo" x-ref="finalInput" class="hidden">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" x-model="form.name"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                <input type="text" name="role" x-model="form.role"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                            <button type="button" @click="closeModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        function teamManager() {
            return {
                showModal: false,
                editMode: false,
                imageSrc: null,
                cropper: null,
                form: {
                    id: null,
                    name: '',
                    role: ''
                },

                openModal() {
                    this.showModal = true;
                    this.editMode = false;
                    this.resetForm();
                },

                editData(team) {
                    this.showModal = true;
                    this.editMode = true;
                    this.form = {
                        id: team.id,
                        name: team.name,
                        role: team.role
                    };
                    // Kita tidak load gambar lama ke cropper, user upload baru jika mau ganti
                    this.imageSrc = null;
                },

                closeModal() {
                    this.showModal = false;
                    this.resetForm();
                },

                resetForm() {
                    this.form = {
                        id: null,
                        name: '',
                        role: ''
                    };
                    this.resetImage();
                },

                resetImage() {
                    this.imageSrc = null;
                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                    }
                    this.$refs.fileInput.value = '';
                    this.$refs.finalInput.value = '';
                },

                fileChosen(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imageSrc = e.target.result;
                            this.$nextTick(() => {
                                this.initCropper();
                            });
                        };
                        reader.readAsDataURL(file);
                    }
                },

                initCropper() {
                    const image = this.$refs.imageElement;
                    image.style.opacity = 1;

                    if (this.cropper) this.cropper.destroy();

                    this.cropper = new Cropper(image, {
                        aspectRatio: 1, // Kotak (1:1)
                        viewMode: 1,
                        autoCropArea: 0.8,
                        dragMode: 'move', // User bisa geser gambar
                        cropBoxMovable: false, // Kotak crop diam di tengah
                        cropBoxResizable: false, // Ukuran crop fix
                        guides: false,
                    });
                },

                submitForm(e) {
                    const form = e.target;

                    // Jika ada gambar baru yang dicrop
                    if (this.cropper) {
                        this.cropper.getCroppedCanvas({
                            width: 300,
                            height: 300
                        }).toBlob((blob) => {
                            const file = new File([blob], "team-photo.jpg", {
                                type: "image/jpeg"
                            });
                            const container = new DataTransfer();
                            container.items.add(file);

                            // Masukkan ke input file hidden yang akan dikirim
                            this.$refs.finalInput.files = container.files;

                            // Submit form manual setelah file masuk
                            form.submit();
                        }, 'image/jpeg', 0.8);
                    } else {
                        // Jika edit tapi tidak ganti foto, atau error cropper
                        if (!this.editMode && !this.imageSrc) {
                            alert("Wajib upload foto!");
                            return;
                        }
                        form.submit();
                    }
                }
            }
        }
    </script>
@endsection
