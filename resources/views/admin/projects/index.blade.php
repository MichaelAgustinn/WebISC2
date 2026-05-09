@extends('layouts.app')

@section('title', 'Project Verification')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Project Verification</h1>
            <p class="text-gray-500 text-sm">Admin panel for verifying projects.</p>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('projects.index') }}" class="relative w-full md:w-64">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search project title..."
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">

            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Project</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($projects as $project)
                        @php
                            // Deteksi 3 State Status Project
                            $isVerified = $project->status == true;
                            $isRejected = $project->status == false && !is_null($project->rejection_reason);
                            $isPending = $project->status == false && is_null($project->rejection_reason);
                        @endphp

                        <tr class="hover:bg-gray-50">
                            <!-- KOLOM PROJECT -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 flex items-center gap-2">
                                    {{ $project->title }}

                                    {{-- Munculkan titik kuning HANYA jika is_revised = true --}}
                                    @if ($project->is_revised && $project->rejection_reason)
                                        <span class="relative flex h-2.5 w-2.5"
                                            title="Karya telah diperbarui oleh anggota. Cek apakah revisinya sudah sesuai.">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                            <span
                                                class="relative inline-flex rounded-full h-2.5 w-2.5 bg-yellow-500"></span>
                                        </span>
                                    @endif
                                </div>

                                {{-- Tampilkan pesan admin sebelumnya agar admin ingat --}}
                                @if ($project->is_revised && $project->rejection_reason)
                                    <div
                                        class="mt-2 text-[11px] text-yellow-700 bg-yellow-50 p-2 rounded border border-yellow-100 max-w-xs">
                                        <strong>Catatan Anda Sebelumnya:</strong><br>
                                        "{{ $project->rejection_reason }}"
                                    </div>
                                @endif
                            </td>
                            <!-- KOLOM STATUS -->
                            <td class="px-6 py-4 align-top">
                                @if ($isVerified)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Verified
                                    </span>
                                @elseif ($isRejected)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Ditolak / Revisi
                                    </span>
                                    @if (!$project->is_revised)
                                        <div
                                            class="mt-2 text-[11px] text-red-600 bg-red-50 p-2 rounded border border-red-100 max-w-xs">
                                            <strong>Alasan:</strong> {{ $project->rejection_reason }}
                                        </div>
                                    @endif
                                @else
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @endif
                            </td>

                            <!-- KOLOM ACTION -->
                            <td class="px-6 py-4 text-right align-top">
                                <div class="flex items-start justify-end gap-2">

                                    <!-- TOMBOL VERIFY -->
                                    <form action="{{ route('admin.projects.verify', $project) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" {{ $isVerified ? 'disabled' : '' }}
                                            @if (!$isVerified) onclick="return confirm('Yakin ingin verifikasi project ini?')" @endif
                                            class="inline-flex items-center gap-2 font-semibold px-4 py-2 rounded-lg text-sm shadow-sm transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-1
                                            {{ $isVerified
                                                ? 'bg-gray-100 text-gray-400 cursor-not-allowed opacity-75'
                                                : 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-400 cursor-pointer' }}">
                                            ✓ Verify
                                        </button>
                                    </form>

                                    <!-- TOMBOL TOLAK/UNVERIFY -->
                                    <form action="{{ route('admin.projects.unverify', $project) }}" method="POST"
                                        class="inline-block" onsubmit="return promptReason(event, this)">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="rejection_reason" class="reason-input">

                                        <button type="submit" {{ $isRejected ? 'disabled' : '' }}
                                            class="inline-flex items-center gap-2 font-semibold px-4 py-2 rounded-lg text-sm shadow-sm transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-1
                                            {{ $isRejected
                                                ? 'bg-gray-100 text-gray-400 cursor-not-allowed opacity-75'
                                                : 'bg-red-500 hover:bg-red-600 text-white focus:ring-red-400 cursor-pointer' }}">
                                            ✕ Tolak
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-400">
                                No projects found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $projects->withQueryString()->links() }}
        </div>
</div>@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function promptReason(event, form) {
            event.preventDefault();

            Swal.fire({
                title: 'Batalkan Verifikasi?',
                text: "Silakan masukkan alasan kenapa project ini ditolak:",
                icon: 'warning',
                input: 'textarea',
                inputPlaceholder: 'Ketik alasan di sini...',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '✕ Ya, Tolak Project',
                cancelButtonText: 'Batal',
                reverseButtons: true,

                preConfirm: (reason) => {
                    if (!reason || reason.trim() === "") {
                        Swal.showValidationMessage('Alasan penolakan wajib diisi!');
                        return false;
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.querySelector('.reason-input').value = result.value;

                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    form.submit();
                }
            });
        }
    </script>
@endpush
