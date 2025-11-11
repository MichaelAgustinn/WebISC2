@extends('admin.layouts.master')

@section('title', 'Daftar Surat')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Manajemen Surat /</span> Daftar Surat
            </h4>

            {{-- Tombol Tambah Surat --}}
            <div>
                <a href="{{ route('letters.create') }}" class="btn btn-danger me-2">
                    <i class="bx bx-error-circle me-1"></i> Tambah Surat Peringatan
                </a>
                <a href="{{ route('letters.peminjaman.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus-circle me-1"></i> Tambah Surat Peminjaman
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <h5 class="card-header">Daftar Semua Surat</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Surat</th>
                            <th>Nomor Surat</th>
                            <th>Tanggal</th>
                            <th>Perihal / Detail</th>
                            <th>Nama Ketua</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($letters as $i => $letter)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    @if ($letter->jenis_surat === 'peringatan')
                                        Surat Peringatan {{ $letter->warningDetail->peringatan_ke ?? '-' }}
                                    @elseif ($letter->jenis_surat === 'peminjaman_tempat')
                                        Surat Peminjaman Tempat
                                    @elseif ($letter->jenis_surat === 'peminjaman_alat')
                                        Surat Peminjaman Alat
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $letter->nomor_surat }}</td>
                                <td>{{ \Carbon\Carbon::parse($letter->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>
                                    @if ($letter->jenis_surat === 'peringatan')
                                        {{ $letter->warningDetail->peringatan_ke ? 'Peringatan ke-' . $letter->warningDetail->peringatan_ke : '-' }}
                                    @elseif (in_array($letter->jenis_surat, ['peminjaman_tempat', 'peminjaman_alat']))
                                        {{ $letter->loanDetail->perihal ?? '-' }} —
                                        {{ $letter->loanDetail->nama_tempat_barang ?? '-' }}
                                    @endif
                                </td>
                                <td>{{ $letter->nama_ketua }}</td>
                                <td>
                                    <a href="{{ route('letters.show', $letter->id) }}" class="btn btn-sm btn-primary"
                                        target="_blank">
                                        <i class="bx bx-file"></i> Lihat
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <a href="{{ route('letters.delete', $letter->id) }}"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?');">
                                        <i class="bx bx-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada surat yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
