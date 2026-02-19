@extends('layouts.app')

@section('title', 'Karya Anggota')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <div>
                <h3 class="font-bold text-gray-800 text-lg">Daftar Karya Saya</h3>
                <p class="text-xs text-gray-500">Kelola portofolio yang telah Anda buat.</p>
            </div>
            <a href="{{ route('projects.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 shadow-sm transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Upload Karya
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500 tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Info Karya</th>
                        <th class="px-6 py-3 font-semibold">Divisi</th>
                        <th class="px-6 py-3 font-semibold">Tim</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 transition duration-150">

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="h-12 w-16 flex-shrink-0 rounded-lg bg-gray-200 overflow-hidden border border-gray-200">
                                        @if ($project->image)
                                            <img src="{{ asset('uploads/projects/' . $project->image) }}"
                                                alt="{{ $project->title }}" class="h-full w-full object-cover">
                                        @else
                                            <div
                                                class="h-full w-full flex items-center justify-center text-gray-400 text-xs">
                                                No Img</div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 line-clamp-1">{{ $project->title }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            {{ $project->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ ucwords(str_replace('_', ' ', $project->division)) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center text-gray-500 text-xs">
                                    <svg class="mr-1.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ $project->users->count() }} Anggota
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="flex items-center gap-1.5 text-green-600 text-xs font-bold bg-green-50 px-2 py-1 rounded border border-green-100 w-fit">
                                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                    Published
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right whitespace-nowrap">

                                <a href="{{ route('projects.edit', $project->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 font-medium text-sm mr-3 transition">
                                    Edit
                                </a>

                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus karya ini? Data tidak bisa dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 font-medium text-sm transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <p class="text-sm">Belum ada karya yang diupload.</p>
                                    <a href="{{ route('projects.create') }}"
                                        class="mt-2 text-indigo-600 hover:underline text-sm font-medium">Mulai Upload
                                        Sekarang</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $projects->links() }}
        </div>
    </div>
@endsection
