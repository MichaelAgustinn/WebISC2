@extends('layouts.app')

@section('title', 'Rekap Jawaban: ' . $form->title)

@section('content')
    <div class="max-w-7xl mx-auto py-8">

        <div class="mb-6 flex justify-between items-center border-b border-gray-200 pb-4">
            <div>
                <a href="{{ route('forms.index') }}"
                    class="mb-5 inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 bg-white border border-indigo-600 rounded-lg hover:bg-indigo-50 transition">
                    <i class="ri-arrow-left-line mr-2"></i> Kembali ke Daftar Formulir
                </a>

                <h1 class="text-2xl font-bold text-gray-800">
                    Respon: <span class="text-indigo-600">{{ $form->title }}</span>
                </h1>
                <p class="text-sm text-gray-500 mt-1">Total: {{ $form->responses->count() }} Responden</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

            @if ($form->responses->count() > 0)
                <div class="overflow-x-auto pb-4 custom-scrollbar">
                    <table class="w-full text-left border-collapse whitespace-nowrap min-w-max">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-sm">
                                <th
                                    class="px-6 py-4 font-semibold text-gray-700 border-r border-gray-200 bg-gray-100 md:sticky md:left-0 z-10">
                                    No</th>

                                <th class="px-6 py-4 font-semibold text-gray-700 border-r border-gray-200 bg-gray-100">Waktu
                                    Submit</th>
                                <th class="px-6 py-4 font-semibold text-gray-700 border-r border-gray-200 bg-gray-100">Nama
                                    Pengisi</th>

                                @foreach ($form->fields as $field)
                                    <th class="px-6 py-4 font-semibold text-gray-700 border-r border-gray-100 max-w-xs truncate"
                                        title="{{ $field->label }}">
                                        {{ $field->label }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @foreach ($form->responses as $index => $response)
                                <tr class="hover:bg-indigo-50/30 transition">

                                    <td
                                        class="px-6 py-4 border-r border-gray-100 font-medium text-gray-500 bg-white md:sticky md:left-0 z-10 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)]">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="px-6 py-4 border-r border-gray-100 text-gray-600 bg-white">
                                        {{ $response->created_at->format('d M Y, H:i') }}
                                    </td>

                                    <td class="px-6 py-4 border-r border-gray-200 font-bold text-indigo-700 bg-white">
                                        {{ $response->user ? $response->user->name : 'Anonim / Tamu' }}
                                    </td>

                                    @foreach ($form->fields as $field)
                                        @php
                                            $answer = $response->answers->where('form_field_id', $field->id)->first();
                                        @endphp

                                        <td class="px-6 py-4 border-r border-gray-100 max-w-sm truncate">
                                            @if ($answer)
                                                @if ($field->type === 'file' && $answer->answer_file)
                                                    <a href="{{ asset($answer->answer_file) }}" target="_blank"
                                                        class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 bg-blue-50 px-3 py-1 rounded-md font-medium border border-blue-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                                            </path>
                                                        </svg>
                                                        Lihat File
                                                    </a>
                                                @else
                                                    <span class="text-gray-700" title="{{ $answer->answer_text }}">
                                                        {{ Str::limit($answer->answer_text, 50, '...') }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-gray-300 italic">- Kosong -</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-20 text-center flex flex-col items-center">
                    <div class="bg-gray-50 text-gray-400 p-4 rounded-full mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700">Belum Ada Respon</h3>
                    <p class="text-gray-500 mt-1">Formulir ini belum menerima tanggapan dari siapapun.</p>
                    <a href="{{ route('landing.forms.show', $form->slug) }}" target="_blank"
                        class="mt-4 text-indigo-600 font-medium hover:underline">
                        Lihat & Bagikan Link Formulir
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection
