@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="{{ route('posts.manage') }}"
                class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 transition mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Artikel
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Edit Artikel</h1>
        </div>

        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="postForm">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 min-h-[500px]">

                        <div class="mb-6">
                            <input type="text" name="title" value="{{ old('title', $post->title) }}"
                                class="w-full border-0 border-b-2 border-gray-100 focus:border-indigo-500 focus:ring-0 text-3xl font-bold text-gray-800 placeholder-gray-300 px-0 py-3 transition"
                                placeholder="Judul Artikel..." required autocomplete="off">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori (Tags)</label>

                            <div class="flex flex-wrap items-center gap-2 p-2 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 bg-white min-h-[46px] cursor-text"
                                onclick="document.getElementById('tagInput').focus()">

                                <div id="tagContainer" class="flex flex-wrap gap-2"></div>

                                <input type="text" id="tagInput"
                                    class="flex-1 border-none focus:ring-0 p-1 text-sm min-w-[120px] outline-none bg-transparent"
                                    placeholder="Ketik & Enter..." autocomplete="off">
                            </div>

                            @php
                                $existingTags = '';
                                if ($errors->any()) {
                                    $existingTags = old('categories_input');
                                } elseif ($post->categories && $post->categories->count() > 0) {
                                    $existingTags = $post->categories->pluck('name')->implode(',');
                                }
                            @endphp
                            <input type="hidden" name="categories_input" id="hiddenCategories" value="{{ $existingTags }}">

                            <p class="text-xs text-gray-400 mt-1">*Pisahkan dengan <b>Enter</b> atau <b>Koma</b>. Klik X
                                untuk menghapus tag.</p>
                        </div>

                        <div class="w-full">
                            <textarea name="description" id="editor"
                                class="w-full w-full border-0 focus:ring-0 text-lg text-gray-600 leading-relaxed placeholder-gray-300 px-0 resize-none min-h-[60vh]"
                                placeholder="Mulailah menulis cerita Anda di sini..." required>{{ old('description', $post->description) }}</textarea>
                        </div>

                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sticky top-6 z-10">
                        <h3 class="font-semibold text-gray-800 mb-4 border-b pb-2">Publikasi</h3>

                        <div class="text-sm text-gray-500 mb-4 space-y-2">
                            <div class="flex justify-between">
                                <span>Status:</span>
                                <span class="font-medium text-green-600">Published</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Terakhir Update:</span>
                                <span class="font-medium text-gray-800">{{ $post->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button type="submit"
                                class="w-full py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition shadow-sm flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('posts.manage') }}"
                                class="w-full py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition text-center">
                                Batal
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h3 class="font-semibold text-gray-800 mb-4">Gambar Unggulan</h3>

                        <div class="relative group">
                            <div id="image-preview"
                                class="{{ $post->thumbnail ? '' : 'hidden' }} aspect-video w-full rounded-lg bg-gray-100 bg-center bg-cover border border-gray-200 mb-3 relative overflow-hidden"
                                style="background-image: url('{{ $post->thumbnail ? asset($post->thumbnail) : '' }}')">

                                <button type="button" onclick="removeImage()"
                                    class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full shadow-md hover:bg-red-600 transition"
                                    title="Hapus Gambar">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <label for="thumbnail-upload" id="upload-box"
                                class="{{ $post->thumbnail ? 'hidden' : 'flex' }} flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik ganti</span> atau
                                        drag & drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG (Max. 2MB)</p>
                                </div>
                                <input id="thumbnail-upload" name="thumbnail" type="file" class="hidden"
                                    accept="image/*" onchange="previewImage(event)" />
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // --- 1. LOGIKA MULTI-TAGS ---
        const tagContainer = document.getElementById('tagContainer');
        const tagInput = document.getElementById('tagInput');
        const hiddenInput = document.getElementById('hiddenCategories');

        // Init: Load tags from hidden input
        let tags = hiddenInput.value ? hiddenInput.value.split(',').filter(t => t.trim() !== '') : [];
        renderTags();

        tagInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                const val = tagInput.value.trim().replace(',', '');

                if (val && !tags.includes(val)) {
                    tags.push(val);
                    renderTags();
                    tagInput.value = '';
                } else if (tags.includes(val)) {
                    tagInput.value = ''; // Reset duplicate
                }
            } else if (e.key === 'Backspace' && tagInput.value === '' && tags.length > 0) {
                tags.pop();
                renderTags();
            }
        });

        function renderTags() {
            tagContainer.innerHTML = '';
            tags.forEach((tag, index) => {
                const tagEl = document.createElement('span');
                tagEl.className =
                    'bg-indigo-100 text-indigo-800 text-sm font-semibold px-3 py-1 rounded-full flex items-center gap-1 border border-indigo-200';
                tagEl.innerHTML = `
                    ${tag}
                    <button type="button" onclick="removeTag(${index})" class="text-indigo-500 hover:text-indigo-700 focus:outline-none flex items-center justify-center w-4 h-4 rounded-full hover:bg-indigo-200 transition ml-1">
                        &times;
                    </button>
                `;
                tagContainer.appendChild(tagEl);
            });
            hiddenInput.value = tags.join(',');
        }

        window.removeTag = function(index) {
            tags.splice(index, 1);
            renderTags();
        }

        // --- 2. AUTO RESIZE TEXTAREA ---
        const textarea = document.getElementById('editor');

        function resizeTextarea() {
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        }
        window.addEventListener('load', resizeTextarea);
        textarea.addEventListener('input', resizeTextarea);

        // --- 3. IMAGE PREVIEW ---
        function previewImage(event) {
            const input = event.target;
            const previewBox = document.getElementById('image-preview');
            const uploadBox = document.getElementById('upload-box');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewBox.style.backgroundImage = `url('${e.target.result}')`;
                    previewBox.classList.remove('hidden');
                    uploadBox.classList.add('hidden');
                    uploadBox.classList.remove('flex');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            const input = document.getElementById('thumbnail-upload');
            const previewBox = document.getElementById('image-preview');
            const uploadBox = document.getElementById('upload-box');
            input.value = '';
            previewBox.style.backgroundImage = '';
            previewBox.classList.add('hidden');
            uploadBox.classList.remove('hidden');
            uploadBox.classList.add('flex');
        }
    </script>
@endsection
