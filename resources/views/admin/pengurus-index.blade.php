@extends('admin.layouts.master')

@section('title', 'Pengurus')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <h5 class="card-header">Daftar Pengurus</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Foto</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($penguruses as $pengurus)
                            <tr>
                                <td>{{ $pengurus->id }}</td>
                                <td>{{ $pengurus->name }}</td>
                                <td>{{ $pengurus->jabatan }}</td>
                                <td><img src="{{ asset($pengurus->image) }}" style="max-width: 80px" alt=""></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('pengurus.edit', $pengurus->id) }}"><i
                                                    class="bx bx-edit-alt me-2"></i>
                                                Edit</a>
                                            <a class="dropdown-item" href="{{ route('pengurus.delete', $pengurus->id) }}"
                                                onclick="return confirm('Yakin Ingin Menghapus?')"><i
                                                    class="bx bx-trash me-2"></i>
                                                Delete</a>
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
