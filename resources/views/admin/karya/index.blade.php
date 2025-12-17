@extends('admin.layouts.master')
@section('title', 'Daftar Karya')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">

            @if (session('success'))
                <div class="alert alert-success m-3">{{ session('success') }}</div>
            @endif

            <h5 class="card-header d-flex justify-content-between align-items-center">
                <span>Daftar Karya</span>
                <a href="{{ route('karya.create') }}" class="btn btn-primary">+ Tambah Karya</a>
            </h5>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Vote</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody class="table-border-bottom-0">
                        @foreach ($karya as $item)
                            <tr>
                                <td>{{ $item->id }}</td>

                                <td>
                                    @if ($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" width="60"
                                            style="border-radius:6px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>

                                <td>{{ $item->judul }}</td>

                                <td>{{ Str::limit($item->deskripsi, 40) }}</td>

                                <td>{{ $item->jumlah_vote }}</td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>

                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('karya.edit', $item->id) }}">
                                                <i class="bx bx-edit-alt me-2"></i> Edit
                                            </a>

                                            <form action="{{ route('karya.delete', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus karya ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger">
                                                    <i class="bx bx-trash me-2"></i> Hapus
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>
@endsection
