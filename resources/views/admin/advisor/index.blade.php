@extends('layouts.app')

@section('title', 'Kelola Dosen Pembimbing')

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

    <div x-data="advisorManager()">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Dosen Pembimbing</h1>
            <button @click="openModal()"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center gap-2">
                + Tambah Dosen
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Foto</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Jabatan (Position)</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($advisors as $dosen)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <img src="{{ asset('uploads/advisors/' . $dosen->photo) }}"
                                    class="w-12 h-12 rounded-full object-cover border border-gray-200">
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $dosen->name }}</td>
                            <td class="px-6 py-4 text-indigo-600 text-sm font-medium">{{ $dosen->position }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button @click="editData({{ $dosen }})"
                                    class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">Edit</button>
                                <form action="{{ route('advisors.destroy', $dosen->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Hapus data dosen ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 font-medium text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada data dosen.</td>
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
                    <form :action="editMode ? '{{ url('admin/advisors') }}/' + form.id : '{{ route('advisors.store') }}'"
                        method="POST" enctype="multipart/form-data" @submit.prevent="submitForm($event)">
                        @csrf
                        <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>

                        <div class="bg-white px-6 pt-5 pb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-4"
                                x-text="editMode ? 'Edit Dosen' : 'Tambah Dosen'"></h3>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                                <div x-show="imageSrc" class="mb-3">
                                    <div class="cropper-holder">
                                        <img x-ref="imageElement" :src="imageSrc" style="opacity: 0">
                                    </div>
                                    <button type="button" @click="resetImage"
                                        class="text-xs text-red-500 mt-2 underline">Ganti Foto</button>
                                </div>
                                <div x-show="!imageSrc">
                                    <input type="file" x-ref="fileInput" @change="fileChosen" accept="image/*"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <input type="file" name="photo" x-ref="finalInput" class="hidden">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap & Gelar</label>
                                <input type="text" name="name" x-model="form.name"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan (Position)</label>
                                <input type="text" name="position" x-model="form.position"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500" required>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-3 flex flex-row-reverse gap-2">
                            <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-medium">Simpan</button>
                            <button type="button" @click="closeModal"
                                class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 text-sm font-medium">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        function advisorManager() {
            return {
                showModal: false,
                editMode: false,
                imageSrc: null,
                cropper: null,
                form: {
                    id: null,
                    name: '',
                    position: ''
                },

                openModal() {
                    this.showModal = true;
                    this.editMode = false;
                    this.resetForm();
                },

                editData(dosen) {
                    this.showModal = true;
                    this.editMode = true;
                    this.form = {
                        id: dosen.id,
                        name: dosen.name,
                        position: dosen.position
                    };
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
                        position: ''
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
                        aspectRatio: 3 / 4,
                        viewMode: 1,
                        autoCropArea: 1,
                        dragMode: 'move',
                        cropBoxMovable: false,
                        cropBoxResizable: false,
                        guides: false,
                    });
                },

                submitForm(e) {
                    const form = e.target;
                    if (this.cropper) {
                        this.cropper.getCroppedCanvas({
                            width: 450,
                            height: 600
                        }).toBlob((blob) => {
                            const file = new File([blob], "advisor.jpg", {
                                type: "image/jpeg"
                            });
                            const container = new DataTransfer();
                            container.items.add(file);
                            this.$refs.finalInput.files = container.files;
                            form.submit();
                        }, 'image/jpeg', 0.85);
                    } else {
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
