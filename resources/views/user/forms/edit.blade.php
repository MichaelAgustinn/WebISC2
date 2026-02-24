@extends('layouts.app')

@section('title', 'Edit Form')

@section('content')
    <div x-data="formBuilder(@js($form->fields))" class="max-w-4xl mx-auto pb-10">

        <div class="mb-6 flex justify-between items-center border-b border-gray-200 pb-4">
            <div>
                <a href="{{ route('forms.index') }}"
                    class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 transition mb-2">
                    <i class="ri-arrow-left-line mr-1"></i> Kembali ke Daftar
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Edit Formulir</h1>
            </div>
        </div>

        <form action="{{ route('forms.update', $form->id) }}" method="POST" id="dynamicForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 border-t-4 border-t-indigo-600">

                <div class="mb-6 pb-6 border-b border-gray-100">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="ri-image-edit-line mr-1"></i> Thumbnail / Cover Form
                    </label>

                    @if ($form->cover_image)
                        <div class="mb-3">
                            <img src="{{ asset($form->cover_image) }}" alt="Cover"
                                class="h-40 w-full object-cover rounded-lg border border-gray-200 shadow-sm">
                            <p class="text-xs text-green-600 mt-1 font-semibold"><i class="ri-check-line"></i> Gambar cover
                                saat ini.</p>
                        </div>
                    @endif

                    <input type="file" name="cover_image" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-dashed border-gray-300 p-4 rounded-lg bg-gray-50 cursor-pointer">
                    <p class="text-xs text-gray-400 mt-2">Abaikan jika tidak ingin mengganti gambar. Format: JPG, PNG.</p>
                </div>

                <div class="mb-4">
                    <input type="text" name="title" required value="{{ old('title', $form->title) }}"
                        class="w-full border-0 border-b-2 border-gray-200 focus:border-indigo-600 focus:ring-0 text-3xl font-bold text-gray-800 px-0 py-2 transition"
                        placeholder="Judul Formulir">
                </div>
                <div>
                    <textarea name="description" rows="2"
                        class="w-full border-0 border-b border-gray-200 focus:border-indigo-600 focus:ring-0 text-sm text-gray-600 px-0 py-2 transition"
                        placeholder="Deskripsi formulir...">{{ old('description', $form->description) }}</textarea>
                </div>
            </div>

            <div id="fields-container" class="space-y-6">
                <template x-for="(field, index) in fields" :key="field.id">
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 relative group transition-all duration-300 hover:shadow-md pt-10">

                        <input type="hidden" :name="'fields[' + index + '][id]'" :value="field.id">

                        <button type="button" @click="removeField(index)"
                            class="absolute top-3 right-3 text-gray-400 hover:text-white hover:bg-red-500 p-1.5 rounded-md transition flex items-center justify-center gap-1 text-xs font-bold"
                            title="Hapus Pertanyaan ini">
                            <i class="ri-close-line text-lg leading-none"></i>
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">

                            <div class="md:col-span-8 space-y-3">
                                <input type="text" x-model="field.label" :name="'fields[' + index + '][label]'" required
                                    class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-medium"
                                    placeholder="Tulis Pertanyaan...">

                                <template x-if="field.image">
                                    <div class="mt-2 p-2 border rounded bg-gray-50 inline-block">
                                        <img :src="'{{ asset('') }}' + field.image" class="h-24 object-contain rounded">
                                        <div class="text-[10px] text-gray-500 mt-1">Gambar Soal saat ini.</div>
                                    </div>
                                </template>

                                <div class="flex items-center gap-2 mt-2">
                                    <i class="ri-image-line text-gray-400 text-xl"></i>
                                    <input type="file" :name="'fields[' + index + '][image]'" accept="image/*"
                                        class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                                </div>
                            </div>

                            <div class="md:col-span-4">
                                <select x-model="field.type" :name="'fields[' + index + '][type]'"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm font-medium text-gray-700">
                                    <option value="text">Jawaban Singkat</option>
                                    <option value="textarea">Paragraf Panjang</option>
                                    <option value="number">Hanya Angka</option>
                                    <option value="date">Tanggal</option>
                                    <option value="file">Responden Upload File</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-5 mb-2">
                            <div x-show="field.type === 'text' || field.type === 'number'"
                                class="border-b border-dotted border-gray-300 w-1/2 pb-1 text-gray-400 text-sm">Teks jawaban
                                singkat</div>
                            <div x-show="field.type === 'textarea'"
                                class="border-b border-dotted border-gray-300 w-3/4 pb-1 mt-4 text-gray-400 text-sm">Teks
                                jawaban panjang</div>
                            <div x-show="field.type === 'file'"
                                class="mt-2 text-gray-500 bg-gray-50 p-3 rounded border border-dashed flex items-center gap-2 w-max text-sm">
                                <i class="ri-upload-cloud-2-line"></i> Tombol Upload File</div>
                            <div x-show="field.type === 'date'"
                                class="mt-2 text-gray-500 bg-gray-50 px-3 py-1.5 rounded border w-max flex items-center gap-2 text-sm">
                                <i class="ri-calendar-line"></i> dd/mm/yyyy</div>
                        </div>

                        <div class="flex justify-end pt-3 mt-3 border-t border-gray-100">
                            <label
                                class="flex items-center gap-2 cursor-pointer text-sm text-gray-700 font-bold bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                                <span x-text="field.is_required ? 'Wajib Diisi' : 'Opsional'"></span>
                                <input type="hidden" :name="'fields[' + index + '][is_required]'" value="0">
                                <input type="checkbox" x-model="field.is_required" :name="'fields[' + index + '][is_required]'"
                                    value="1"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                            </label>
                        </div>
                    </div>
                </template>
            </div>

            <div class="mt-6 flex justify-center">
                <button type="button" @click="addField()"
                    class="flex items-center gap-2 bg-white border-2 border-dashed border-indigo-400 text-indigo-600 px-6 py-4 rounded-xl hover:bg-indigo-50 hover:border-indigo-600 transition font-bold w-full justify-center shadow-sm">
                    <i class="ri-add-circle-fill text-2xl"></i> Tambah Pertanyaan Baru
                </button>
            </div>

            <div
                class="mt-10 pt-6 border-t border-gray-200 flex justify-end gap-4 sticky bottom-0 bg-gray-50 p-4 rounded-t-xl shadow-[0_-4px_10px_-1px_rgba(0,0,0,0.05)] z-10">
                <a href="{{ route('forms.index') }}"
                    class="px-6 py-2.5 rounded-lg text-gray-600 font-bold hover:bg-gray-200 transition">
                    Batal
                </a>
                <button type="submit"
                    class="bg-indigo-600 text-white px-8 py-2.5 rounded-lg hover:bg-indigo-700 transition shadow-lg font-bold flex items-center gap-2">
                    <i class="ri-save-line"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

    <script>
        function formBuilder(initialFields) {
            return {
                fields: initialFields && initialFields.length > 0 ? initialFields : [{
                    id: Date.now(),
                    label: '',
                    type: 'text',
                    is_required: false,
                    image: null
                }],

                addField() {
                    this.fields.push({
                        id: Date.now(),
                        label: '',
                        type: 'text',
                        is_required: false,
                        image: null
                    });
                },

                removeField(index) {
                    if (this.fields.length > 1) {
                        this.fields.splice(index, 1);
                    } else {
                        alert('Form harus memiliki minimal 1 pertanyaan!');
                    }
                }
            }
        }
    </script>
@endsection
