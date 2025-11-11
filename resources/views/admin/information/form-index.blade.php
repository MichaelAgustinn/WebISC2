@extends('admin.layouts.master')

@section('title', 'Informasi File')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            {{-- Notifikasi sukses --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h5 class="card-header d-flex justify-content-between align-items-center">
                <span>Daftar File Informasi</span>
                <a href="{{ route('information.create') }}" class="btn btn-primary btn-sm">+ Tambah Data</a>
            </h5>

            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 30%">Nama</th>
                            <th style="width: 30%">File</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($information as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if (Str::endsWith($item->file, ['.jpg', '.jpeg', '.png', '.gif']))
                                        <img src="{{ asset($item->file) }}" style="max-width: 80px;" alt="Preview">
                                    @else
                                        <a href="{{ asset($item->file) }}" target="_blank"
                                            class="btn btn-sm btn-outline-info">
                                            Lihat File
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('information.edit', $item->id) }}">
                                                <i class="bx bx-edit-alt me-2"></i> Edit
                                            </a>
                                            <form action="{{ route('information.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger" type="submit">
                                                    <i class="bx bx-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Tidak ada data ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
