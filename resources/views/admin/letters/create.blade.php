@extends('admin.layouts.master')

@section('title', 'Buat Surat Peringatan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Form Input /</span> Surat Peringatan</h4>

        <div class="row">
            <form action="{{ route('letters.store') }}" method="POST">
                @csrf
                <div class="col-md-12">
                    <div class="card mb-4">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <h5 class="card-header">Form Surat Peringatan</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Surat</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="nomor_surat" class="form-label">Nomor Surat</label>
                                <input type="text" name="nomor_surat" id="nomor_surat" class="form-control"
                                    placeholder="Contoh: 004/SP/ISC/XI/2025" required>
                            </div>

                            <div class="mb-3">
                                <label for="jenis_peringatan" class="form-label">Jenis Peringatan</label>
                                <select name="jenis_peringatan" id="jenis_peringatan" class="form-select" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="1">Surat Peringatan 1</option>
                                    <option value="2">Surat Peringatan 2</option>
                                    <option value="3">Surat Peringatan 3</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="nama_ketua" class="form-label">Nama Ketua Umum</label>
                                <input type="text" name="nama_ketua" id="nama_ketua" class="form-control"
                                    placeholder="Nama Ketua Umum" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pilih Anggota/Pengurus yang Dapat Surat</label>

                                {{-- Input search --}}
                                <input type="text" id="userSearch" class="form-control mb-2"
                                    placeholder="Cari nama anggota/pengurus...">

                                {{-- Daftar user --}}
                                <div id="userList" class="border rounded p-3" style="max-height: 250px; overflow-y: auto;">
                                    @foreach ($users as $user)
                                        <div class="form-check user-item">
                                            <input type="checkbox" class="form-check-input" name="users[]"
                                                value="{{ $user->id }}" id="user_{{ $user->id }}">
                                            <label for="user_{{ $user->id }}" class="form-check-label">
                                                {{ $user->name }} ({{ $user->status }})
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary">Generate Surat</button>
                            <script>
                                document.getElementById('userSearch').addEventListener('keyup', function() {
                                    const query = this.value.toLowerCase();
                                    const items = document.querySelectorAll('.user-item');

                                    items.forEach(item => {
                                        const name = item.textContent.toLowerCase();
                                        item.style.display = name.includes(query) ? '' : 'none';
                                    });
                                });
                            </script>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
