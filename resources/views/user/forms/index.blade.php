@extends('layouts.app')

@section('title', 'Kelola Form Pendaftaran')

@section('content')
    <div class="max-w-7xl mx-auto py-8">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Formulir</h1>
            <a href="{{ route('forms.create') }}"
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition font-medium flex items-center gap-2">
                <i class="ri-add-line"></i> Buat Form Baru
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold text-gray-700">Judul Formulir</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Jumlah Pertanyaan</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Tgl Dibuat</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-32 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($forms as $form)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <h3 class="font-bold text-gray-800">{{ $form->title }}</h3>
                                <p class="text-sm text-gray-500 truncate max-w-xs">
                                    {{ $form->description ?? 'Tidak ada deskripsi' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                    {{ $form->fields_count }} Item
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $form->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                <a href="{{ route('forms.edit', $form->id) }}"
                                    class="p-2 text-blue-600 bg-blue-50 rounded hover:bg-blue-100 transition"
                                    title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </a>

                                <form action="{{ route('forms.destroy', $form->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus formulir ini beserta semua pertanyaannya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-red-600 bg-red-50 rounded hover:bg-red-100 transition"
                                        title="Hapus">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                Belum ada formulir yang dibuat. <br>
                                <a href="{{ route('forms.create') }}"
                                    class="text-indigo-600 hover:underline mt-2 inline-block">Buat sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $forms->links() }}
        </div>
    </div>
@endsection
