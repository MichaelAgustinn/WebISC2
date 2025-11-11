@extends('admin.layouts.master')

@section('title', 'Buat Surat Peminjaman')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Form Input /</span> Surat Peminjaman
        </h4>

        <div class="row">
            <form action="{{ route('letters.peminjaman.store') }}" method="POST">
                @csrf
                <div class="col-md-12">
                    <div class="card mb-4">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <h5 class="card-header">Form Surat Peminjaman</h5>
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">Nomor Surat</label>
                                <input type="text" name="nomor_surat" class="form-control"
                                    placeholder="Contoh: 006/PT/ISC/XI/2025" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Perihal</label>
                                <input type="text" name="perihal" class="form-control"
                                    placeholder="Contoh: Peminjaman Tempat / Peminjaman Alat" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tempat / Orang Tujuan</label>
                                <input type="text" name="tujuan" class="form-control"
                                    placeholder="Contoh: Kepala UPT TIK Universitas Sulawesi Barat" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Atas Dasar Kegiatan</label>
                                <input type="text" name="dasar_kegiatan" class="form-control"
                                    placeholder="Contoh: Workshop Divisi UI/UX" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Tempat / Barang</label>
                                <input type="text" name="nama_tempat_barang" class="form-control"
                                    placeholder="Contoh: Laboratorium ICT / Laptop / Proyektor" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hari Peminjaman</label>
                                <input type="text" name="hari" class="form-control"
                                    placeholder="Contoh: Minggu, 9 November 2025" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jam Peminjaman</label>
                                <input type="text" name="jam" class="form-control"
                                    placeholder="Contoh: 09.00 WITA - Selesai" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Surat Dibuat</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Ketua Umum</label>
                                <input type="text" name="nama_ketua" class="form-control"
                                    placeholder="Contoh: Ahmad Khanif Izzah Arifin" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Generate Surat</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
