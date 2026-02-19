@extends('layouts.app')

@section('title', 'Kelola FAQ')

@section('content')
    <div x-data="{ showModal: false, editMode: false, currentId: null, form: { question: '', answer: '' } }">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Pertanyaan (FAQ)</h1>
            <button @click="showModal = true; editMode = false; form = { question: '', answer: '' }"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
                + Tambah FAQ
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Pertanyaan</th>
                        <th class="px-6 py-4 font-semibold">Jawaban</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($faqs as $faq)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800 w-1/3">{{ $faq->question }}</td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ Str::limit($faq->answer, 100) }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button
                                    @click="showModal = true; editMode = true; currentId = {{ $faq->id }}; form = { question: '{{ addslashes($faq->question) }}', answer: '{{ addslashes($faq->answer) }}' }"
                                    class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</button>

                                <form action="{{ route('faq.destroy', $faq->id) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Hapus FAQ ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-400">Belum ada data FAQ.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <form :action="editMode ? '{{ url('admin/faq') }}/' + currentId : '{{ route('faq.store') }}'"
                        method="POST">
                        @csrf
                        <template x-if="editMode">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4"
                                x-text="editMode ? 'Edit FAQ' : 'Tambah FAQ Baru'"></h3>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Pertanyaan</label>
                                <input type="text" name="question" x-model="form.question"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jawaban</label>
                                <textarea name="answer" x-model="form.answer" rows="4"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                            <button type="button" @click="showModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
