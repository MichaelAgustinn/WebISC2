@extends('layouts.app')

@section('content')
    <!-- SECTION 1: STATUS AKUN (Jika Dinonaktifkan) -->
    @if (Auth::user()->reject_reason)
        <div class="bg-white rounded-xl border-2 border-red-500 shadow-md p-6 flex flex-col relative overflow-hidden mb-6">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-red-50 rounded-full z-0 opacity-50"></div>

            <div class="relative z-8 flex items-center gap-4 mb-4">
                <div class="p-3 bg-red-100 rounded-full text-red-600">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-black text-red-700 text-lg uppercase tracking-tight">Akun Dinonaktifkan</h4>
                    <p class="text-xs text-red-500">Akses fitur Anda telah dibatasi oleh admin.</p>
                </div>
            </div>

            <div class="relative z-8 bg-red-50 rounded-xl p-4 border border-red-200">
                <p class="text-xs font-bold text-red-800 mb-2 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Alasan Penonaktifan:
                </p>
                <p class="text-sm text-red-700 leading-relaxed font-medium italic">
                    "{{ Auth::user()->reject_reason }}"
                </p>
            </div>
        </div>
    @endif

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'pengurus')
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <p class="text-gray-500 text-sm font-medium">Akun Terdaftar</p>
                <h3 class="text-2xl font-bold text-green-600">{{ $totalAkun ?? '0' }}</h3>
            </div>
        @endif

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm font-medium">
                {{ Auth::user()->role == 'admin' || Auth::user()->role == 'pengurus' ? 'Anggota Aktif' : 'Semua Anggota' }}
            </p>
            <h3 class="text-2xl font-bold text-red-600">{{ $totalAnggota + $totalPengurus ?? '0' }}</h3>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm font-medium">Total Pengurus</p>
            <h3 class="text-2xl font-bold text-indigo-600">{{ $totalPengurus ?? '0' }}</h3>
        </div>

        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'pengurus')
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <p class="text-gray-500 text-sm font-medium">Semua Karya</p>
                <h3 class="text-2xl font-bold text-blue-600">{{ $totalProject ?? '0' }}</h3>
            </div>
        @endif

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm font-medium">Karya Tervalidasi</p>
            <h3 class="text-2xl font-bold text-yellow-600">{{ $projectAktif ?? '0' }}</h3>
        </div>
    </div>

    <!-- SECTION 2: KARYA BUTUH REVISI (Hanya untuk Pemilik Karya) -->
    @if (isset($pendingProjects) && count($pendingProjects) > 0)
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Perlu Perhatian: Karya Ditolak / Butuh Revisi
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach ($pendingProjects as $rejected)
                    <div
                        class="bg-white rounded-xl border-l-4 border-l-red-500 shadow-sm p-5 flex flex-col h-full relative overflow-hidden group">
                        <div class="relative z-10 flex justify-between items-start mb-2">
                            <h4 class="font-bold text-gray-800 line-clamp-1 pr-2" title="{{ $rejected->title }}">
                                {{ $rejected->title }}</h4>
                            <span
                                class="text-[10px] bg-red-100 text-red-700 px-2 py-1 rounded font-bold uppercase tracking-wider whitespace-nowrap">Revisi</span>
                        </div>
                        <p class="relative z-8 text-xs text-gray-500 mb-4 flex items-center gap-1 font-medium">
                            Disubmit: {{ $rejected->created_at->format('d M Y') }}
                        </p>
                        <div class="relative z-8 bg-red-50 rounded-lg p-3 flex-grow mb-4 border border-red-100">
                            <p class="text-xs font-semibold text-red-800 mb-1 flex items-center gap-1">Pesan Admin:</p>
                            <p class="text-sm text-red-600 italic">"{{ $rejected->rejection_reason }}"</p>
                        </div>
                        <a href="{{ route('projects.edit', $rejected->id) }}"
                            class="relative z-8 block w-full text-center bg-white border border-red-500 text-red-600 hover:bg-red-50 text-sm font-bold py-2 rounded-lg transition-colors">
                            Perbaiki Karya
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- SECTION 3: TABEL & TOP TYPIST -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'pengurus')
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-fit">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-semibold text-gray-800">Karya Terbaru</h3>
                    <a href="{{ route('admin.projects.all') }}"
                        class="text-indigo-600 text-sm font-medium hover:underline">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-6 py-3 font-medium">Judul Karya</th>
                                <th class="px-6 py-3 font-medium">Divisi</th>
                                <th class="px-6 py-3 font-medium">Creator</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($recentProjects as $recentProject)
                                @php
                                    // Logika titik kuning untuk Admin
                                    $isRevised = $recentProject->is_revised == true;
                                    $isPending = $recentProject->status == false;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <div class="flex items-center gap-2">
                                            {{ $recentProject->title }}
                                            @if ($isPending && $isRevised)
                                                <span class="relative flex h-2 w-2" title="User sudah memperbaiki karya">
                                                    <span
                                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                                    <span
                                                        class="relative inline-flex rounded-full h-2 w-2 bg-yellow-500"></span>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="px-2 py-1 bg-purple-50 text-purple-600 rounded text-xs font-semibold">{{ ucwords(str_replace('_', ' ', $score->user->profile->division)) ?? '' }}</span>
                                    </td>
                                    <td class="px-6 py-4">{{ $recentProject->owner->name ?? '' }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="{{ $recentProject->status == true ? 'text-green-600' : 'text-gray-500' }} text-sm font-bold">
                                            {{ $recentProject->status == true ? 'Verified' : 'Unverified' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- TOP TYPIST (Weekly) -->
        <div
            class="{{ Auth::user()->role == 'admin' || Auth::user()->role == 'pengurus' ? 'lg:col-span-1' : 'lg:col-span-3' }}">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4 border-b border-indigo-700 flex justify-between items-center">
                    <h3 class="text-white font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 00-.565.734c-.378 1.58-1.789 2.768-3.465 2.871-.16.01-.321.014-.483.014-2.502 0-4.55-2.048-4.55-4.55 0-.256.02-.507.06-.75a1 1 0 00-.566-.735A3.989 3.989 0 011 15c0-1.685 1.047-3.132 2.533-3.692L5.27 5.888 4.037 5.272a1 1 0 01.894-1.789l1.598.799L10.5 2.7V2a1 1 0 01-.5-.866zM5.312 9.51l.888 2.77a2.985 2.985 0 01-1.2-2.77zM14.688 9.51l-.888 2.77a2.985 2.985 0 011.2-2.77z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Top Typist (Weekly)
                    </h3>
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($weeklyTop as $score)
                        <div
                            class="flex items-center px-5 py-4 {{ $loop->iteration == 1 ? 'bg-yellow-50/50 hover:bg-yellow-50' : 'hover:bg-gray-50' }} transition duration-150">
                            <div class="flex-shrink-0 w-8 text-center">
                                <span
                                    class="text-{{ $loop->iteration <= 3 ? '2xl' : 'sm' }} font-bold {{ $loop->iteration == 1 ? 'text-yellow-500' : ($loop->iteration == 2 ? 'text-gray-400' : ($loop->iteration == 3 ? 'text-orange-700/70' : 'text-gray-400')) }} italic">
                                    {{ $loop->iteration }}
                                </span>
                            </div>
                            <div class="flex-shrink-0 mx-3 relative">
                                <img class="h-10 w-10 rounded-full border-2 {{ $loop->iteration == 1 ? 'border-yellow-300' : 'border-gray-200' }} object-cover"
                                    src="{{ $score->user->profile && $score->user->profile->photo ? asset('uploads/profiles/' . $score->user->profile->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($score->user->name) . '&background=0f204b&color=fff' }}"
                                    alt="">
                                @if ($loop->iteration == 1)
                                    <div
                                        class="absolute -top-2 -right-1 text-yellow-500 bg-white rounded-full shadow-sm p-0.5">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate">
                                    {{ Str::limit($score->user->name, 20) }}</p>
                                <p class="text-xs text-gray-500 truncate">
                                    {{ ucwords(str_replace('_', ' ', $score->user->profile->division)) ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="block text-lg font-bold text-gray-800">{{ $score->wpm }}</span>
                                <span class="text-[10px] text-gray-400 font-semibold uppercase">WPM</span>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center justify-center px-5 py-6 text-gray-400 text-sm">Belum ada skor minggu
                            ini.</div>
                    @endforelse
                </div>
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 text-center">
                    <a href="{{ route('typing.index') }}"
                        class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                        {{ Auth::user()->role == 'admin' || Auth::user()->role == 'pengurus' ? 'Lihat Seluruh Peringkat &rarr;' : 'Mulai Test Mengetik &rarr;' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
