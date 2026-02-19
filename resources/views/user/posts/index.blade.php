@extends('layouts.app')

@section('title', 'Kelola Artikel')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-800">Artikel Saya</h3>
            <a href="{{ route('posts.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tulis Artikel
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-6 py-3">Artikel</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Komentar</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded bg-gray-200 overflow-hidden flex-shrink-0">
                                        @if ($post->thumbnail)
                                            <img src="{{ asset($post->thumbnail) }}" class="w-full h-full object-cover">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                                                No Img</div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800 line-clamp-1">{{ $post->title }}</div>
                                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
                                            class="text-xs text-indigo-500 hover:underline">Lihat di web</a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $post->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded text-xs font-bold">
                                    {{ $post->comments->count() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('posts.edit', $post->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus artikel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-400">Belum ada artikel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $posts->links() }}</div>
    </div>
@endsection
