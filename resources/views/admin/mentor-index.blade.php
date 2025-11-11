@extends('admin.layouts.master')

@section('title', 'Mentors')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <h5 class="card-header">Table Basic</h5>
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
                        @foreach ($mentors as $mentor)
                            <tr>
                                <td>{{ $mentor->id }}</td>
                                <td>{{ $mentor->name }}</td>
                                <td>{{ $mentor->jabatan }}</td>
                                <td><img src="{{ asset($mentor->image) }}" style="max-width: 80px" alt=""></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('mentor.edit', $mentor->id) }}"><i
                                                    class="bx bx-edit-alt me-2"></i>
                                                Edit</a>
                                            <a class="dropdown-item" href="{{ route('mentor.delete', $mentor->id) }}"
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
