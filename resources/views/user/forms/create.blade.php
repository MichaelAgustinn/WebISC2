@extends('layouts.app')

@section('title', 'Buat Form Baru')

@section('content')
    <div x-data="formBuilder()" class="max-w-4xl mx-auto pb-10">

        <div class="mb-6 flex justify-between items-center border-b border-gray-200 pb-4">
            <div>
                <a href="#"
                    class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 transition mb-2">
                    <i class="ri-arrow-left-line mr-1"></i> Kembali
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Buat Pendaftaran / Form Baru</h1>
            </div>
        </div>

        <form action="{{ route('forms.store') }}" method="POST" id="dynamicForm">
            @csrf

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 border-t-4 border-t-indigo-600">
                <div class="mb-4">
                    <input type="text" name="title" required
                        class="w-full border-0 border-b-2 border-gray-200 focus:border-indigo-600 focus:ring-0 text-3xl font-bold text-gray-800 px-0 py-2 transition"
                        placeholder="Formulir Tanpa Judul" value="{{ old('title') }}">
                </div>
                <div>
                    <textarea name="description" rows="2"
                        class="w-full border-0 border-b border-gray-200 focus:border-indigo-600 focus:ring-0 text-sm text-gray-600 px-0 py-2 transition"
                        placeholder="Deskripsi formulir..."></textarea>
                </div>
            </div>

            <div id="fields-container" class="space-y-6">
                <template x-for="(field, index) in fields" :key="field.id">
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 relative group transition-all duration-300 hover:shadow-md">

                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 text-gray-300 opacity-0 group-hover:opacity-100 cursor-move">
                            <i class="ri-draggable text-xl"></i>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">

                            <div class="md:col-span-8">
                                <input type="text" x-model="field.label" :name="'fields[' + index + '][label]'" required
                                    class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-medium"
                                    placeholder="Pertanyaan Tanpa Judul">
                            </div>

                            <div class="md:col-span-4">
                                <select x-model="field.type" :name="'fields[' + index + '][type]'"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm">
                                    <option value="text">Jawaban Singkat (Teks)</option>
                                    <option value="textarea">Paragraf (Teks Panjang)</option>
                                    <option value="number">Angka</option>
                                    <option value="date">Tanggal</option>
                                    <option value="file">Upload File / Gambar</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 mb-6">
                            <div x-show="field.type === 'text' || field.type === 'number'"
                                class="border-b border-dotted border-gray-300 w-1/2 pb-2 text-gray-400 text-sm">
                                Teks jawaban singkat
                            </div>
                            <div x-show="field.type === 'textarea'"
                                class="border-b border-dotted border-gray-300 w-3/4 pb-2 mt-4 text-gray-400 text-sm">
                                Teks jawaban panjang
                            </div>
                            <div x-show="field.type === 'file'"
                                class="mt-2 text-gray-500 bg-gray-50 p-4 rounded border border-dashed flex items-center gap-2 w-max">
                                <i class="ri-upload-cloud-2-line"></i> Responden akan mengunggah file
                            </div>
                            <div x-show="field.type === 'date'"
                                class="mt-2 text-gray-500 bg-gray-50 px-4 py-2 rounded border w-max flex items-center gap-2">
                                <i class="ri-calendar-line"></i> Hari / Bulan / Tahun
                            </div>
                        </div>

                        <div class="flex justify-end items-center gap-6 pt-4 border-t border-gray-100">

                            <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700 font-medium">
                                <span x-text="field.is_required ? 'Wajib diisi' : 'Opsional'"></span>
                                <input type="hidden" :name="'fields[' + index + '][is_required]'" value="0">
                                <input type="checkbox" x-model="field.is_required"
                                    :name="'fields[' + index + '][is_required]'" value="1"
                                    class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                            </label>

                            <div class="h-6 w-px bg-gray-200"></div>

                            <button type="button" @click="removeField(index)"
                                class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-full transition"
                                title="Hapus Pertanyaan">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="mt-6 flex justify-center">
                <button type="button" @click="addField()"
                    class="flex items-center gap-2 bg-white border-2 border-dashed border-indigo-300 text-indigo-600 px-6 py-3 rounded-xl hover:bg-indigo-50 hover:border-indigo-500 transition font-semibold w-full justify-center">
                    <i class="ri-add-circle-line text-xl"></i> Tambah Pertanyaan
                </button>
            </div>

            <div
                class="mt-10 pt-6 border-t border-gray-200 flex justify-end gap-4 sticky bottom-0 bg-gray-50 p-4 rounded-t-xl shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-10">
                <a href="#" class="px-6 py-2.5 rounded-lg text-gray-600 font-medium hover:bg-gray-200 transition">
                    Batal
                </a>
                <button type="submit"
                    class="bg-indigo-600 text-white px-8 py-2.5 rounded-lg hover:bg-indigo-700 transition shadow-lg font-bold flex items-center gap-2">
                    <i class="ri-save-line"></i> Simpan Form
                </button>
            </div>

        </form>
    </div>

    <script>
        function formBuilder() {
            return {
                // Array fields bawaan (1 pertanyaan kosong)
                fields: [{
                    id: Date.now(),
                    label: '',
                    type: 'text',
                    is_required: false
                }],

                // Fungsi tambah pertanyaan
                addField() {
                    this.fields.push({
                        id: Date.now(), // Generate ID unik sementara
                        label: '',
                        type: 'text',
                        is_required: false
                    });
                },

                // Fungsi hapus pertanyaan
                removeField(index) {
                    // Mencegah menghapus jika sisa 1 pertanyaan
                    if (this.fields.length > 1) {
                        this.fields.splice(index, 1);
                    } else {
                        alert('Form harus memiliki minimal 1 pertanyaan.');
                    }
                }
            }
        }
    </script>
@endsection
